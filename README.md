# SynergyMS

![SynergyMS Logo](https://raw.githubusercontent.com/mercenary19961/SynergyMS/refs/heads/main/public/images/logo-sms.png)

**SynergyMS** is a robust Comprehensive Enterprise Management System built with Laravel. It integrates HR, project management, payroll, and ticketing into a unified platform. With role-based access, SynergyMS adapts to various departments' needs, enhancing efficiency and communication across medium to large organizations.

---

## Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)

---

## Overview

SynergyMS is designed to streamline enterprise operations with a focus on:
- **HR Management**: Employee attendance, leave management, and payroll processing.
- **Project Management**: Task assignment, tracking progress, and team collaboration.
- **Ticketing System**: Efficient issue reporting and resolution tracking.
- **Role-Based Access Control**: Different dashboards for Super Admin, HR, Employees, Clients, and Project Managers.

SynergyMS promotes organization-wide efficiency, enabling teams to collaborate and manage resources effectively.

---

## Features

### 1. Role-Based Dashboards
Each user role has a tailored dashboard, ensuring the right tools and information are accessible.

**Here is the login page image:**
![Login Page](https://raw.githubusercontent.com/mercenary19961/SynergyMS/refs/heads/main/public/images/login%20page.png)

---

### 2. Admin Dashboard
The Admin dashboard provides a comprehensive overview, allowing system-wide control and monitoring.

**Here is the Super Admin dashboard image:**
![Admin Dashboard](https://raw.githubusercontent.com/mercenary19961/SynergyMS/refs/heads/main/public/images/admin%20dashboard.png)

---

### 3. Employee Dashboard
The Employee dashboard is designed to streamline daily tasks and provide quick access to relevant tools.

**Here is the employee dashboard image:**
![Employee Dashboard](https://raw.githubusercontent.com/mercenary19961/SynergyMS/refs/heads/main/public/images/employee%20dashboard.png)

---

### 4. Client Dashboard
The Client dashboard ensures efficient communication and transparency in project progress and ticket status.

**Here is the client dashboard image:**
![Client Dashboard](https://raw.githubusercontent.com/mercenary19961/SynergyMS/refs/heads/main/public/images/client%20dashboard.png)

---

### 5. HR Management
- Employee records management.
- Attendance tracking.
- Approval of leave requests and performance evaluations.

**Here is the HR dashboard image:**
![HR Dashboard](https://raw.githubusercontent.com/mercenary19961/SynergyMS/refs/heads/main/public/images/hr%20dashboard.png)

---

### 6. Project Management
- Task assignment and prioritization.
- Monitoring progress and deadlines.
- Cross-departmental collaboration for projects.

**Here is the project manager dashboard image:**
![Project Manager Dashboard](https://raw.githubusercontent.com/mercenary19961/SynergyMS/refs/heads/main/public/images/project%20manager%20dashboard.png)

---

### 7. Employee Page
- View detailed employee profiles, including roles, attendance records, and performance metrics.

**This is the employee's section image:**
![Employee Page](https://raw.githubusercontent.com/mercenary19961/SynergyMS/refs/heads/main/public/images/employees%20sector.png)

---

### 8. Payroll Integration
- Automated salary calculations.
- Transparent and accessible payslip generation for employees.

---

### 9. Ticketing System
- Allows employees and clients to submit tickets.
- Facilitates issue resolution by assigning tasks to responsible personnel.

---

## Installation

### Prerequisites
- PHP 8.2+
- Laravel 11
- Composer
- MySQL
- Node.js

### Steps
1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/synergyms.git
   cd synergyms
   ```

2. Install dependencies:
   ```bash
   composer install
   npm install
   ```

3. Set up the environment file:
    - Copy .env.example to .env:
        ```bash
        cp .env.example .env
        ```

4. Run migrations and seeders:
   ```bash
   php artisan migrate --seed
   ```

5. Build frontend assets:
   ```bash
   npm run dev
   ```

6. Start the development server:
   ```bash
   php artisan serve
   ```

---

## Usage
Accessing the System
- Open http://localhost:8000 in your browser.
- Default credentials:
    - Admin: admin@example.com / password
    - Employee: employee@example.com / password

---

## Contributing
Contributions are welcome! To contribute:

1- Fork the repository.
2- Create a feature branch:
   ```bash
   git checkout -b feature/your-feature-name
   ```
3- Commit your changes:
   ```bash
   git commit -m "Add your feature"
   ```
4- Push to the branch:
   ```bash
   git push origin feature/your-feature-name
   ```
5- Open a Pull Request.

---

## License

This project is licensed under the MIT License. See the LICENSE file for details.











