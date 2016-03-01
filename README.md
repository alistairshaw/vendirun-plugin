# SETUP #

### Vendirun Laravel Package ###

* This package can be pulled in to any Laravel project and provides all of the default Vendirun front-end functionality
* Latest Stable Version: 1.0.6.2

### Importing the package into a new front-end ###

* Add the repository to your composer.json:
"repositories": [
    {
      "type": "git",
      "url": "git@github.com:alistairshaw/vendirun-plugin.git"
    }
  ],
* Add the package to the require list:
"require": {
        "php": ">=5.5.9",
        "laravel/framework": "5.1.*",
        "alistairshaw/vendirun": "1.*"
    },

* Add the namespace to the PSR-4 section ("AlistairShaw\\Vendirun\\": "vendor/alistairshaw/vendirun")
* Edit the /config/app.php file and add the VendirunServiceProvider to the app (AlistairShaw\Vendirun\App\Providers\VendirunServiceProvider::class)
* composer dump-autoload
* Use 'artisan vendor:publish' to copy public assets to the right place (add tag --tag=public to only publish the images, css, etc and --tag=languages to only publish the language files. Use --force to overwrite existing files)
* Set the correct endpoint URL, client ID and API Key in the laravel .env file (see .env.example file)
* The site is working! Now you just need to customise the CSS and any views you like