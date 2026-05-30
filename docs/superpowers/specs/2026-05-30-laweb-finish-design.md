# Diseño: Finalización de laweb

**Fecha:** 2026-05-30  
**Proyecto:** Portfolio/web de servicios de Sergio Plaza — Laravel 11  
**Objetivo:** Instalar dependencias, corregir bugs, implementar formulario de contacto con BD, añadir i18n (ES/EN/FR) y cubrir con tests.

---

## 1. Setup del entorno

- `composer install` usando PHP 8.4 (`/opt/homebrew/bin/php`)
- Crear `.env` copiando `.env.example`, ajustar `APP_NAME=laweb`, `APP_URL=http://localhost:8000`
- Generar `APP_KEY` con `artisan key:generate`
- DB: SQLite (`database/database.sqlite`) — ya está configurado en `.env.example`
- Ejecutar migraciones: `artisan migrate`

## 2. Bug fixes

| Archivo | Problema | Solución |
|---|---|---|
| `resources/views/pages/home/we.blade.php:28` | Link a `/contact` (ruta no existe) | Cambiar a `/contacts` |
| `resources/views/layouts/app.blade.php:13` | `href="css/style.css"` (ruta relativa) | `{{ asset('css/style.css') }}` |
| `resources/views/layouts/nav.blade.php:26-27` | Logo link `#`, `src="img/logo.png"` | `href="/"` y `{{ asset('img/logo.png') }}` |
| `resources/views/pages/contacts/index.blade.php` | Form sin `action`, sin `@csrf`, sin `method` | Añadir `action="{{ route('contacts.store') }}"`, `method="POST"`, `@csrf` |
| `resources/views/layouts/footer.blade.php` | Form sin `action`, sin `@csrf`, sin `method` | Igual que arriba |

## 3. Formulario de contacto → Base de datos

### Migración
Tabla `contacts`:
- `id` — bigint autoincrement PK
- `name` — string(255), not null
- `email` — string(255), not null
- `message` — text, not null
- `timestamps` — created_at, updated_at

### Modelo
`App\Models\Contact` con `$fillable = ['name', 'email', 'message']`.

### Rutas
```
GET  /contacts       → ContactController::index()   (ya existe)
POST /contacts       → ContactController::store()   (nueva)
```
Named routes: `contacts.index`, `contacts.store`.

### Controlador — `ContactController::store()`
1. Validar: `name` required|string|max:255, `email` required|email|max:255, `message` required|string|max:5000
2. `Contact::create($validated)`
3. Redirect a `contacts.index` con flash `success` = "Mensaje enviado correctamente."

### Vistas
- Formulario en `contacts/index.blade.php`: añadir `action`, `@csrf`, mostrar `@if(session('success'))` con alert Bootstrap verde.
- Formulario en `footer.blade.php`: misma `action` y `@csrf`. El footer muestra el mismo flash de éxito si hay sesión activa.

## 4. Internacionalización (i18n)

### Estrategia: Session-based locale
- Locale se guarda en sesión: `session(['locale' => 'es'])`
- Middleware `App\Http\Middleware\SetLocale` aplica el locale en cada request
- Locale por defecto: `es`
- Locales soportados: `es`, `en`, `fr`

### Ruta de cambio
```
GET /lang/{locale}   → LocaleController::switch()
```
- Valida que `$locale` ∈ `['es', 'en', 'fr']`
- Guarda en sesión, redirige a `url()->previous()` (o `/` si no hay referrer)

### Archivos de traducción
Formato JSON en `lang/`:
- `lang/es.json` — Español (idioma base, todas las strings del sitio)
- `lang/en.json` — English
- `lang/fr.json` — Français

Strings a traducir: todos los textos visibles en las vistas (títulos, párrafos, labels, placeholders, botones, mensajes flash).

### Actualización de vistas
Todos los textos estáticos en Blade se reemplazan por `__('clave')`. La clave es el texto en español (convención JSON de Laravel).

### Navbar — selector de idiomas
Los `<a>` del dropdown apuntan a `{{ route('lang.switch', 'es') }}` etc. Se muestra el idioma activo con una marca visual (negrita o check).

## 5. Tests

### Feature tests — `tests/Feature/`

**`PagesTest.php`**
- `test_home_returns_200`
- `test_services_returns_200`
- `test_we_returns_200`
- `test_contacts_returns_200`

**`ContactFormTest.php`**
- `test_contact_form_stores_message_in_database`
- `test_contact_form_redirects_with_success_flash`
- `test_contact_form_validates_required_fields`
- `test_contact_form_validates_email_format`

**`LocaleTest.php`**
- `test_default_locale_is_spanish`
- `test_locale_can_be_switched_to_english`
- `test_locale_can_be_switched_to_french`
- `test_invalid_locale_is_rejected` (debe devolver 404 — `abort(404)` si locale no está en `['es','en','fr']`)

### Configuración
- Usar `RefreshDatabase` en `ContactFormTest`
- DB de test: SQLite in-memory (`:memory:`) para rapidez

## 6. README

Reemplazar el README genérico de Laravel con documentación específica del proyecto:
- Descripción del proyecto
- Requisitos (PHP 8.2+, Composer, SQLite)
- Pasos de instalación
- Idiomas soportados
- Estructura de rutas
