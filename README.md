#SETUP

###Vendirun Laravel Package

This package can be pulled in to any Laravel project and provides all of the default Vendirun front-end functionality

Latest Stable Version: 1.2.1.0

###Importing the package into a new front-end

Install Laravel
```
composer create-project laravel/laravel newprojectname 5.2.*
```

Pull the package in via composer:
```
composer require alistairshaw/vendirun
```

Add the namespace to the PSR-4 section
```php
"AlistairShaw\\Vendirun\\": "vendor/alistairshaw/vendirun"
```

Edit the /config/app.php file and add the VendirunServiceProvider to the app
```php
AlistairShaw\Vendirun\App\Providers\VendirunServiceProvider::class

composer dump-autoload

// use this to publish all the assets including views
artisan vendor:publish

// RECOMMENDED: only copy the public assets
artisan vendor:publish --tag=public

// add --force to overwrite existing files
artisan vendor:publish --tag=public --force
```
Set the correct endpoint URL, client ID and API Key in the laravel .env file (see .env.example file)

The site is working! Now you just need to customise the CSS and any views you like

