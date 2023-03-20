# Buckhill Pet E-commerce Laravel Backend

This is the Laravel backend for the Buckhill Pet E-commerce website. It provides the API endpoints for the frontend to interact with.

## About Project

The task will required one to create an API that provides the necessary endpoints and HTTP request methods to satisfy the needs of our FE team for them to be able to build the UI.
The API developemnt is based on the User stories and Technical requirements presented in this document.

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

## Documentation

The Swagger OpenAPIs documentation is available at:

```
https://{{base_url}}/api/documentation
```

## Author

- John Doe

## Contact

- Email: nderikamau1212@gmail.com
- Phone: +254722890101

I hope this helps. Let me know if you have any questions or need further assistance.