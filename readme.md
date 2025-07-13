# Violet PWM

Violet PWM is a personal password manager designed to securely store website and bank details. This project is protected under a proprietary license. Unauthorized copying or distribution is prohibited.

## Setup Instructions

Follow these steps to set up Violet PWM on your local environment.

### Prerequisites

- PHP 7.4 or higher
- MySQL or MariaDB
- A web server like Apache or Nginx
- [XAMPP](https://www.apachefriends.org/index.html) or similar package for Windows users (optional)

### Step 1: Clone the Repository

Clone the repository to your local machine using the following command:

```bash
git clone https://github.com/yourusername/violet-pwm.git
```
### Step 2: Set Up the Database

    Create a new database in your MySQL or MariaDB server.

    Import the provided SQL file violet_dist.sql to create the required tables. You can do this using the MySQL command line or a tool like phpMyAdmin.

#### Using MySQL Command Line

```bash

mysql -u yourusername -p yourpassword violet_pwm < path/to/violet_dist.sql

Using phpMyAdmin

    Open phpMyAdmin.
    Select or create the violet_pwm database.
    Use the "Import" tab to upload and import violet_dist.sql.
```
### Step 3: Configure the Application

Update the database connection settings.

```php
<?php
// removed the "*_php.dist" to *.php
// dbconnect.php

$dsn = 'mysql:host=localhost;dbname=violetpwm';
$username = 'root';
$password = '';

// functions.php
define('ENCRYPTION_KEY', 'your-secret-key'); // Replace with your own secret key
?>
```
**Linux:** Set the correct file permissions for the project directory.
```bash

chmod -R 755 violet-pwm
```
### Step 4: Run the Application
Start your web server and ensure PHP is running.
Open your web browser and navigate to the project directory, e.g., http://localhost/violet-pwm.

Additional Notes

    Ensure you have openssl extension enabled in your PHP configuration for encryption and decryption.
    If you are using XAMPP, make sure Apache and MySQL services are running.

