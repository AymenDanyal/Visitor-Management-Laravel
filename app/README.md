# Admin Panel for Visitor Entry Management

This project is a Laravel-based admin panel used to manage visitor entries and keep detailed records. The system is focused on robust permission handling using the **Spatie Laravel Permission** package for controlling user access and roles.

## Features:
- **Visitor Management**: Add, view, edit, and delete visitor records.
- **Visitor History**: Maintain a history of visits for each visitor, searchable by date or name.
- **Role-Based Access Control (RBAC)**: Handle roles and permissions using the Spatie Laravel Permission package to ensure only authorized users can access specific features.
- **User Management**: Admins can create users, assign roles (Admin, Staff, etc.), and control their permissions.
- **Activity Logging**: Track and log all admin activities for auditing purposes.
- **Search & Filters**: Advanced search and filter functionality to quickly access visitor data.
- **Dashboard Overview**: A clean and responsive dashboard that shows recent activity and system status.

## Screenshots:

### Visitor Management
Easily manage all visitor records, track their entries, and filter them based on date and other attributes.

![Visitor Management Screenshot](./screenshots/visitor-management.png)

### Role & Permission Management
Control what each user can access by assigning roles and permissions using the Spatie package.

![Role Management Screenshot](./screenshots/role-management.png)

### User Management
Admins can add and manage users, assign roles, and ensure proper access control.

![User Management Screenshot](./screenshots/user-management.png)

### Dashboard Overview
A clean, simple dashboard for managing visitors and viewing statistics.

![Dashboard Screenshot](./screenshots/dashboard.png)

## Installation

1. Clone the repository:
    ```bash
    git clone https://github.com/AymenDanyal/VisitorLog_Laravel.git
    ```

2. Navigate to the project directory:
    ```bash
    cd VisitorLog-laraval
    ```

3. Install dependencies using Composer:
    ```bash
    composer install
    ```

4. Copy `.env.example` to `.env` and set up your environment variables:
    ```bash
    cp .env.example .env
    ```

5. Generate the application key:
    ```bash
    php artisan key:generate
    ```

6. Set up the database in `.env`, then run migrations:
    ```bash
    php artisan migrate
    ```

7. Optionally, seed the database with roles and permissions:
    ```bash
    php artisan db:seed
    ```

8. Serve the application:
    ```bash
    php artisan serve
    ```

## Usage

Once the application is running, you can access the following features:

- **Visitor Management**: Track, add, update, and delete visitor records from a user-friendly interface.
- **User Management**: Admins can manage user accounts and assign roles such as Admin, Staff, etc.
- **Role & Permission Handling**: Fine-grained control over what each user role can access, implemented via Spatie Laravel Permission.
- **Logging & Audit**: Every action in the system is logged for audit purposes, ensuring accountability.
- **Dashboard**: A real-time overview of the system status, recent activity, and quick access to the most common features.
- **Advanced Search**: Find visitors and entries quickly using search and filters based on various criteria.

## Contribution

We welcome contributions! Feel free to submit issues, fork the repo, and make pull requests.

## License

This project is open-source under the MIT license.

