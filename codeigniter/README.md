# CodeIgniter Project Setup
A web application project setup using [CodeIgniter](https://codeigniter.com/) (v3.1.6).

## Third-party
This setup includes the following third-party tools, fonts, modules, or frameworks:
- [Bootstrap](https://getbootstrap.com/docs/3.3/) (with responsive grid only)
- [jQuery](https://jquery.com/)
- [Material Design Lite](https://getmdl.io/)
- [Material Icons](https://material.io/icons/)
- Roboto Font ([Normal](https://fonts.google.com/specimen/Roboto), [Condensed](https://fonts.google.com/specimen/Roboto+Condensed), [Mono](https://fonts.google.com/specimen/Roboto+Mono), [Slab](https://fonts.google.com/specimen/Roboto+Slab))
- [my](https://github.com/Arnesfield/project-my)
- [inherit.js](https://github.com/Arnesfield/inherit.js)

## What's inside?
CodeIgniter's **application** and **system** directories are separated from the **public** directory.

```
project/
|-- codeigniter/
|   |-- application/
|   |-- system/
|
|-- public/
    |-- assets/
    |   |-- css/
    |   |-- images/
    |   |-- js/
    |
    |-- vendor/
    |   |-- third-party/
    |
    |-- .htaccess
    |-- index.php
```

## Release Notes
### v1.4 ([latest](https://github.com/Arnesfield/ci-setup/releases/latest))
- Added `MY_CRUD_Model` in `application/core`.

### v1.3.1
- Updated CodeIgniter from `v3.1.5` to `v3.1.6`.
- Updated and fixed `codeigniter/.gitignore`.

### v1.3
- Allowed multiple views to load in `MY_View_Controller`
- Fixed `index.php` problem in `base_url`

### v1.2
- Updated `MY_View_Controller` in `application/core`
- Updated dynamic `base_url` in `config/config.php`
- Restricted directory listing in `public/.htaccess`
- Removed `any` route in `config/routes.php`

### v1.1
- Added custom controller for handling views
- Renamed `codeigniter/app/` to `codeigniter/application/`
- Added `email.php.example` in `application/config/`