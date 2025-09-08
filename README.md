# World's Highest Buildings - Management System

A comprehensive Laravel-based application for managing information about the world's skyscrapers and tall buildings. This project provides both a web-based CRUD application and a public REST API.

## 🌟 Features

### Web Application

-   User authentication and registration system
-   Complete CRUD operations for building management
-   User-specific building management (users can only edit their own entries)
-   Responsive design with Tailwind CSS
-   Modern and intuitive interface

### REST API

-   Public access to building data
-   Protected endpoints for data modification
-   Token-based authentication
-   Comprehensive API documentation

## 🚀 Tech Stack

-   PHP 8.2+
-   Laravel 12.0
-   Laravel Sanctum for API authentication
-   Laravel Breeze for web authentication
-   Tailwind CSS for styling
-   SQLite database (easily configurable for other databases)

## 📋 Prerequisites

-   PHP >= 8.2
-   Composer
-   Node.js & npm
-   SQLite (or your preferred database)

## 🛠 Installation

1. Clone the repository:

    ```bash
    git clone https://github.com/orso081980/world-highest-buildings.git
    cd world-highest-buildings
    ```

2. Install PHP dependencies:

    ```bash
    composer install
    ```

3. Install JavaScript dependencies:

    ```bash
    npm install
    ```

4. Set up environment:

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

5. Set up the database:

    ```bash
    php artisan migrate
    php artisan db:seed
    ```

6. Build assets:

    ```bash
    npm run build
    ```

7. Start the development server:
    ```bash
    php artisan serve
    ```

## 🔧 Usage

### Web Application

-   Access the application at `http://127.0.0.1:8000`

### API Documentation

Detailed API documentation is available in [API_DOCUMENTATION.md](API_DOCUMENTATION.md)

## 📊 Data Structure

Buildings include the following information:

-   Name
-   City
-   Country
-   Status
-   Completion Year
-   Height
-   Number of Floors
-   Construction Material
-   Building Function

## 🧪 Testing

Run the test suite:

```bash
php artisan test
```

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

## 👤 Author

Created by orso081980

## 🙏 Acknowledgments

-   Laravel team for the amazing framework
-   All contributors to the project
-   Building data contributors
