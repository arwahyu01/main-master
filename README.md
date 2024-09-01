<p style="text-align: center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p style="text-align: center">
PHP Framework For Web Artisans
</p>

<h2 style="text-align: center"> Main Master </h2>
<h3 style="text-align: center">( Crud Generator )</h3>
<p style="text-align: center">
Main Master is a CRUD generator for Laravel projects. This project was created to make it easier for developers to create Laravel projects. This project is built with Laravel 11 and Bootstrap 5.
</p>
<p style="text-align: center">
Made with ❤️ by <a href="https://www.linkedin.com/in/arwahyupradana/" target="_blank">arwp</a>
</p>

## Requirements

- Laravel 11 or higher
- PHP 8.2 or higher
- MySQL 5.7 or higher or any other database
- Composer 2.2.* or higher

## Features Master
- [x] Login with authentication (email and password)
- [x] CRUD with ajax request
- [x] role and permission management
- [x] Sidebar notification
- [x] Header notification
- [x] Create a menu seeder and access the menu using the php artisan `app:convert-menu command`.
- [x] Morph File
- [x] Default Menu
    - [x] Dashboard
    - [x] Menu with sub menu (multi level)
    - [x] Role Management
      - [x] Access Group
      - [x] Level Access
      - [x] Access Menu
    - [x] Faq
    - [x] user management
    - [x] Announcement

## How to install
```bash
# From Packagist
$ composer create-project arwp/main-master {your-project-name}
# ---- OR -----
# Clone the repository
$ git clone https://github.com/arwahyu01/main-master.git {your-project-name}
$ cd main-master
$ composer install
$ cp .env.example .env
$ php artisan key:generate
$ php artisan migrate --seed
$ php artisan serve # or use valet
```

## Custom Script
#### For Datatables
- use this script to send multiple data to 'datatable.blade.js'
```
    <script type="application/javascript">
        fetch("{{ url('/js/'.$backend.'/'.$page->code.'/datatable.js') }}", {
            method: 'POST',
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({id: "{{ $id }}"})
        })
        .then(e => e.text())
        .then(r => {
            Function('"use strict";\n' + r)();
        }).catch(e => console.log(e));
    </script>
```
- `JSON.stringify({'id': "{{ $id }}",'id2': "{{ $id2 }}"})` for multiple request
- `JSON.stringify({id: "{{ $id }}"})` for single request
- Add `$id`, in datatable.blade.js file like this :
```
    $('#datatable').DataTable({
        ajax: `{{ url(config('master.app.url.backend').'/'.$url.'/data?id='${id}') }}`,
    });
```

## Features for developer (MVC Builder) :
Install this package to your laravel project
```bash
composer require arwp/mvc
```
#### Don't forget to set the configuration, read more [here](https://github.com/arwahyu01/mvc-builder)
### How to use this package :
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

## License
- MVC Builder Package: This package is offered with no license, making it free to use for personal projects.
- Eduadmin Template: The Eduadmin template used for the views in this package is not free. You'll need to purchase a license for commercial use from [here](https://themeforest.net/item/eduadmin-responsive-bootstrap-admin-template-dashboard/29365133).
- Copyright and Attribution: Please respect the copyright of the package and its contributors. Do not remove the credits included within the files.

#### I hope this MVC Builder makes your development process faster and easier! 😊
