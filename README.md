
# Laravel Project

This repository contains a Laravel project. Follow the instructions below to download, set up, and run the project locally.

## Prerequisites

Make sure you have the following installed on your system:

- PHP (>= 8)
- Composer
- Laravel (optional, as Composer can handle it)
- Git

## Installation

### 1. Clone the repository

```sh
https://github.com/Ahmed-Wassim/Movies.git
cd your-laravel-project
```

### 2. Install PHP dependencies

```sh
composer install
```

### 3. Install Node.js dependencies

```sh
npm install
```

### 4. Set up environment variables

Copy the `.env.example` file to `.env` and update the necessary environment variables, particularly the database configuration.

```sh
cp .env.example .env
```

### 5. Generate an application key

```sh
php artisan key:generate
```

### 6. Run database migrations and seed the database

Make sure your database server is running and the database specified in your `.env` file exists.

```sh
php artisan migrate --seed
```

### 7. Serve the application

```sh
php artisan serve
```

Your Laravel application should now be running at `http://localhost:8000`.

## Additional Commands

### Compiling Assets

If your project includes frontend assets, you can compile them using the following command:

```sh
npm run dev
```

For production:

```sh
npm run production
```

### Running Tests

To run the tests included in the project:

```sh
php artisan test
```

## Contributing

Feel free to submit a pull request if you find any issues or have improvements.

## License

This project is licensed under the [MIT License](LICENSE).
