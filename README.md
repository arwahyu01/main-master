<p style="text-align: center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p style="text-align: center">
PHP Framework For Web Artisans
</p>

<h3 style="text-align: center"> Main Master </h3>
<p style="text-align: center">
Main Master is the base project for laravel projects. This project was created to make it easier for developers to create laravel projects. This project is build with laravel 10 and bootstrap 5.
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
# From Packagist
$ composer create-project arwp/main-master
# ---- OR -----
# Clone the repository
$ git clone https://github.com/arwahyu01/main-master.git
$ cd main-master
$ composer install
$ cp .env.example .env
$ php artisan key:generate
$ php artisan migrate --seed
$ php artisan serve # or use valet
```

## Custom Script
#### For Datatable
- use this script to send multiple data to 'datatable.blade.js'
```
    <script type="application/javascript">
        fetch("{{ url('/js/'.$backend.'/'.$page->code.'/datatable.js') }}", {
            method: 'POST',
            headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
            body: JSON.stringify({id: "{{ $id }}"})
        }).then(e => e.text()).then(r => eval?.(`"use strict";(${r})`));
    </script>
```
- `JSON.stringify({'id': "{{ $id }}",'id2': "{{ $id2 }}"})` for multiple id or data
- Warning: `eval` function is not secure, so don't remove `?.` in `eval?.` function for security reason
- Add `$id`, in datatable.blade.js file like this :
```
    $('#datatable').DataTable({
        ajax: "{{ url(config('master.app.url.backend').'/'.$url.'/data/'.$id) }}",`
    });
```

## Features for developer
Install this package to your laravel project
```bash
composer require arwp/mvc
```
#### Don't forget to set the configuration, read more <a href="https://github.com/arwahyu01/mvc-builder" target="_blank">here</a>
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
- No License (free to use for personal)[README.md](..%2Fmvc-builder%2FREADME.md)
- Template `Eduadmin` is not free, you can buy it in [here](https://themeforest.net/item/eduadmin-responsive-bootstrap-admin-template-dashboard/29365133)
- please give me a star & follow my github account if you like this project :)
- Don't remove the credits in any of the files
- Buy me a coffee [here](https://trakteer.id/arwp)

#### i hope this project can help you to make your project faster and easier to develop :)
