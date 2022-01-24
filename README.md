# Lumen PHP Framework

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://img.shields.io/packagist/v/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://img.shields.io/packagist/l/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

## Official Documentation

Documentation for the framework can be found on the [Lumen website](https://lumen.laravel.com/docs).

### Installing Lumen via composer

`composer create-project --prefer-dist laravel/lumen <project-name>`

Installing additional composer package:
```
composer install --ignore-platform-reqs
composer require flipbox/lumen-generator
```


### `bootstrap\app.php`

- Add the following code:
```
$app->register(Flipbox\LumenGenerator\LumenGeneratorServiceProvider::class);
```
- Uncomment the following:
```
$app->withFacades();
$app->withEloquent();
```

## Basic artisan command:

### Create controller (empty):
`php artisan make:controller BookController`

### Create controller (crud):
`php artisan make:controller BookController --resource`


### Create model:
`php artisan make:model Book`

### Create controller and model:
`php artisan make:controller BookController --resource --model Model\Book`


## Serving your Lumen API:
`php artisan serve`
