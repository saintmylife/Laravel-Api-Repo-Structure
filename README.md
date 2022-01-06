<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Build With

-   [PHP 7.4.27](https://php.net) - The web language used
-   [Laravel 7.x](https://laravel.com) - The web framework used
-   [Spattie](https://github.com/spatie/laravel-permission) - Associate users with roles and permissions
-   [Prettus](https://github.com/andersao/l5-repository) - Repositories to abstract the database layer
-   [JWT-Auth](https://github.com/PHP-Open-Source-Saver/jwt-auth/tree/develop/src) - JWT Token For Authentication

## How To Install

-   Clone the repo
-   Copy .env.example and setup
-   Run the following commands in order
    -   `composer install`
    -   `php artisan key:generate`
    -   `php artisan db:migrate && php artisan db:seed`
    -   `php artisan jwt:secret`
    -   `php artisan vendor:publish --provider="PHPOpenSourceSaver\JWTAuth\Providers\LaravelServiceProvider"`
    -   `php artisan token:name <your_cookie_token_name>`

> Note

-   Change password for super-admin on the seed files
-   Super-admin user dont have permissions (Configured at Guard::before on AuthServiceProvider)

## App Structure

    App
    ├─ Modules
    		├─ Base
    				├─ BaseDto	# Base Data Transfer Object Template
    				├─ Domain
    						├─ BaseFilter	# Base Filter Template
    						├─ BaseResponder	# Base HTTP Response Return
    						├─ BaseService	# Base Bussiness Logic Template
    				├─ Repository	# Base CRUD for any DB
    						├─ BaseEloquentRepository # Extending Global Eloquent
    		├─ Common
    				├─ Domain
    						├─ Payload	# Base HTTP Response Status
    		├─ *
    				├─ Api			# Controller
    				├─ Domain
    						├─ Service			# Bussiness Logic
    						├─ *Filter			# Request Validation
    				├─ Jobs	# Bussiness Logic For Other Service
    				├─ Repository
    						├─ *RepositoryEloquent		# Model Bindings
    						├─ *Interface				# Additional Database Method
    				├─	*				# Model
    				├─	*Dto			# Data Transfer Object
    ├─ Routes
    		├─ api	# Define Your Route Here (Use StudlyCase)

## Application Flow

<p align="center">
<img src="https://lh3.googleusercontent.com/77ah-_-1OUY9C4NIwDpDKXojNcBs8dwkyZrmJSU2Aaw7ZASJ77tqPrc48wQrseThZepdlgDOxn_dz_zNSth9sx5TlqjnqFQPU-E_3KYZNd8b3SeZdKbYsKky31Wd73CVz81fd---kQ=w2400" width="300">
</p>

## Commands

#### Generate Module

```
generate:module <name>			# Generate All Module Resources
generate:module <name> -a		# Default value (All)
generate:module <name> -api		# Generate Api Resources
generate:module <name> -d		# Generate Domain Resources
generate:module <name> -dto		# Generate Dto Resource
generate:module <name> -r		# Generate Repository Resource
```

#### Generate Api / Domain

```
generate:api/domain <name>		# Generate All Api Resources
generate:api/domain <name> -a	# Default value (All)
generate:api/domain <name> -c	# Generate Create Resources
generate:api/domain <name> -d	# Generate Delete Resources
generate:api/domain <name> -e	# Generate EditResources
generate:api/domain <name> -f	# Generate Fetch Resources
generate:api <name> -i				# Generate Index Resources (Api Only)
generate:domain <name> -l		# Generate List Resources (Domain Only)

Filter Files will auto generated
```

#### Generate Repository

```
generate:repository <name>		# Generate All Repository Resources
generate:repository <name> -a	# Default value (All)
generate:repository <name> -e	# Generate Eloquent Resources
generate:repository <name> -i	# Generate Interface Resources
```

#### Generate Job

```
generate:job <name> <name_space> <model>	# Generate Job Resources
```
