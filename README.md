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

After installing lumen, you can `cd` to the project folder and install additiona packages.

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

###### = Setup Database Connection in `.env`

After setting up your database connection, type the following command in your terminal:

```
php artisan key:generate
```

This will generate a unique key for your app in `.env`

## Serving your Lumen API:
`php artisan serve`

## Basic artisan command:

### Create controller (empty):
`php artisan make:controller BookController`

### Create controller (crud):
`php artisan make:controller BookController --resource`


### Create model:
`php artisan make:model Book`

### Create controller and model:
`php artisan make:controller BookController --resource --model Model\Book`

## Adding authentication to app
Authentication in Lumen, while using the same underlying libraries as Laravel, is configured quite differently from the full Laravel framework. Since Lumen does not support session state, incoming requests that you wish to authenticate must be authenticated via a stateless mechanism such as API tokens.

- Create `UserController` and paste the following code:
```bashrc
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function __construct()
    {
    }

    public function authenticate(Request $request)
    {
        $this->validate($request, [
            'empId' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('empId', $request->empId)->first();

        if (Hash::check($request->password, $user->password)) {
            $apiKey = base64_encode(Str::random(40));
            User::where('empId', $request->empId)->update(['api_key' => $apiKey]);

            return ['status' => 'Success', 'api_key' => $apiKey];
        }

        return response()->json(['status' => 'fail'], 401);
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'empId' => 'required|int',
            'name' => 'required|string',
            'position' => 'required|string',
            'password' => 'required',
        ]);

        $created = User::create([
            'empId' => $request->empId,
            'name' => $request->name,
            'position' => $request->position,
            'password' => Hash::make($request->password),
        ]);

        if ($created) {
            return response(['status' => 'Regisration Successful!']);
        }

        return response(['message' => 'Failed to register.']);
    }
}

```

- Modify `app\Providers\AuthServiceProvider.php`. Past the following code inside `boot()`.
```bashrc
$this->app['auth']->viaRequest('api', function ($request) {
            if ($request->header('Authorization')) {
                $key = explode(' ', $request->header('Authorization'));
                $user = User::where('api_key', $key[1])->first();
                if (!empty($user)) {
                    $request->request->add(['userid' => $user->empId]);
                }

                return $user;
            }
        });
```

- Uncomment the following code in `bootstrap\app.php`
```
$app->routeMiddleware()
$app->register(App\Providers\AuthServiceProvider::class)
```

###### NOTE: Your user table should have an api_key column in it!
