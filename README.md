# Violet PWM

Violet PWM is a personal password manager designed to securely store website and bank details. This project is protected under a proprietary license. Unauthorized copying or distribution is prohibited.

# FUTURE UPDATES:
Future updates will be done at sourceforge, only because I like SVN better than GIT. I will from time to time update here. depends on my mood. [Check out my files here](https://sourceforge.net/projects/violetpwm/) This code was last updated June 26, 2024.

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
git clone https://github.com/klyxmaster/violet.git
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
// RENAME CONFIG_PHP.DIST TO CONFIG.PHP
<?php
	// SQL SERVER INFORMATION
	define('HOST', 'localhost');	//DB HOST	
	define('DBNAME', 'violetpwm');	//DB DB NAME
	define('SQLUSER','root');		//DB USER
	define('SQLPASS', '');			//DB PASSWORD
	
	//MISC SETTINGS
	define('ENCRYPTION_KEY', 'YOUR_SECRET_KEY'); // Replace with your own secret key
    // DO NOT CHANGE OR LOOSE ONCE SET, IT CONTROLS LOGIN, WEBSITE/BANK ENCRYPTIONG.
    // YOU LOOSE IT, GAME OVER! THERE IS NOBACK DODOR TO VIOLET!
	define('MAX_PAGES', 8); // How many pages per view of websites and banks
	
	//2FA AUTH
	define('CODE_GEN_MAX', 15); // Max number of 2fa codes to create. 20 is good.
	
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

