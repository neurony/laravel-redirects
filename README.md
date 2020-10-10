# Package discontinued! Check out VARBOX.IO instead.

Unfortunately this package is now discontinued.   
Please check out [Varbox](https://varbox.io) (Laravel Admin Panel) for this functionality and much more.

- Buy: [https://varbox.io/buy](https://varbox.io/buy)
- Docs: [https://varbox.io/docs](https://varbox.io/docs)
- Demo: [https://demo.varbox.test/admin](https://demo.varbox.test/admin)
- Repo [https://github.com/VarboxInternational/varbox](https://github.com/VarboxInternational/varbox)

Thank you! 

---

### Nested redirects for Laravel

[![Build Status](https://travis-ci.org/Neurony/laravel-redirects.svg?branch=master)](https://travis-ci.org/Neurony/laravel-redirects)
[![StyleCI](https://github.styleci.io/repos/189837919/shield?branch=master)](https://github.styleci.io/repos/189837919)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Neurony/laravel-redirects/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Neurony/laravel-redirects/?branch=master)

- [Overview](#overview)   
- [Installation](#installation)   
- [Usage](#usage)   

### Overview

This package allows you to create simple or multiple nested redirects for your Laravel applications.   
   
This package can be useful from an SEO perspective, when in your application, you have URLs that have the potential of being modified.
   
**Example of the dynamic redirecting logic:**
* Let's assume you have an URL called `/original`   
   
* You create a redirect from `/original` to `/modified`
  > Accessing `/original` will redirect to `/modified`   
* You create another redirect from `/modified` to `/modified-again`   
  > Accessing `/modified` will redirect to `/modified-again` AND   
  > Accessoing `/original` will redirect to `/modified-again`   
* You create another redirect from `/modified-again` to `/modified-yet-again`   
  > Accessing `/modified-again` will redirect to `/modified-yet-again` AND      
  > Accessing `/modified` will redirect to `/modified-yet-again` AND   
  > Accessing `/original` will redirect to `/modified-yet-again`   
* You create another redirect from `modified-yet-again` to `/original`  
  > Accessing `/modified-yet-again` will redirect to `/original` AND   
  > Accessing `/modified-again` will redirect to `/original` AND   
  > Accessing `/modified` will redirect to `/original`
  
### Installation

Install the package via Composer:

```
composer require neurony/laravel-redirects
```

Publish the config file with:

```
php artisan vendor:publish --provider="Neurony\Redirects\ServiceProvider" --tag="config"
```

Publish the migration file with:

```
php artisan vendor:publish --provider="Neurony\Redirects\ServiceProvider" --tag="migrations"
```

After the migration has been published you can create the `redirects` table by running:

```
php artisan migrate
```

### Usage

##### Add the middleware

In order for the redirecting functionality to actually happen, you need to add the `Neurony\Redirects\Middleware\RedirectRequests` middleware.

Go to `App\Http\Kernel` and add the `Neurony\Redirects\Middleware\RedirectRequests` middleware in your `$middlewareGroups` groups of choice.

```php
/**
 * The application's route middleware groups.
 *
 * @var array
 */
protected $middlewareGroups = [
    'web' => [
        ...
        \Neurony\Redirects\Middleware\RedirectRequests::class,
```

##### Creating redirects

You should never use the `Neurony\Redirects\Models\Redirect` directly, as this is the default concrete implementation for the `Neurony\Redirects\Contracts\RedirectModelContract`.   
  
Using the `Neurony\Redirects\Models\Redirect` model class directly will prevent you from being able to extend the model's capabilities.

You can create redirects that will be stored inside the `redirects` table like this:   

```php
app('redirect.model')->create([
    'old_url' => '/your-old-url',
    'new_url' => '/your-new-url',
    'status' => 301
]);
```

To see how you can extend the `Neurony\Redirects\Models\Redirect` model's capabilities, please read the comments from `/config/redirects.php -> redirect_model`

### Credits

- [Andrei Badea](https://github.com/zbiller)
- [All Contributors](../../contributors)

### Security

If you discover any security related issues, please email andrei.badea@neurony.ro instead of using the issue tracker.

### License

The MIT License (MIT). Please see [LICENSE](LICENSE.md) for more information.

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

### Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.
