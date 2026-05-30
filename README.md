# laweb — Portfolio de Sergio Plaza

Sitio web de portfolio y servicios para desarrollador web freelance. Construido con Laravel 11.

## Características

- Páginas: Inicio, Servicios, Nosotros, Contacto
- Formulario de contacto con guardado en base de datos
- Selector de idiomas: Español / English / Français
- Diseño responsivo con Bootstrap 5

## Requisitos

- PHP 8.2+
- Composer
- SQLite (incluido en PHP)

## Instalación

```bash
composer install
cp .env.example .env
# Editar .env: APP_LOCALE=es, SESSION_DRIVER=file
php artisan key:generate
touch database/database.sqlite
php artisan migrate
php artisan serve
```

Abre http://localhost:8000

## Tests

```bash
php artisan test
```

## Rutas

| Método | Ruta | Descripción |
|---|---|---|
| GET | / | Inicio |
| GET | /services | Servicios |
| GET | /we | Nosotros |
| GET | /contacts | Formulario de contacto |
| POST | /contacts | Guardar mensaje |
| GET | /lang/{locale} | Cambiar idioma (es/en/fr) |
