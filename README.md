# Buckhill Pet E-commerce Laravel Backend

This is the Laravel backend for the Buckhill Pet E-commerce website. It provides the API endpoints for the frontend to interact with.

## About Project

The task will required one to create an API that provides the necessary endpoints and HTTP request methods to satisfy the needs of our FE team for them to be able to build the UI.
The API developemnt is based on the User stories and Technical requirements presented in this document.

## Requirements

- PHP ^8.2
- Laravel ^10

## Installation

1. Clone the repository from Github:

```
git clone https://github.com/Nderi12/pet-ecommerce-api-backend
```

2. Install the dependencies:

```
composer install
```

3. Create a new `.env` file:

```
cp .env.example .env
```

4. Generate a new application key:

```
php artisan key:generate
```

5. Create a new database and update the `.env` file with the database credentials:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pet_ecommerce
DB_USERNAME=root
DB_PASSWORD=
```

6. Run the database migrations:

```
php artisan migrate
```

7. Seed the database with sample data:

```
php artisan db:seed
```

## Models

The following models are available in the system:

- Blog
- Product
- Category
- Brand
- Order Status
- Promotion
- User

## Code Overview

### Dependencies

- jwt-auth - For authentication using JSON Web Tokens

### Folders

- app - Contains all the Eloquent models
- app/Http/Controllers - Contains all the api controllers
- app/Http/Middleware - Contains the JWT auth middleware
- app/Http/Requests - Contains all the api form requests
- database/factories - Contains the model factory for all the models
- database/migrations - Contains all the database migrations
- database/seeds - Contains the database seeder
- routes - Contains all the api routes defined in api.php file
- tests - Contains all the application tests
- tests/Feature - Contains all the api tests

### Environment variables

- .env - Environment variables can be set in this file

Note: You can quickly set the database information and other variables in this file and have the application fully working.

## Testing API

Run the laravel tests:

```
php artisan test
```

Run the laravel development server:

```
php artisan serve
```

The api can now be accessed at:

```
http://localhost:8000/api
```

### Request headers

| Required | Key                | Value                          |
| -------- | ------------------| ------------------------------|
| Yes      | Content-Type      | application/json              |
| Yes      | X-Requested-With  | XMLHttpRequest               |
| Optional | Authorization     | Token {JWT}                   |

Refer the api specification for more info.

### Authentication

This applications uses JSON Web Token (JWT) to handle authentication. The token is passed with each request using the Authorization header with Token scheme. The JWT authentication middleware handles the validation and authentication of the token. Please check the following sources to learn more about JWT.

    - https://jwt.io/introduction/
    - https://self-issued.info/docs/draft-ietf-oauth-json-web-token.html

## Documentation

The Swagger OpenAPIs documentation is available at:

```
https://{{base_url}}/api/documentation
```

## Author

- Nderi Kamau

## Contact

- Email: nderikamau1212@gmail.com
- Phone: +254722890101

Please let me know if you have any questions or need further assistance.
```

I hope this helps. Let me know if you have any questions or need further assistance.