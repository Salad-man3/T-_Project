
### Overview
This project is built using the Laravel framework, leveraging its powerful features to create a robust and scalable web application.

### Key Features
1. **RESTful API**: Comprehensive API endpoints for various resources (news, services, complaints, decisions, etc.).
2. **CRUD Operations**: Full Create, Read, Update, and Delete functionality for managing data through API endpoints.
3. **Database Integration**: Utilizes Laravel's Eloquent ORM for efficient database operations.
4. **Input Validation**: Server-side validation to ensure data integrity for API requests.
5. **Soft Deletes**: Implementation of soft delete functionality for data recovery (e.g., for complaints).
6. **API Documentation**: Interactive API documentation generated with Scribe, including example requests and responses.

### Technical Specifications
- **Framework**: Laravel 11.x
- **PHP Version**: 8.2+
- **Database**: MySQL (assumed, based on typical Laravel setups)
- **API Documentation**: postman documentation for generating comprehensive API documentation
- **Version Control**: Git
- **API Testing**: Postman collection available for testing endpoints
- **OpenAPI Specification**: Available for API integration
- **Authentication**: None implemented yet
- **Frontend**: None (API-only project)

### Installation Requirements

Before you begin, ensure you have met the following requirements:

1. **XAMPP**: Install XAMPP, which includes:
   - Apache Web Server
   - MySQL Database
   - PHP (Version 8.2 or higher)

2. **Composer**: The PHP dependency manager

3. **Git**: For version control and cloning the repository

4. **Node.js and npm**: For managing JavaScript dependencies

5. **PHP Extensions**: Ensure the following PHP extensions are enabled in your php.ini file:
   - BCMath PHP Extension
   - Ctype PHP Extension
   - JSON PHP Extension
   - Mbstring PHP Extension
   - OpenSSL PHP Extension
   - PDO PHP Extension
   - Tokenizer PHP Extension
   - XML PHP Extension

6. **Web Browser**: A modern web browser for testing and accessing the application


Note: if you're using XAMPP, most of the server requirements (Apache, MySQL, PHP) are already included in the XAMPP package. Make sure to use the latest version of XAMPP that includes PHP 8.2 or higher.

### Installation
1. Clone the repository:
   ```sh
   git clone <repository-url>
   ```
2. Navigate to the project directory : for unix systems
   ```sh
   cd <project-directory>
   ```
3. Install the dependencies:
   ```sh
   composer install
   ```
4. Copy `.env.example` to `.env` and configure your environment variables : for unix systems
   ```sh
   cp .env.example .env
   ```
5. Generate the application key:
   ```sh
   php artisan key:generate
   ```
6. Run the database migrations:
   ```sh
   php artisan migrate
   ```
7. Start the development server:
   ```sh
   php artisan serve
   ```

### Usage
- Access the application at `http://localhost:8000`
- Access the api documentation by going to `https://documenter.getpostman.com/view/36834914/2sAXqtZfy1`.



### License
This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
