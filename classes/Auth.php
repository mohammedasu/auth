<?php
declare(strict_types=1);

require_once '../traits/FileUpload.php';
class Auth {
    use FileUpload;
    
    private mysqli $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Register a new user.
     *
     * @param string $username The username.
     * @param string $email The email address.
     * @param string $password The password.
     * @param array|null $profileImage The profile image to upload.
     *
     * @return array The result of the registration. The key is either 'success' or 'error'.
     *
     * @throws Throwable If there is a database error.
     */
    public function register(string $username, string $email, string $password, ?array $profileImage): array
    {
        try {
            $username = sanitizeInput($username);
            $email = sanitizeInput($email);
            
            $usernameError = validateUsername($username);
            if ($usernameError) {
                return ['error' => $usernameError];
            }

            $emailError = validateEmail($email);
            if ($emailError) {
                return ['error' => $emailError];
            }

            if ($this->userExists($email)) {
                return ['error' => 'User already exists.'];
            }

            $passwordError = validatePassword($password);
            if ($passwordError) {
                return ['error' => $passwordError];
            }

            // Handle File Upload
            $imagePath = $this->uploadFile($profileImage);
            if (isset($imagePath['error'])) {
                return ['error' => $imagePath['error']];
            }

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $register = $this->db->prepare("INSERT INTO users (username, email, password, profile_image) VALUES (?, ?, ?, ?)");
            if (!$register) {
                throw new Exception("Database prepare failed: " . $this->db->error);
            }
            $register->bind_param("ssss", $username, $email, $hashedPassword, $imagePath['path']);
            $register->execute();

            return ['success' => 'User registered successfully.'];
        } catch (Throwable $e) {
            error_log("Registration Error: " . $e->getMessage(), 3, '../logs/system.log');
            return ['error' => 'Something went wrong.'];
        }
    }

    /**
     * Login user
     *
     * @param string $email
     * @param string $password
     * @return array
     */

    public function login(string $email, string $password): array 
    {
        try {
            $login = $this->db->prepare("SELECT id, username, password, profile_image FROM users WHERE email = ?");
            $login->bind_param("s", $email);
            $login->execute();
            $result = $login->get_result();
            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();
                if (password_verify($password, $user['password'])) {
                    $user = ['username' => $user['username'], 'profile_image' => $user['profile_image']];
                    SessionManager::set('user', $user);
                    return ['success' => 'Login successful.'];
                }
            }
            return ['error' => 'Invalid credentials.'];
        } catch (Throwable $e) {
            error_log("Login Error: " . $e->getMessage(), 3, '../logs/system.log');
            return ['error' => 'Something went wrong.'];
        }
    }

    /**
     * Logout user
     *
     * Destroys the user session and redirects the user
     * back to the login page.
     *
     * @return void
     */

    public function logout(): void 
    {
        SessionManager::destroy();
        header('Location: ../views/login.php');
    }

    /**
     * Check if a user exists in the database
     *
     * @param string $email The email address to check
     *
     * @return bool True if the user exists, false otherwise
     */

    private function userExists(string $email):bool 
    {
        $user = $this->db->prepare("SELECT id FROM users WHERE email = ?");
        $user->bind_param("s", $email);
        $user->execute();
        return $user->get_result()->num_rows > 0;
    }
}