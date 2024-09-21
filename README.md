# 🚀 Laravel API Project

## 📌 Overview
This project is a robust and scalable API built with Laravel, designed to provide a comprehensive backend solution for various applications. It leverages Laravel's powerful features to create a flexible and efficient RESTful API.

## ✨ Key Features
- 🔐 **Admin Authentication**: Secure admin login system using Laravel Sanctum
- 🌐 **RESTful API**: Comprehensive endpoints for various resources (news, services, complaints, decisions, etc.)
- 💾 **CRUD Operations**: Full Create, Read, Update, and Delete functionality
- 🗃️ **Database Integration**: Efficient database operations with Laravel's Eloquent ORM
- ✅ **Input Validation**: Thorough server-side validation for data integrity
- 🗑️ **Soft Deletes**: Data recovery functionality (e.g., for complaints)
- 📚 **API Documentation**: Interactive documentation with Postman and OpenAPI
- 🔒 **Role-Based Access Control**: Admin-specific routes and permissions

## 🛠️ Technical Specifications
- **Framework**: Laravel 11.x
- **PHP Version**: 8.2+
- **Database**: MySQL
- **Authentication**: Laravel Sanctum for token-based authentication
- **API Documentation**: Postman collection and OpenAPI specification
- **Version Control**: Git
- **CORS**: Configured for cross-origin resource sharing

## 📋 Installation Requirements
Before you begin, ensure you have:

1. **XAMPP**: Install XAMPP, which includes:
   - Apache Web Server
   - MySQL Database
   - PHP (Version 8.2 or higher)
2. **Composer**: The PHP dependency manager
3. **Git**: For version control and cloning the repository
4. **Node.js and npm**: For managing JavaScript dependencies

## 🚀 Installation
1. Clone the repository:
   ```sh
   git clone <repository-url>
   ```
2. Navigate to the project directory:
   ```sh
   cd <project-directory>
   ```
3. Install PHP dependencies:
   ```sh
   composer install
   ```
4. Copy `.env.example` to `.env` and configure your environment variables:
   ```sh
   cp .env.example .env
   ```
5. Generate the application key:
   ```sh
   php artisan key:generate
   ```
6. Run database migrations:
   ```sh
   php artisan migrate
   ```
7. Seed the database with initial data:
   ```sh
   php artisan db:seed
   ```
8. Start the development server:
   ```sh
   php artisan serve
   ```

## 🔧 Usage
- Access the application at `http://localhost:8000`
- API documentation is available at:
  - Postman: `https://documenter.getpostman.com/view/36834914/2sAXqtb23Y`
  - OpenAPI: `/docs/index.html` (when served locally)

## 🔐 Admin Authentication
To access admin-only routes:
1. Login using the `/api/admin/login` endpoint
2. Use the returned token in the Authorization header for subsequent requests

## 📘 API Documentation
Comprehensive API documentation is available in both Postman and OpenAPI formats:


## 📄 License
This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
