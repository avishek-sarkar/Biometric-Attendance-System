# Biometric Attendance Management System

A comprehensive web-based attendance tracking system that uses biometric fingerprint authentication to ensure secure and accurate attendance recording for educational institutions.

## Overview

The Biometric Attendance Management System simplifies attendance tracking by integrating fingerprint-based biometric authentication with a user-friendly web interface. This system is designed for both students and teachers, providing real-time attendance monitoring, course management, and comprehensive reporting capabilities.

## Features

### For Students
- **Secure Registration**: Easy registration process with email verification
- **Biometric Authentication**: Fingerprint-based attendance marking to prevent proxy attendance
- **Dashboard Access**: View personal attendance records and statistics
- **Course Enrollment**: Track attendance across multiple enrolled courses
- **Password Management**: Secure password reset and change functionality

### For Teachers
- **Course Management**: Create and manage multiple courses
- **Attendance Monitoring**: Real-time tracking of student attendance
- **Student Management**: View and manage enrolled students
- **Reporting Tools**: Generate attendance reports and analytics
- **Email Notifications**: Automated notifications for attendance-related activities

### For Administrators
- **User Verification**: Email-based verification for new registrations
- **Data Security**: Secure handling of biometric and personal data
- **Database Management**: Centralized database for all attendance records

## Technology Stack

### Backend
- **PHP**: Server-side scripting and business logic
- **MySQL**: Database management (MariaDB compatible)
- **PHPMailer**: Email notification system

### Frontend
- **HTML5**: Structure and content
- **CSS3**: Styling and responsive design
- **JavaScript**: Client-side interactivity
- **Bootstrap 5.3**: Responsive UI framework
- **Font Awesome**: Icon library

### Hardware Integration
- **Fingerprint Sensor**: Biometric authentication device
- **ESP32/Arduino**: Microcontroller for sensor communication

## Installation

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher (or MariaDB 10.4+)
- Apache/Nginx web server
- XAMPP/WAMP/LAMP (recommended for local development)
- Fingerprint sensor module (for biometric functionality)

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone https://github.com/avishek-sarkar/Biometric-Attendance-System.git
   cd Biometric-Attendance-System
   ```

2. **Database Setup**
   - Create a new MySQL database named `attendancesystem`
   - Import the SQL schema:
     ```bash
     mysql -u root -p attendancesystem < models/attendancesystem.sql
     ```
   - Or use phpMyAdmin to import `models/attendancesystem.sql`

3. **Configure Database Connection**
   - Edit `config/db_config.php` with your database credentials:
     ```php
     $host = 'localhost';
     $dbname = 'attendancesystem';
     $username = 'your_username';
     $password = 'your_password';
     ```

4. **Configure Email Settings**
   - Update PHPMailer configuration in the controllers for email notifications
   - Set up SMTP credentials for sending verification emails

5. **Deploy to Web Server**
   - Copy all files to your web server's document root (e.g., `htdocs` for XAMPP)
   - Ensure proper file permissions are set

6. **Access the Application**
   - Open your browser and navigate to `http://localhost/Biometric-Attendance-System/`
   - Register as a student or teacher to get started

## Usage

### Student Registration and Login
1. Navigate to the home page
2. Click "Register as Student"
3. Fill in the registration form with your details
4. Verify your email address
5. Complete fingerprint enrollment
6. Login to access your dashboard

### Teacher Registration and Login
1. Navigate to the home page
2. Click "Register as Teacher"
3. Complete the registration form
4. Verify your email address
5. Login to access the teacher dashboard
6. Create and manage courses

### Marking Attendance
- Students can mark attendance by scanning their fingerprint at the designated sensor
- The system automatically records the attendance with timestamp
- Attendance is reflected in real-time on both student and teacher dashboards

## Project Structure

```
Biometric-Attendance-System/
├── config/              # Configuration files
│   └── db_config.php    # Database configuration
├── controllers/         # Business logic and API endpoints
├── core/                # Core system files
├── includes/            # Reusable components
├── models/              # Database schemas
│   └── attendancesystem.sql
├── public/              # Public assets
│   ├── css/             # Stylesheets
│   ├── js/              # JavaScript files
│   └── images/          # Image assets
├── views/               # User interface pages
├── index.php            # Home page
└── README.md            # Project documentation
```

## Security Features

- **Password Hashing**: All passwords are securely hashed before storage
- **Email Verification**: Two-factor authentication via email
- **Biometric Authentication**: Fingerprint-based identity verification
- **Session Management**: Secure session handling for user authentication
- **SQL Injection Prevention**: Prepared statements and parameterized queries
- **XSS Protection**: Input sanitization and output encoding

## Contributing

Contributions are welcome! If you'd like to contribute to this project:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/YourFeature`)
3. Commit your changes (`git commit -m 'Add some feature'`)
4. Push to the branch (`git push origin feature/YourFeature`)
5. Open a Pull Request

## License

This project is open source and available for educational purposes.

## Contact

**Developer**: Avishek Sarkar  
**Email**: avishek1416@gmail.com  
**GitHub**: [@avishek-sarkar](https://github.com/avishek-sarkar)  
**Repository**: [Biometric-Attendance-System](https://github.com/avishek-sarkar/Biometric-Attendance-System)

## Acknowledgments

- Department of CSE, JKKNIU
- All contributors and developers who have worked on this project

---

*For detailed information about the development team, including contact details and university information, visit [DeveloperInfo.php](DeveloperInfo.php)*