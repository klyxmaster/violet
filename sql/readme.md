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

### Step 2: Set Up the Database

    Create a new database in your MySQL or MariaDB server.

    Import the provided SQL file violet_dist.sql to create the required tables. You can do this using the MySQL command line or a tool like phpMyAdmin.

Using MySQL Command Line

bash

mysql -u yourusername -p yourpassword violet_pwm < path/to/violet_dist.sql

Using phpMyAdmin

    Open phpMyAdmin.
    Select or create the violet_pwm database.
    Use the "Import" tab to upload and import violet_dist.sql.

### Step 3: Configure the Application

    update the database connection settings.

php

<?php
// config.php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'yourusername');
define('DB_PASSWORD', 'yourpassword');
define('DB_NAME', 'violet_pwm');

define('ENCRYPTION_KEY', 'your-secret-key'); // Replace with your own secret key
?>

    Set the correct file permissions for the project directory.

bash

chmod -R 755 violet-pwm

### Step 4: Run the Application

    Start your web server and ensure PHP is running.
    Open your web browser and navigate to the project directory, e.g., http://localhost/violet-pwm.

Additional Notes

    Ensure you have openssl extension enabled in your PHP configuration for encryption and decryption.
    If you are using XAMPP, make sure Apache and MySQL services are running.

License

This project is protected under a proprietary license.

vbnet

Proprietary License

Copyright (c) 2024 Richard Scorpio

All rights reserved.

Permission is hereby granted to the recipient of a copy of this software and associated documentation files (the "Software") to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

1. The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
2. The Software or substantial portions of the Software may not be modified, merged, published, distributed, sublicensed, and/or sold without the prior written permission of the copyright holder.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES, OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT, OR OTHERWISE, ARISING FROM, OUT OF, OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

Contact information for permission requests:
Richard Scorpio
rickscorpio@proton.me

Contact

For support or further information, please contact Richard Scorpio at rickscorpio@proton.me.
