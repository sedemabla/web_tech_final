# Fur & Friends - Pet Care Platform

## Overview
Fur & Friends is a comprehensive web platform designed to help pet owners take better care of their pets through training tips, DIY ideas, and health advice. The platform features both user and admin interfaces with secure authentication.

## Features

### User Features
- User authentication (signup/login)
- View and search training tips
- Browse DIY pet care ideas
- Access pet health tips
- Comment and rate content
- Profile management

### Admin Features
- Secure admin dashboard
- User management
- Content management for:
  - Training tips
  - DIY ideas
  - Health tips
- Analytics and activity tracking

## Tech Stack
- Frontend: HTML, CSS, JavaScript
- Backend: PHP
- Database: MySQL
- Icons: Boxicons
- Fonts: Google Fonts (Fredoka One, Poppins)

## Installation

1. Clone the repository:
```bash
git clone https://github.com/username/fur-and-friends.git
cd fur-and-friends
```

2. Database setup:
```bash
mysql -u username -p database_name < db/setup.sql
```

3. Configure database. Change the variables to match that of your server in the db/connect.php file.
$servername = 'localhost';
$username = 'your_username';
$password = 'your_password';
$dbname = 'your_database';


Remember to set permission for file uploads.
```bash
chmod 755 uploads/
chmod 755 uploads/{training,health,diy}
```

Project Structure
Final Project/
├── actions/          PHP action handlers
├── assets/           Static resources
├── db/               Database files
├── uploads/          User uploads
└── view/             PHP view files


## An admin has already been created when you import the sql file.
Username: admin
Password: Password1234$
