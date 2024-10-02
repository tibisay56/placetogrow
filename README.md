<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://www.evertecinc.com/wp-content/uploads/2022/04/Evertec-lanza-nueva-plataforma-de-pagos-en-linea.jpg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Microsites

A web platform for managing microsites, enabling administrators to register users, manage roles, and create, update, edit, and delete sites. Guest users can explore the microsites and make payments.


## Installation

1. Clone this repository to your local machine:

```
       git clone https://github.com/tibisay56/placetogrow.git
```
2. Install project dependencies using Composer and NPM:

```
        composer install
        npm install
```
3. Copy the .env.example configuration file and create a new one named .env. Then, update the environment variables according to your configuration:

```
        cp .env.example .env
        php artisan key:generate
```
4. Edit the .env file to configure the database connection for MySQL.
```
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=microsites
        DB_USERNAME=root
        DB_PASSWORD=your_password
```

5. Add PlaceToPay credentials to the .env file.
```
        PLACETOPAY_LOGIN=your_placetopay_login
        PLACETOPAY_SECRET_KEY=your_placetopay_secret_key
        PLACETOPAY_URL=your_placetopay_url
```

6. Run migrations to create the database tables:

```
        php artisan migrate
```

7. Seed the database with initial data:

```
        php artisan db:seed
```

8. Create a symbolic link for storage:

```
        php artisan storage:link
```

9. Compile and watch frontend assets:

```
        npm run dev
```

10. Start the development server:

```
        php artisan serve
```

11. User credentials:

```
        Admin user:
        Email: admin@admin.com
        Password: password
        
        Customer user:
        Email: customer@example.com
        Password: password
        
```


## Contributing

Contributions are welcome. If you find any issues or have a suggestion, please open an issue or send a pull request.


## License

Microsites is licensed under the [MIT license](https://opensource.org/licenses/MIT).


