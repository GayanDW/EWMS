# EWMS
https://github.com/GayanDW/EWMS.git

Readme file: - E-Waste Management System (EWMS)
GitHub Link for the project https://github.com/GayanDW/EWMS.git
 

E-Waste Management System (EWMS)


Project Description
The E-Waste Management System (EWMS) is a web-based platform designed to facilitate the tracking, collection, recycling, and management of electronic waste. The system promotes sustainable e-waste disposal, ensures compliance with environmental regulations, and educates users about responsible e-waste management. It provides various stakeholders such as e-waste generators, recyclers, and government bodies with a streamlined interface to monitor and manage the lifecycle of e-waste.


Features
1.	Real-time E-Waste Tracking: Enables users to track e-waste from collection to disposal.
2.	Inventory Management: Keeps records of current inventory, including collected and recycled e-waste.
3.	Compliance with Regulations: Allows government authorities to monitor and ensure compliance with environmental regulations.
4.	Reporting: Generates comprehensive reports on e-waste management activities.
5.	Communication Tools: Facilitates communication between stakeholders via notifications and alerts.
6.	Circular Economy Support: Promotes the reuse and recycling of electronic components.
7.	User-Friendly Interface: Custom interfaces for various stakeholders like recyclers, collectors, and users.
8.	Public Awareness: Educates the public on the proper disposal of e-waste through informative content.

   
Technologies Used
•	Backend: PHP (CodeIgniter 4 Framework)
•	Frontend: HTML5, CSS3 (Bootstrap 5)
•	Database: MySQL
•	Version Control: Git (GitHub)
•	Environment: Apache, Windows


Installation Instructions

1. Clone the Repository
https://github.com/GayanDW/EWMS.git
2. Set Up the Environment
•	Install a local server (XAMPP).
•	Copy the cloned repository into the web root directory (e.g., C:/xampp/htdocs/EWMS).
•	Ensure that PHP, MySQL, and Apache are installed and running.
3. Configure Database
•	Create a database in MySQL called ewms_db.
•	Import the provided SQL file (/database/ewms_db.sql) into the database using phpMyAdmin or command line.
•	Configure the database settings in app/Config/Database.php with your local environment’s credentials.
public $default = [
    'DSN'      => '',
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'ewms_db',
    'DBDriver' => 'MySQLi',
];
4. Run the Application
•	Access the system by opening http://localhost/EWMS in your web browser.

System Overview

1. User Roles
•	E-Waste Generators: Individuals or organizations disposing of electronic waste.
•	Collectors: Entities responsible for collecting e-waste.
•	Recyclers: Organizations responsible for recycling e-waste.
•	Government Authorities: Agencies overseeing and enforcing compliance.
2. Core Modules
•	User Management: Manage user roles, permissions, and profiles.
•	Inventory Management: Real-time tracking of e-waste stock.
•	Compliance Monitoring: Ensure the proper handling and disposal of e-waste.
•	Reporting: Generate reports on collection, recycling, and disposal activities.
•	Notification System: Send alerts and notifications to stakeholders.

Future Enhancements

•	Mobile Application: To allow users to report e-waste disposal needs from mobile devices.
•	AI-powered Sorting: Implementation of AI tools for sorting waste and optimizing recycling processes.
•	Blockchain Integration: For ensuring transparency and traceability in the recycling chain.

Contributing

If you would like to contribute to the development of this project:
1.	Fork the repository.
2.	Create a new branch.
3.	Submit a pull request with a detailed explanation of your changes.
License
This project is licensed under the MIT License - see the LICENSE file for details.

Contact Information

For any queries, feel free to contact the project maintainer:
•	Name: G.G.Deshapriya W
•	Email: gayan.lkk@gmail.com
•	GitHub: https://github.com/GayanDW


