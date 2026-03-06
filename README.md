
# Military Personnel Management and Administration System

A web-based platform designed to manage military personnel, equipment, tasks, and administrative processes within a military unit.

This system was developed as a **Database course semester project** and demonstrates the integration of **MySQL, PHP, and web technologies** to create a centralized management platform.

The project simulates the administrative workflow of a real military unit, improving efficiency compared to traditional paper-based processes.

---

## Project Overview

The platform serves two main categories of users:

### 1. Public Users (Civilians)
Civilians can explore information about the military unit and apply for military career opportunities through an online application form.

### 2. Military Personnel
Authorized personnel can log into the system to access internal functionalities such as:

- Viewing assigned tasks
- Submitting leave requests
- Viewing equipment assigned to them
- Monitoring activity history

### 3. Officers
Officers have additional permissions that allow them to:

- Assign tasks to soldiers
- Approve or reject leave requests
- Review civilian applications
- Assign and manage equipment
- Monitor personnel availability

---

# Website Preview

## Home Page

The home page introduces the military unit and provides navigation to the main sections of the platform.

<img width="2845" height="1546" alt="image" src="https://github.com/user-attachments/assets/f0667ce1-3a05-4674-907f-fbb1ca7678d0" />


Main sections available from the navigation menu:

- Home
- About Us
- Military Career
- Events
- Login (for military personnel)-hidden button

---

## Military Login Page

Only authorized military personnel can access the internal system using their **Military ID and password**.

<img width="826" height="364" alt="image" src="https://github.com/user-attachments/assets/f25656a0-6d72-4257-88ae-0e3f88f7d309" />



Login behavior:

- IDs starting with **3xxx → Soldier Dashboard**
- IDs starting with **5xxx → Officer Dashboard**

This role-based authentication controls the system permissions.

---

# Database Architecture

The system is powered by a relational database designed to manage personnel, tasks, equipment, and administrative workflows.

<img width="1090" height="636" alt="image" src="https://github.com/user-attachments/assets/92325a5e-83e8-4642-9719-3129bfa0e23b" />


The database contains the following main tables:

### Users
Stores all military personnel.

Main attributes:
- ID (Primary Key)
- Name
- Surname
- Email
- Password
- Rank
- Position
- Phone Number
- Date of Enrollment

Relationships:
- One user can have multiple tasks
- One user can submit multiple leave requests
- One user can receive multiple equipment assignments

---

### Civilian Applications
Stores applications submitted by civilians interested in joining the military.

Attributes:
- application_ID
- full_name
- email
- phone_number
- cv_document
- application_date
- status
- reviewed_by (Officer ID)

---

### Tasks
Allows officers to assign tasks to soldiers.

Attributes:
- task_ID
- assigned_to
- task_name
- description
- start_date
- end_date
- status

---

### Equipment
Stores reference information about available equipment.

Attributes:
- equipment_id
- equipment_name
- category
- model
- serial_number
- status

---

### Equipment Management
Tracks equipment allocation to soldiers.

Attributes:
- id
- equipment_ID
- user_ID
- allocation_date
- return_date
- status
- leave_request_ID

---

### Leave Requests
Stores soldiers' leave requests.

Attributes:
- ID
- user_ID
- start_date
- end_date
- reason
- status
- equipment_returned
- submission_date

---

# System Features

## Authentication
Secure login system using Military ID and password.

---

## Leave Management
Soldiers can:

- Submit leave requests
- View leave history

Officers can:

- Approve leave requests
- Reject leave requests
- Monitor soldiers currently on leave

---

## Task Assignment
Officers can assign tasks to soldiers.

Soldiers can view and mark tasks as completed.

---

## Equipment Management
The system tracks military equipment and assigns it to soldiers while maintaining an inventory log.

---

## Recruitment System
Civilians can submit applications for military careers through an online form.

Officers review applications and decide whether to approve or reject them.

---

# SQL Features Used

The project demonstrates multiple database concepts:

### JOIN Operations
Used to combine equipment and equipment management tables to display detailed information about assigned equipment.

### Subqueries
Used to determine soldiers currently available in the unit.

### Aggregate Functions
Example:
COUNT(*) to calculate the number of available soldiers.

### Self JOIN
Used to find soldiers who share the same rank.

### CRUD Operations
The system supports:

- INSERT
- UPDATE
- DELETE

---

# Technologies Used

- PHP
- MySQL
- HTML
- CSS
- phpMyAdmin
- Apache (XAMPP)

---

# Project Structure


```

project/
│
├── index.php
├── header.php
├── footer.php
│
├── pages/
│ ├── about_us.php
│ ├── events.php
│ ├── military_career.php
│ ├── login.php
│ ├── soldier_dashboard.php
│ └── officer_dashboard.php
│
├── actions/
│ ├── submit_application.php
│ ├── assign_task.php
│ ├── assign_equipment.php
│ ├── process_application.php
│ ├── process_leave.php
│ ├── mark_task_done.php
│ └── equipment_return.php
│
|── database/military_unit.sql
|
└── requirements.txt
```
## How to Run the Project

1. Install XAMPP.
2. Start Apache and MySQL.
3. Import the database `military_unit.sql` in phpMyAdmin.
4. Place the project folder in `xampp/htdocs`.
5. Open the browser and go to:

http://localhost/project/index.php

# Academic Context

Faculty: **Faculty of Automation and Computer Science**

Course: **Databases**

Project Title:
**Military Personnel Management and Administration System**

Academic Year: **2024–2025**

---

# Author

**Brătian Melisa-Adriana**
