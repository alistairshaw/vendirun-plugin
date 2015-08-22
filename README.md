# SETUP #

### Vendirun Laravel Package ###

* This package can be pulled in to any Laravel project and provides all of the default Vendirun front-end functionality
* Version 1.0

### Setting up the package for further development ###

* Create the folder: /packages/AlistairShaw/vendirun and clone the repo into it
* composer require illuminate/html (in the root)
* Edit the /config/app.php file and add the VendirunServiceProvider to the app (AlistairShaw\Vendirun\App\Providers\VendirunServiceProvider::class)
* Edit your composer.json in the root and add the Vendirun namespace to the PSR-4 section ("AlistairShaw\\Vendirun\\": "packages/AlistairShaw/vendirun/app/")
* Run composer dump-autoload
* Edit the /packages/AlistairShaw/vendirun/src/config/vendirun.php file, and set the correct endpoint, API key and client ID
* Use 'artisan vendor:publish' to copy public assets to the right place (add tag --tag=public to only publish the images, css, etc and use --force to overwrite existing files)

### Importing the package into a new front-end ###

* //todo: write this section