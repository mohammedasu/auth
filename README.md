# User Registration and Login System with File Upload (Vanilla PHP)

## Features
- User Registration with secure password hashing
- User Login with session management
- Profile Image Upload during registration
- Frontend and Backend Validation
- System Logging for errors and actions
- API-based Authentication and File Upload
- PSR-12 Coding Standards followed

## File Structure
```
/auth-system/
├── classes/
│   ├── Auth.php
├── config/
│   ├── database.php
    ├── setup.php
├── controllers/
│   ├── AuthController.php
├── helpers/
│   ├── functions.php
    ├── session.php
├── logs/
│   ├── system.log
├── traits/
│   ├── FileUpload.php
├── views/
│   ├── login.php
│   ├── register.php
│   ├── dashboard.php
├── assets/
│   ├── css/
│   │   ├── style.css
│   ├── js/
│   │   ├── script.js
├── uploads/
├── README.md
```

## Setup Instructions
1. Clone the repository or download the source code.
2. Place the files in your local server directory (e.g., `htdocs` for XAMPP).
3. Create a database named `auth_db` and import the provided `setup.sql`.
4. Update `config/database.php` with your database credentials.
5. Ensure the `uploads/` directory has write permissions (`chmod 777 uploads/` on Linux/Mac).
6. Start your local server and access the system via `http://localhost/auth-system/`

## Logging System
- Errors and actions are logged in `logs/system.log`.
- Example log entry:
```
[2025-03-24 14:30:12] ERROR: Database connection failed.
[2025-03-24 14:32:50] INFO: User JohnDoe registered successfully.
```

## Security Considerations
- Uses password hashing with `password_hash()`
- Prepared statements for SQL queries to prevent SQL injection
- Validates user input both on frontend and backend

