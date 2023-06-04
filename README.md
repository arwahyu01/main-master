<p style="text-align: center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p style="text-align: center">
PHP Framework For Web Artisans
</p>

<h3 style="text-align: center"> Main Master </h3>
<p style="text-align: center">
Main Master is a laravel project that can be used as a base project for your laravel project. This project is made to make it easier for developers to create a laravel project. This project is made with laravel 10 and bootstrap 5.
</p>
<p style="text-align: center">
Made with ❤️ by <a href="https://www.linkedin.com/in/arwahyupradana/" target="_blank">arwp</a>
</p>

## Requirements

- Laravel 10 or higher
- PHP 8.1 or higher
- MySQL 5.7 or higher or any other database
- Composer 2.2.* or higher

## Features Master
- [x] Login with authentication (email and password)
- [x] CRUD with ajax request
- [x] role and permission management
- [x] Default Menu
    - [x] Dashboard
    - [x] Menu with sub menu (multi level)
    - [x] Role Management
      - [x] Access Group
      - [x] Level Access
      - [x] Access Menu
    - [x] Faq
    - [x] user management
    - [x] Morph File

## How to install
```bash
# Clone the repository
$ git clone https://gitlab.com/arwahyu/main-master.git
$ cd Main-Master
$ composer install
$ cp .env.example .env
$ php artisan key:generate
$ php artisan migrate --seed
$ php artisan serve # or use valet
``` 

## Features for developer
Install this package to your laravel project
```bash
composer require arwp/mvc
```
## Setup and Configuration :
add this code to your config/app.php
```
'providers' => [
    ...
    Arwp\Mvc\MvcServiceProvider::class,
    ...
]
```
you need to publish the resource file to your project
```bash
$ php artisan vendor:publish --provider="Arwp\Mvc\MvcServiceProvider"
  #publised file config/mvc.php
  #publised file routes/mvc-route.php
  #publised file Console/Commands/createMvc.php
  #publised file Console/Commands/deleteMvc.php
````
add this code to your routeServiceProvider.php
```
public function boot()
{
    ...
    Route::middleware(['web'])->namespace('App\Http\Controllers')->group(base_path('routes/mvc-route.php'));
    ...
}
```

open file config/mvc.php and change the key value to your path folder
```
return [
    'path_controller' => 'app/Http/Controllers', // this is path to controller folder
    'path_model' => 'app/Models', // this is path to model folder
    'path_view' => 'views', // this is path to view folder (e.g: views/backend or views/frontend)
    'path_route' => 'routes/mvc-route.php', // path to route file (default: routes/mvc-route.php)
    'route_prefix' => 'backend', // route prefix (e.g: backend, admin, etc) (optional)
];
```
if you want to change the default "PATH ROUTE" you can change it in config/mvc.php
```
return [
    ...
    'path_route' => 'routes/web.php', // change this to your route file
    ...
];
```
Copy the code below to your route file (e.g: routes/web.php)
```
//{{route replacer}} DON'T REMOVE THIS LINE
```

## How to use package :
  - Run `php artisan make:mvc [name]` in your terminal to create a module
    - [x] Controller (with CRUD function)
    - [x] Model (with fillable and relation)
    - [x] Migration (with table and relation)
    - [x] views (with CRUD function)
    - [x] routes 
  - Run `php artisan migrate` to create table
    - add new menu in menu table
    - add access menu in access menu table

  - Run `php artisan delete:mvc [name]` to delete a module (delete all file and table in database)

### Custom Script
#### Datatable
- use this script for send data to datatable js
```
    <script type="application/javascript">
        fetch("{{ url('/js/'.$backend.'/'.$page->code.'/datatable.js') }}", {
            method: 'POST',
            headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
            body: JSON.stringify({id: "{{ $id }}"})
        }).then(e => e.text()).then(r => eval?.(`"use strict";(${r})`));
    </script>
```
- you can use `JSON.stringify({'id': "{{ $id }}",'id2': "{{ $id2 }}"})` for multiple id
- Warning: `eval` function is not secure, so you don't remove `?.` in `eval?.` function for security reason
- Add `$id`, in datatable js file like this :
```
    $('#datatable').DataTable({
        ajax: "{{ url(config('master.app.url.backend').'/'.$url.'/data/'.$id) }}",`
    });
```

## License
- No License (free to use for personal and commercial use)
- please give me a star if you like this project, and don't remove the credits in any of the files

#### i hope this project can help you to make your project faster and easier to develop :)
