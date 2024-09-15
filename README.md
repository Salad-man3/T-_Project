
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
- **API Documentation**: Scribe for generating comprehensive API documentation
- **Version Control**: Git
- **API Testing**: Postman collection available for testing endpoints
- **OpenAPI Specification**: Available for API integration
- **Authentication**: None implemented 
- **Frontend**: None (API-only project)

### Installation
1. Clone the repository:
   ```sh
   git clone <repository-url>
   ```
2. Navigate to the project directory:for unix systems
   ```sh
   cd <project-directory>
   ```
3. Install the dependencies:
   ```sh
   composer install
   ```
4. Copy `.env.example` to `.env` and configure your environment variables:for unix systems
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
- Access the api documentation by downloading the postman collection and environment files from the repository.



### License
This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
