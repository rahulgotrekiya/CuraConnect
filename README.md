# CuraConnect

CuraConnect is a streamlined, web-based hospital and clinic appointment booking system. It allows patients to create accounts, browse available doctors and schedules, book appointments, and pay channeling fees online. It also offers comprehensive dashboards for doctors and administrators to manage sessions, view patient history, and oversee clinic operations.

## Features

- **Patient Portal**: Register, search for doctors, view schedules, book appointments, and process payments securely.
- **Doctor Portal**: View upcoming patient appointments, manage scheduled sessions, and review medical history.
- **Admin Dashboard**: Manage the entire ecosystem—add new doctors, configure schedules, and oversee overall hospital booking statistics.
- **Automated Email Notifications**: Built-in support using `PHPMailer` to send automated email confirmations and cancellation notices to patients.
- **Secure Authentication**: Role-based access control separates patients (`p`), doctors (`d`), and admins (`a`).

## Technology Stack

- **Frontend**: HTML5, CSS3, JavaScript (Vanilla CSS, custom styling)
- **Backend**: Native PHP 8+
- **Database**: MySQL
- **Email**: PHPMailer

## Prerequisites

- **Web Server**: Apache or Nginx (e.g., via XAMPP/MAMP/LAMP)
- **PHP**: Version 8.0 or higher
- **Composer**: To install PHPMailer and `vlucas/phpdotenv`
- **MySQL**: Version 5.7+ or MariaDB

## Installation

1. **Clone the Repository**
   Move the project files into your web server's root directory (e.g., `htdocs` for XAMPP or `/var/www/html`).

2. **Install Dependencies**
   Navigate to the project root and install PHP dependencies (PHPMailer & dotenv):
   ```bash
   composer install
   ```

3. **Database Setup**
   - Create a new MySQL database named `curaconnect` (or any name you prefer).
   - Import the provided `database.sql` file into your newly created database to set up the schema and default admin accounts.

4. **Environment Configuration**
   - Copy the `.env.example` file to create a new file named `.env`:
     ```bash
     cp .env.example .env
     ```
   - Open the `.env` file and configure your database credentials and SMTP details for outgoing emails.

5. **Run the Application**
   - Start your Apache and MySQL services.
   - Access the application via your browser (e.g., `http://localhost/CuraConnect`).

## Project Architecture & DRY Principles

The CuraConnect codebase has been refactored to strictly adhere to **DRY (Don't Repeat Yourself)** principles for maximum maintainability:
- **`includes/auth.php`**: Exposes the `requireLogin($role)` helper to centrally handle session validation and role-based redirects across all standalone pages.
- **`includes/functions.php`**: Centralizes database queries (e.g., `getUserByEmail`, `getDashboardCounts`) to eliminate repetitive SQL logic previously scattered across various dashboards and the login controller.
- **`includes/head.php`**: Abstracts the repetitive HTML `<head>` boilerplate (meta tags, CSS imports) globally across public-facing interfaces.
- **`.env` Configuration**: Centralizes environmental secrets preventing hardcoded credentials in connection strings or mailer plugins.

## Usage Defaults

If you imported `database.sql`, a default Admin account should be available. 
Check your database's `admin` table for the exact credentials, or use the `signup.php` page to create a patient account and test the appointment flows.
