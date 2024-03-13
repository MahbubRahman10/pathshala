# Pathshala - School Grading System
Pathshala is a school grading system application developed as a project for the Databases and Web Technologies course at TU Chemnitz during the summer semester of 2021. It provides an overview of test results and the performance of all pupils, aiming to simplify school management tasks such as managing classes, subjects, and pupils' grades.

## Introduction
The primary objective of Pathshala is to offer a user-friendly interface for school management, teachers, and students to efficiently manage and view test results and grades. With distinct user roles for admin, teacher, and student, the application facilitates role-based access control and user management.

## Requirements
The application is divided into four main parts: frontend, backend, database, and web service API. The frontend presents the application data, while the backend handles logical operations and data processing. A MySQL database stores application data, and a web service API facilitates communication between the frontend and backend.


## Technologies Overview
### HTML
HTML is used for describing the structure of web pages, allowing authors to publish online documents with various elements like headings, text, tables, and forms.

### CSS
CSS (Cascading Style Sheets) defines the presentation of web pages, including colors, layout, and fonts, enabling adaptation to different devices and environments.

### Bulma CSS Framework
Bulma is an open-source CSS framework providing frontend components for building responsive web interfaces. Its simplicity and responsiveness make it suitable for this project.

### PHP
PHP (Hypertext Preprocessor) is a server-side scripting language used for creating dynamic web content, interacting with databases, and developing web applications.

### Laravel PHP Framework
Laravel is an open-source PHP framework known for its robustness and MVC architecture. It offers a rich set of features and simplifies web application development.

### Laravel API Resources
Laravel API Resources facilitate the transformation of models and model collections into JSON, making it easier to build API endpoints.

### JavaScript
JavaScript adds interactivity to web pages, allowing for dynamic content and user interaction without page reloads.

### Vue.js
Vue.js is a progressive JavaScript framework for building user interfaces, known for its simplicity and flexibility. It integrates seamlessly with Laravel.

### JSON Web Token (JWT)
JWT provides a secure way of transmitting information between parties as JSON objects. It is used for user authentication in the application.

### Database Architecture
The database is designed using MySQL and normalized to ensure data integrity. Eight tables are utilized, including pivot tables for many-to-many relationships.

- users, roles, role_user, classes, pupils_class , subjects, tests, grades

## Course Information
This project was developed as part of the Databases and Web Technologies course at TU Chemnitz during the summer semester of 2021.