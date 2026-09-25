# Form Submission Management System

A simple PHP + MySQL web application for collecting form submissions, sending email notifications, and managing submitted records through an admin dashboard.

## 1. Project Overview

The application provides:

- Public form submission page
- Name, email, contact number, gender and message fields
- "Over 18" confirmation
- Agreement checkbox
- AJAX form submission
- SweetAlert success/error notifications
- MySQL database storage
- Email notification using PHPMailer and Gmail SMTP
- Admin login
- Viewer login
- Admin dashboard for viewing submissions
- CSV export for administrators
- Record deletion for administrators
- Session-based role control

## 2. Technology Stack

| Component | Technology |
|---|---|
| Frontend | HTML5, Bootstrap 4, jQuery, SweetAlert2 |
| Backend | PHP |
| Database | MySQL / MariaDB |
| Email | PHPMailer + Gmail SMTP |
| Authentication | PHP Sessions |
| Export | CSV |
| Web Server | Apache / XAMPP / WAMP / LAMP / Shared Hosting |

## 3. Project Structure

```text
Form Submission/
│
├── index.html
├── submit.php
├── db.php
├── debug_includes.php
├── debug_post.php
├── testmail.php
│
├── admin/
│   ├── login.php
│   ├── dashboard.php
│   ├── delete.php
│   ├── export.php
│   └── logout.php
│
└── mail/
    ├── sendMail.php
    └── src/
        ├── DSNConfigurator.php
        ├── Exception.php
        ├── OAuth.php
        ├── OAuthTokenProvider.php
        ├── PHPMailer.php
        ├── POP3.php
        └── SMTP.php
```

## 4. System Requirements

### Local installation

Install one of the following:

- XAMPP
- WAMP
- Laragon
- LAMP

Recommended minimum environment:

- PHP 7.4 or newer
- MySQL 5.7+ / MariaDB
- Apache
- PHP extensions:
  - mysqli
  - openssl
  - mbstring
  - filter
  - session

For Gmail SMTP, the PHP installation must also be able to make outbound SMTP connections.

### Shared hosting

The application can also be deployed on a PHP/MySQL shared-hosting account such as a hosting service that provides:

- PHP
- MySQL
- phpMyAdmin
- File Manager or FTP
- SMTP/network access

## 5. Installation Procedure - Local XAMPP

### Step 1 - Install XAMPP

Install XAMPP and open the XAMPP Control Panel.

Start:

```text
Apache
MySQL
```

### Step 2 - Copy the project

Copy the complete `Form Submission` folder to:

```text
C:\xampp\htdocs\
```

The final path should be:

```text
C:\xampp\htdocs\Form Submission\
```

Avoid changing the internal folder structure.

### Step 3 - Create the database

Open:

```text
http://localhost/phpmyadmin/
```

Create a database, for example:

```text
form_submission
```

Select the database and execute:

```sql
CREATE TABLE form_submissions (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(255) NOT NULL,
    contact_number VARCHAR(50) NOT NULL,
    gender VARCHAR(20) NOT NULL,
    message TEXT NOT NULL,
    age VARCHAR(10) NOT NULL DEFAULT 'No',
    ex VARCHAR(10) NOT NULL DEFAULT 'No',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### Step 4 - Configure the database

Open:

```text
Form Submission/db.php
```

Set the database details to match your local MySQL installation.

Example:

```php
<?php

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "form_submission";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Database Connection Failed");
}

$conn->set_charset("utf8mb4");
?>
```

### Step 5 - Configure email

Open:

```text
Form Submission/mail/sendMail.php
```

Configure the Gmail SMTP account.

Example configuration:

```php
$mail->isSMTP();
$mail->Host = "smtp.gmail.com";
$mail->SMTPAuth = true;
$mail->Username = "your-email@gmail.com";
$mail->Password = "YOUR_GMAIL_APP_PASSWORD";
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;
```

Update:

```php
$mail->setFrom("your-email@gmail.com", "Form Notification");
$mail->addAddress("recipient@example.com");
```

### Important Gmail requirement

Do **not** use your normal Gmail password.

Use a Gmail **App Password** for SMTP authentication.

The Google account generally needs 2-Step Verification enabled before an App Password can be created.

Never publish the SMTP password in GitHub or another public repository.

### Step 6 - Open the public form

Open:

```text
http://localhost/Form%20Submission/
```

or:

```text
http://localhost/Form%20Submission/index.html
```

### Step 7 - Test a submission

Enter:

- Name
- Email
- Contact Number
- Gender
- Message
- Over 18 status
- Agreement

Click:

```text
Submit
```

A successful submission should:

1. Save the record in MySQL.
2. Return a JSON success response.
3. Display the SweetAlert success message.
4. Attempt to send an email notification.

## 6. Admin Dashboard

Open:

```text
http://localhost/Form%20Submission/admin/login.php
```

The current application contains two demonstration accounts.

### Administrator

```text
Username: admin
Password: admin123
Role: admin
```

Administrator permissions:

- View submissions
- Delete submissions
- Export submissions to CSV

### Viewer

```text
Username: viewer
Password: viewer123
Role: viewer
```

Viewer permissions:

- View submissions
- Cannot delete records
- Cannot export records

### Security warning

These credentials are hard-coded in `admin/login.php`.

For production use, replace this authentication design with database-backed users and password hashing using PHP `password_hash()` / `password_verify()`.

## 7. User Demonstration Procedure

### Public user

1. Open the public form.
2. Enter the required information.
3. Select gender.
4. Enter the message.
5. Select the required agreement checkbox.
6. Click **Submit**.
7. Confirm the success notification.
8. Verify that the record appears in the database.
9. Verify that the notification email is received.

### Administrator

1. Open `admin/login.php`.
2. Login using the administrator account.
3. Review submitted records.
4. Click **Export CSV** to download all submissions.
5. Use **Delete** to permanently remove an unwanted record.
6. Click **Logout**.

### Viewer

1. Open `admin/login.php`.
2. Login using the viewer account.
3. Review the submissions.
4. Confirm that delete/export controls are restricted.

## 8. CSV Export

Administrators can use:

```text
Admin Dashboard → Export CSV
```

The generated filename follows this format:

```text
form_submissions_YYYY-MM-DD.csv
```

The CSV contains:

```text
ID
Name
Email
Contact Number
Gender
Message
Age
Agreed
Submitted Date
```

## 9. Email Notification Flow

The submission process works as follows:

```text
User
  │
  ▼
index.html
  │
  ▼
AJAX POST
  │
  ▼
submit.php
  │
  ├──────────────► MySQL
  │                  │
  │                  ▼
  │             Save submission
  │
  └──────────────► PHPMailer
                     │
                     ▼
                 Gmail SMTP
                     │
                     ▼
              Notification Email
```

The database submission is performed independently of whether the email notification succeeds.

## 10. Troubleshooting

### A. Database Connection Failed

Check:

```text
db.php
```

Verify:

- MySQL is running.
- Database name is correct.
- Username is correct.
- Password is correct.
- Host is correct.
- MySQL port is correct if a non-default port is used.

For XAMPP, the normal local settings are:

```text
Host: localhost
User: root
Password: empty
```

### B. Form shows "Server Error"

Check:

```text
submit.php
```

Then inspect:

- Apache error log
- PHP error log
- Browser Developer Tools → Network
- Browser Developer Tools → Console
- MySQL connection

Temporarily enable PHP error reporting during development:

```php
ini_set('display_errors', 1);
error_reporting(E_ALL);
```

Do not leave detailed error display enabled on a production server.

### C. Email is not received

Check:

1. Gmail SMTP username.
2. Gmail App Password.
3. SMTP host.
4. SMTP port.
5. TLS configuration.
6. Outbound SMTP access from hosting.
7. Spam/Junk folder.

The configured SMTP settings are:

```text
SMTP Host: smtp.gmail.com
SMTP Port: 587
Encryption: STARTTLS
Authentication: Enabled
```

### D. Gmail authentication fails

Do not use the normal Gmail account password.

Create and use a Gmail App Password.

Also verify that the App Password was copied correctly.

### E. CSV export does not work

Make sure:

- You are logged in as `admin`.
- `admin/export.php` exists.
- Database connection is working.
- The `form_submissions` table exists.

### F. Delete does not work

Only the administrator role can delete records.

Verify that the session contains:

```php
$_SESSION['role'] === 'admin'
```

## 11. Production Security Recommendations

The supplied project is suitable as a small demonstration application, but it should **not be deployed publicly without security improvements**.

### 11.1 Rotate exposed credentials immediately

The project package contains database credentials and an SMTP credential in source code.

If these credentials are real, treat them as compromised:

- Change the database password.
- Revoke/rotate the Gmail App Password.
- Replace the credentials in the application.
- Do not commit the new credentials to GitHub.

### 11.2 Do not hard-code credentials

Use environment variables or a server-side configuration file outside the public web root.

For example:

```text
DB_HOST
DB_USER
DB_PASSWORD
DB_NAME
SMTP_USERNAME
SMTP_PASSWORD
```

### 11.3 Use password hashing

The current admin credentials are stored directly in PHP.

Production authentication should use:

```php
password_hash()
```

and:

```php
password_verify()
```

### 11.4 Add CSRF protection

POST actions and administrative operations should use CSRF tokens.

### 11.5 Protect destructive operations

The current delete operation is triggered through a GET URL:

```text
delete.php?id=123
```

A production implementation should use a POST request with CSRF protection.

### 11.6 Validate input

Server-side validation should be added for:

- Name
- Email
- Contact number
- Gender
- Message
- Checkbox values

Do not rely only on HTML `required` attributes.

### 11.7 Escape email content

User-controlled values inserted into HTML email should be escaped before being placed into the message body.

### 11.8 Use HTTPS

Deploy the application behind HTTPS so credentials and submitted information are encrypted in transit.

### 11.9 Remove debug files

The following files appear to be development/testing utilities:

```text
debug_includes.php
debug_post.php
testmail.php
```

Do not leave diagnostic or test endpoints publicly accessible in production. Remove them or protect them.

## 12. Recommended Production Architecture

For a more secure version:

```text
Browser
   │
   ▼
HTTPS / Apache
   │
   ├── Public Form
   │
   ├── Secure PHP Backend
   │      │
   │      ├── Input Validation
   │      ├── CSRF Protection
   │      ├── Authentication
   │      └── Authorization
   │
   ├── MySQL Database
   │
   └── PHPMailer
          │
          ▼
       SMTP Provider
```

Recommended improvements:

- Database-backed admin users
- Password hashing
- CSRF protection
- HTTPS
- Rate limiting
- Server-side validation
- Secure configuration/environment variables
- Audit logging
- Pagination
- Search/filtering
- Confirmation dialogs
- Better error logging
- Backup strategy
- Restricted admin directory
- Two-factor authentication for administrators

## 13. Shared Hosting Installation

For a PHP/MySQL hosting provider:

### Step 1

Create a MySQL database using the hosting control panel.

### Step 2

Create the required table using the SQL in this README.

### Step 3

Update `db.php` with the database host, database username, password and database name provided by the hosting provider.

### Step 4

Upload the complete project folder to the web root, commonly:

```text
public_html/
```

Example:

```text
public_html/
└── Form Submission/
```

### Step 5

Configure the SMTP credentials in:

```text
mail/sendMail.php
```

### Step 6

Open:

```text
https://your-domain.example/Form%20Submission/
```

### Step 7

Test:

- Form submission
- Database insertion
- Email notification
- Admin login
- Viewer login
- CSV export
- Delete operation

## 14. Backup Procedure

Back up both:

1. Application files
2. MySQL database

For MySQL, use phpMyAdmin:

```text
phpMyAdmin
→ Select Database
→ Export
→ Quick
→ SQL
→ Export
```

Keep database backups in a secure location.

## 15. Deployment Checklist

Before production deployment:

- [ ] Change database password
- [ ] Revoke any exposed Gmail App Password
- [ ] Create a new SMTP App Password
- [ ] Remove credentials from source code
- [ ] Enable HTTPS
- [ ] Change default admin credentials
- [ ] Implement password hashing
- [ ] Add CSRF protection
- [ ] Add server-side input validation
- [ ] Convert delete operation to POST
- [ ] Remove debug/test files
- [ ] Disable PHP error display
- [ ] Enable secure server-side logging
- [ ] Test email delivery
- [ ] Test database backup/restore
- [ ] Restrict access to the admin area

## 16. Quick Start

### Local XAMPP

```text
1. Install XAMPP
2. Start Apache + MySQL
3. Copy project to C:\xampp\htdocs\
4. Create MySQL database
5. Create form_submissions table
6. Configure db.php
7. Configure Gmail SMTP
8. Open index.html through Apache
9. Submit a test form
10. Open admin/login.php
```

### URLs

Public form:

```text
http://localhost/Form%20Submission/
```

Admin login:

```text
http://localhost/Form%20Submission/admin/login.php
```

phpMyAdmin:

```text
http://localhost/phpmyadmin/
```

## 17. License

This project does not include a separate license file. Add an appropriate license before distributing the application publicly.

## 18. Support / Maintenance Notes

When modifying the application:

- Keep database credentials outside source control.
- Test changes on a development server before production.
- Keep PHP and server software updated.
- Back up the database before structural changes.
- Do not expose debug information to end users.
- Keep PHPMailer and other third-party dependencies updated.
