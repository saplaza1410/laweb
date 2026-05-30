# Laweb — Plan de implementación

> **Para agentes:** REQUIRED SUB-SKILL: Usar `superpowers:subagent-driven-development` (recomendado) o `superpowers:executing-plans` para ejecutar tarea a tarea. Los pasos usan sintaxis checkbox (`- [ ]`) para seguimiento.

**Goal:** Dejar el proyecto Laravel 11 completamente funcional: entorno instalado, bugs corregidos, formulario de contacto guardando en BD, selector de idiomas (ES/EN/FR) operativo y suite de tests.

**Architecture:** Session-based i18n con middleware `SetLocale` + JSON translation files. Formulario de contacto con modelo `Contact`, migración, validación y redirect con flash. TDD: cada feature empieza con test fallido.

**Tech Stack:** PHP 8.4 (`/opt/homebrew/bin/php`), Laravel 11, SQLite, PHPUnit 11, Bootstrap 5

---

## Mapa de archivos

| Acción | Archivo |
|---|---|
| Crear | `.env` |
| Crear | `database/database.sqlite` |
| Modificar | `phpunit.xml` |
| Modificar | `routes/web.php` |
| Crear | `database/migrations/XXXX_create_contacts_table.php` |
| Crear | `app/Models/Contact.php` |
| Modificar | `app/Http/Controllers/ContactController.php` |
| Crear | `app/Http/Controllers/LocaleController.php` |
| Crear | `app/Http/Middleware/SetLocale.php` |
| Modificar | `bootstrap/app.php` |
| Crear | `lang/en.json` |
| Crear | `lang/fr.json` |
| Modificar | `resources/views/layouts/app.blade.php` |
| Modificar | `resources/views/layouts/nav.blade.php` |
| Modificar | `resources/views/layouts/footer.blade.php` |
| Modificar | `resources/views/pages/home/index.blade.php` |
| Modificar | `resources/views/pages/services/index.blade.php` |
| Modificar | `resources/views/pages/home/we.blade.php` |
| Modificar | `resources/views/pages/contacts/index.blade.php` |
| Crear | `tests/Feature/PagesTest.php` |
| Crear | `tests/Feature/ContactFormTest.php` |
| Crear | `tests/Feature/LocaleTest.php` |
| Modificar | `README.md` |

---

## Task 1: Setup del entorno

**Files:**
- Crear: `.env`
- Crear: `database/database.sqlite`

- [ ] **Step 1: Instalar dependencias PHP**

```bash
/opt/homebrew/bin/php /opt/homebrew/bin/composer install
```
Esperado: `Generating optimized autoload files` sin errores.

- [ ] **Step 2: Crear .env**

```bash
cp .env.example .env
```

- [ ] **Step 3: Ajustar valores en .env**

Editar `.env` y cambiar estas líneas:
```
APP_NAME=laweb
APP_URL=http://localhost:8000
APP_LOCALE=es
APP_FALLBACK_LOCALE=es
SESSION_DRIVER=file
```

- [ ] **Step 4: Generar APP_KEY**

```bash
/opt/homebrew/bin/php artisan key:generate
```
Esperado: `Application key set successfully.`

- [ ] **Step 5: Crear base de datos SQLite**

```bash
touch database/database.sqlite
```

- [ ] **Step 6: Ejecutar migraciones**

```bash
/opt/homebrew/bin/php artisan migrate
```
Esperado: 3 migraciones ejecutadas (`create_users_table`, `create_cache_table`, `create_jobs_table`).

- [ ] **Step 7: Commit**

```bash
git add .env database/database.sqlite
git commit -m "chore: setup entorno local (env, sqlite, dependencias)"
```

---

## Task 2: Configurar phpunit para tests en memoria

**Files:**
- Modificar: `phpunit.xml`

- [ ] **Step 1: Descomentar las líneas de SQLite en phpunit.xml**

En `phpunit.xml`, reemplazar:
```xml
        <!-- <env name="DB_CONNECTION" value="sqlite"/> -->
        <!-- <env name="DB_DATABASE" value=":memory:"/> -->
```
por:
```xml
        <env name="DB_CONNECTION" value="sqlite"/>
        <env name="DB_DATABASE" value=":memory:"/>
```

- [ ] **Step 2: Verificar que los tests de ejemplo pasan**

```bash
/opt/homebrew/bin/php artisan test
```
Esperado: `2 tests, 2 assertions` — PASS.

- [ ] **Step 3: Commit**

```bash
git add phpunit.xml
git commit -m "test: configurar SQLite in-memory para suite de tests"
```

---

## Task 3: Tests de páginas + bug fixes

**Files:**
- Crear: `tests/Feature/PagesTest.php`
- Modificar: `resources/views/pages/home/we.blade.php` (línea 28)
- Modificar: `resources/views/layouts/app.blade.php` (línea 13)
- Modificar: `resources/views/layouts/nav.blade.php` (líneas 26–27)

- [ ] **Step 1: Escribir PagesTest**

Crear `tests/Feature/PagesTest.php`:
```php
<?php

namespace Tests\Feature;

use Tests\TestCase;

class PagesTest extends TestCase
{
    public function test_home_returns_200(): void
    {
        $this->get('/')->assertStatus(200);
    }

    public function test_home_alias_returns_200(): void
    {
        $this->get('/home')->assertStatus(200);
    }

    public function test_services_returns_200(): void
    {
        $this->get('/services')->assertStatus(200);
    }

    public function test_we_returns_200(): void
    {
        $this->get('/we')->assertStatus(200);
    }

    public function test_contacts_returns_200(): void
    {
        $this->get('/contacts')->assertStatus(200);
    }

    public function test_we_page_links_to_contacts(): void
    {
        $this->get('/we')->assertSee('/contacts');
    }

    public function test_logo_uses_asset_helper(): void
    {
        $this->get('/')->assertSee('img/logo.png');
    }
}
```

- [ ] **Step 2: Ejecutar tests (deben fallar o pasar con bugs)**

```bash
/opt/homebrew/bin/php artisan test tests/Feature/PagesTest.php
```
`test_we_page_links_to_contacts` fallará — actualmente el link es `/contact`.

- [ ] **Step 3: Corregir link roto en we.blade.php**

En `resources/views/pages/home/we.blade.php`, línea 28, cambiar:
```html
¡no dudes en <a href="/contact" class="text-primary">contactarme</a>!
```
por:
```html
¡no dudes en <a href="/contacts" class="text-primary">contactarme</a>!
```

- [ ] **Step 4: Corregir ruta CSS en app.blade.php**

En `resources/views/layouts/app.blade.php`, línea 13, cambiar:
```html
    <link href="css/style.css" rel="stylesheet">
```
por:
```html
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
```

- [ ] **Step 5: Corregir logo y link en nav.blade.php**

En `resources/views/layouts/nav.blade.php`, cambiar:
```html
        <a class="navbar-brand" href="#" style="color: white;">
            <img src="img/logo.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top">
```
por:
```html
        <a class="navbar-brand" href="/" style="color: white;">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" width="30" height="30" class="d-inline-block align-text-top">
```

- [ ] **Step 6: Verificar que todos los tests pasan**

```bash
/opt/homebrew/bin/php artisan test tests/Feature/PagesTest.php
```
Esperado: `7 tests, 7 assertions` — PASS.

- [ ] **Step 7: Commit**

```bash
git add tests/Feature/PagesTest.php resources/views/pages/home/we.blade.php resources/views/layouts/app.blade.php resources/views/layouts/nav.blade.php
git commit -m "fix: corregir link roto /contact→/contacts y rutas asset()"
```

---

## Task 4: Migración y modelo Contact

**Files:**
- Crear: `tests/Feature/ContactFormTest.php`
- Crear: `database/migrations/XXXX_create_contacts_table.php`
- Crear: `app/Models/Contact.php`

- [ ] **Step 1: Escribir ContactFormTest (test de BD)**

Crear `tests/Feature/ContactFormTest.php`:
```php
<?php

namespace Tests\Feature;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_form_stores_message_in_database(): void
    {
        $this->post('/contacts', [
            'name'    => 'Ana García',
            'email'   => 'ana@example.com',
            'message' => 'Hola, me interesa tu trabajo.',
        ])->assertRedirect('/contacts');

        $this->assertDatabaseHas('contacts', [
            'name'  => 'Ana García',
            'email' => 'ana@example.com',
        ]);
    }

    public function test_contact_form_redirects_with_success_flash(): void
    {
        $this->post('/contacts', [
            'name'    => 'Pedro López',
            'email'   => 'pedro@example.com',
            'message' => 'Consulta sobre servicios.',
        ])->assertRedirect('/contacts')
          ->assertSessionHas('success');
    }

    public function test_contact_form_requires_name(): void
    {
        $this->post('/contacts', [
            'email'   => 'test@example.com',
            'message' => 'Mensaje.',
        ])->assertSessionHasErrors('name');
    }

    public function test_contact_form_requires_valid_email(): void
    {
        $this->post('/contacts', [
            'name'    => 'Test',
            'email'   => 'no-es-un-email',
            'message' => 'Mensaje.',
        ])->assertSessionHasErrors('email');
    }

    public function test_contact_form_requires_message(): void
    {
        $this->post('/contacts', [
            'name'  => 'Test',
            'email' => 'test@example.com',
        ])->assertSessionHasErrors('message');
    }

    public function test_contact_form_rejects_message_over_5000_chars(): void
    {
        $this->post('/contacts', [
            'name'    => 'Test',
            'email'   => 'test@example.com',
            'message' => str_repeat('a', 5001),
        ])->assertSessionHasErrors('message');
    }
}
```

- [ ] **Step 2: Ejecutar — deben fallar**

```bash
/opt/homebrew/bin/php artisan test tests/Feature/ContactFormTest.php
```
Esperado: FAIL — tabla `contacts` no existe todavía.

- [ ] **Step 3: Crear migración**

```bash
/opt/homebrew/bin/php artisan make:migration create_contacts_table
```
Editar el archivo generado en `database/migrations/`:
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->text('message');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
```

- [ ] **Step 4: Crear modelo Contact**

Crear `app/Models/Contact.php`:
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['name', 'email', 'message'];
}
```

- [ ] **Step 5: Ejecutar — todavía deben fallar (falta ruta POST)**

```bash
/opt/homebrew/bin/php artisan test tests/Feature/ContactFormTest.php
```
Esperado: FAIL — no hay ruta `POST /contacts`.

- [ ] **Step 6: Commit parcial**

```bash
git add database/migrations app/Models/Contact.php tests/Feature/ContactFormTest.php
git commit -m "feat: migración y modelo Contact"
```

---

## Task 5: Ruta POST, controlador y vistas del formulario

**Files:**
- Modificar: `routes/web.php`
- Modificar: `app/Http/Controllers/ContactController.php`
- Modificar: `resources/views/pages/contacts/index.blade.php`
- Modificar: `resources/views/layouts/footer.blade.php`

- [ ] **Step 1: Añadir rutas nombradas en web.php (sin lang todavía)**

Reemplazar el contenido de `routes/web.php`:
```php
<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index']);
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
Route::get('/we', [HomeController::class, 'we'])->name('we.index');
```

- [ ] **Step 2: Añadir método store() en ContactController**

Reemplazar el contenido de `app/Http/Controllers/ContactController.php`:
```php
<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('pages.contacts.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'message' => 'required|string|max:5000',
        ]);

        Contact::create($validated);

        return redirect()->route('contacts.index')
            ->with('success', 'Mensaje enviado correctamente.');
    }
}
```

- [ ] **Step 3: Actualizar vista contacts/index.blade.php**

Reemplazar el contenido de `resources/views/pages/contacts/index.blade.php`:
```blade
@extends('layouts.app')

@section('title')
Contáctenos
@endsection

@section('content')
<header class="py-5 text-center" style="background-color: #16171a; color: white;">
    <div class="container">
        <h1 class="display-4">Contáctenos</h1>
        <p class="lead">Estamos aquí para ayudarte. Completa el formulario y nos pondremos en contacto contigo.</p>
    </div>
</header>

<section class="py-5" style="background-color: #f8f9fa;">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <form action="{{ route('contacts.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="name" name="name"
                       value="{{ old('name') }}" placeholder="Tu nombre" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="email" name="email"
                       value="{{ old('email') }}" placeholder="Tu correo electrónico" required>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Mensaje</label>
                <textarea class="form-control" id="message" name="message"
                          rows="4" placeholder="Tu mensaje" required>{{ old('message') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-lg">Enviar</button>
        </form>
    </div>
</section>
@endsection
```

- [ ] **Step 4: Actualizar footer.blade.php**

Reemplazar el contenido de `resources/views/layouts/footer.blade.php`:
```blade
<footer class="bg-light text-center text-lg-start mt-auto py-3" style="background-color: #16171a !important;">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-4">
                <h4>Contáctanos</h4>
                <p>Si tienes alguna duda o pregunta, no dudes en ponerte en contacto con nosotros. Estamos aquí para ayudarte en todo lo que necesites.</p>
            </div>
            <div class="col-md-6">
                <h4>Envíanos un Mensaje</h4>
                <form action="{{ route('contacts.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="footer_name" class="form-label">Nombre</label>
                        <input type="text" class="form-control custom-input" id="footer_name"
                               name="name" placeholder="Tu nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="footer_email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control custom-input" id="footer_email"
                               name="email" placeholder="Tu correo electrónico" required>
                    </div>
                    <div class="mb-3">
                        <label for="footer_message" class="form-label">Mensaje</label>
                        <textarea class="form-control custom-input" id="footer_message"
                                  name="message" rows="4" placeholder="Tu mensaje" required></textarea>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Enviar Mensaje</button>
                    </div>
                </form>
            </div>
        </div>
        <p class="text-center mb-0">© {{ date('Y') }} Mi Sitio Web. Todos los derechos reservados.</p>
    </div>
</footer>
```

- [ ] **Step 5: Ejecutar ContactFormTest — deben pasar**

```bash
/opt/homebrew/bin/php artisan test tests/Feature/ContactFormTest.php
```
Esperado: `6 tests, 10 assertions` — PASS.

- [ ] **Step 6: Ejecutar suite completa**

```bash
/opt/homebrew/bin/php artisan test
```
Esperado: todos los tests pasan.

- [ ] **Step 7: Commit**

```bash
git add routes/web.php app/Http/Controllers/ContactController.php resources/views/pages/contacts/index.blade.php resources/views/layouts/footer.blade.php
git commit -m "feat: formulario de contacto guarda mensajes en base de datos"
```

---

## Task 6: Middleware SetLocale y LocaleController

**Files:**
- Crear: `tests/Feature/LocaleTest.php`
- Crear: `app/Http/Middleware/SetLocale.php`
- Crear: `app/Http/Controllers/LocaleController.php`
- Modificar: `bootstrap/app.php`

- [ ] **Step 1: Escribir LocaleTest**

Crear `tests/Feature/LocaleTest.php`:
```php
<?php

namespace Tests\Feature;

use Tests\TestCase;

class LocaleTest extends TestCase
{
    public function test_default_locale_is_spanish(): void
    {
        $this->get('/');
        $this->assertEquals('es', app()->getLocale());
    }

    public function test_locale_can_be_switched_to_english(): void
    {
        $this->get('/lang/en')->assertRedirect();
        $this->assertEquals('en', session('locale'));
    }

    public function test_locale_can_be_switched_to_french(): void
    {
        $this->get('/lang/fr')->assertRedirect();
        $this->assertEquals('fr', session('locale'));
    }

    public function test_invalid_locale_returns_404(): void
    {
        $this->get('/lang/de')->assertStatus(404);
    }

    public function test_locale_persists_across_requests(): void
    {
        $this->get('/lang/en');
        $this->get('/');
        $this->assertEquals('en', app()->getLocale());
    }
}
```

- [ ] **Step 2: Ejecutar — deben fallar**

```bash
/opt/homebrew/bin/php artisan test tests/Feature/LocaleTest.php
```
Esperado: FAIL — ruta `/lang/en` no existe todavía.

- [ ] **Step 3: Crear SetLocale middleware**

Crear `app/Http/Middleware/SetLocale.php`:
```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        app()->setLocale(session('locale', config('app.locale')));
        return $next($request);
    }
}
```

- [ ] **Step 4: Crear LocaleController**

Crear `app/Http/Controllers/LocaleController.php`:
```php
<?php

namespace App\Http\Controllers;

class LocaleController extends Controller
{
    private const SUPPORTED = ['es', 'en', 'fr'];

    public function switch(string $locale)
    {
        if (!in_array($locale, self::SUPPORTED, true)) {
            abort(404);
        }

        session(['locale' => $locale]);

        return redirect(url()->previous('/'));
    }
}
```

- [ ] **Step 5: Añadir ruta lang en web.php**

Añadir al final de `routes/web.php` estas dos líneas:
```php
use App\Http\Controllers\LocaleController;
// ...al final del archivo:
Route::get('/lang/{locale}', [LocaleController::class, 'switch'])->name('lang.switch');
```

El archivo completo queda:
```php
<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index']);
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
Route::get('/we', [HomeController::class, 'we'])->name('we.index');
Route::get('/lang/{locale}', [LocaleController::class, 'switch'])->name('lang.switch');
```

- [ ] **Step 6: Registrar middleware en bootstrap/app.php**

Leer el archivo `bootstrap/app.php`. Localizar el bloque `->withMiddleware(...)` y añadir dentro:
```php
$middleware->appendToGroup('web', \App\Http\Middleware\SetLocale::class);
```

El bloque resultante debe quedar así:
```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->appendToGroup('web', \App\Http\Middleware\SetLocale::class);
})
```

- [ ] **Step 7: Ejecutar LocaleTest — deben pasar**

```bash
/opt/homebrew/bin/php artisan test tests/Feature/LocaleTest.php
```
Esperado: `5 tests, 5 assertions` — PASS.

- [ ] **Step 8: Ejecutar suite completa**

```bash
/opt/homebrew/bin/php artisan test
```
Esperado: todos los tests pasan.

- [ ] **Step 9: Commit**

```bash
git add app/Http/Middleware/SetLocale.php app/Http/Controllers/LocaleController.php bootstrap/app.php routes/web.php tests/Feature/LocaleTest.php
git commit -m "feat: middleware SetLocale y ruta /lang/{locale} para i18n"
```

---

## Task 7: Archivos de traducción JSON

**Files:**
- Crear: `lang/en.json`
- Crear: `lang/fr.json`

> No se crea `lang/es.json` — Laravel usa la clave directamente como valor cuando no encuentra traducción, y las claves ya están en español.

- [ ] **Step 1: Crear lang/en.json**

Crear `lang/en.json`:
```json
{
    "Mi Sitio Web": "My Website",
    "Inicio": "Home",
    "Servicios": "Services",
    "Nosotros": "About",
    "Contacto": "Contact",
    "Idiomas": "Languages",
    "Español": "Spanish",
    "English": "English",
    "Français": "French",

    "Bienvenido a Mi Sitio Web": "Welcome to My Website",
    "Ofrecemos soluciones a medida para tu negocio": "We offer custom solutions for your business",
    "Sobre Nosotros": "About Us",
    "Bienvenido a mi página, soy Sergio Plaza, un apasionado desarrollador web con más de 5 años de experiencia en la creación de soluciones digitales innovadoras y funcionales. Desde el diseño de sitios web atractivos hasta el desarrollo de aplicaciones complejas, me dedico a ofrecer un enfoque personalizado para cada proyecto.": "Welcome to my page. I am Sergio Plaza, a passionate web developer with over 5 years of experience creating innovative and functional digital solutions. From designing attractive websites to developing complex applications, I am dedicated to offering a personalized approach to each project.",
    "Nuestros Servicios": "Our Services",
    "Desarrollo de software": "Software development",
    "Marketing digital": "Digital marketing",
    "Soporte técnico": "Technical support",
    "Desarrollo de apps": "App development",
    "¿Listo para empezar?": "Ready to start?",
    "Contáctanos hoy y descubre cómo podemos ayudarte a hacer crecer tu negocio.": "Contact us today and find out how we can help you grow your business.",
    "Contáctanos": "Contact Us",

    "Servicios Ofrecidos": "Services Offered",
    "Descubre cómo puedo ayudarte a crecer en el mundo digital.": "Discover how I can help you grow in the digital world.",
    "Desarrollo de Sitios Web": "Website Development",
    "Creo sitios web responsivos y atractivos que se adaptan a tus necesidades. Desde páginas informativas hasta tiendas en línea, garantizo una experiencia de usuario excepcional.": "I create responsive and attractive websites that adapt to your needs. From informational pages to online stores, I guarantee an exceptional user experience.",
    "Aplicaciones Web Personalizadas": "Custom Web Applications",
    "Desarrollo aplicaciones web a medida que optimizan procesos y mejoran la eficiencia de tu negocio, utilizando las últimas tecnologías del sector.": "I develop custom web applications that optimize processes and improve your business efficiency, using the latest industry technologies.",
    "Consultoría y Estrategia Digital": "Consulting and Digital Strategy",
    "Ofrezco consultoría para ayudarte a definir tu estrategia digital, asegurando que tus proyectos estén alineados con tus objetivos de negocio.": "I offer consulting to help you define your digital strategy, ensuring your projects are aligned with your business objectives.",
    "Optimización SEO": "SEO Optimization",
    "Implemento estrategias de SEO para aumentar la visibilidad de tu sitio web en los motores de búsqueda y atraer más tráfico orgánico.": "I implement SEO strategies to increase your website's visibility in search engines and attract more organic traffic.",
    "Mantenimiento y Soporte": "Maintenance and Support",
    "Proporciono servicios de mantenimiento y soporte continuo para asegurar que tu sitio web funcione sin problemas y esté siempre actualizado.": "I provide continuous maintenance and support services to ensure your website runs smoothly and stays always up to date.",
    "Formación y Talleres": "Training and Workshops",
    "Ofrezco formación y talleres para que tú y tu equipo puedan adquirir habilidades en desarrollo web y gestión de proyectos digitales.": "I offer training and workshops so you and your team can acquire skills in web development and digital project management.",

    "Sobre Mí": "About Me",
    "Soy un desarrollador web apasionado con más de 5 años de experiencia.": "I am a passionate web developer with more than 5 years of experience.",
    "Mi Trayectoria": "My Journey",
    "Desde que comencé mi carrera en el desarrollo web, he tenido la oportunidad de trabajar en una variedad de proyectos desafiantes que han ampliado mis habilidades y conocimientos. He colaborado con startups y empresas consolidadas, siempre enfocado en crear soluciones digitales que realmente marquen la diferencia.": "Since I started my career in web development, I have had the opportunity to work on a variety of challenging projects that have expanded my skills and knowledge. I have collaborated with startups and established companies, always focused on creating digital solutions that truly make a difference.",
    "Lo Que Hago": "What I Do",
    "Mi enfoque principal es el desarrollo de sitios web y aplicaciones web intuitivas y atractivas. Utilizo tecnologías modernas como HTML, CSS, JavaScript y frameworks como Laravel y React para construir productos que no solo son funcionales, sino también estéticamente agradables.": "My main focus is the development of intuitive and attractive websites and web applications. I use modern technologies such as HTML, CSS, JavaScript, and frameworks like Laravel and React to build products that are not only functional but also aesthetically pleasing.",
    "Mi Filosofía": "My Philosophy",
    "Creo firmemente en la importancia de la comunicación y la colaboración en cada proyecto. Escucho atentamente las necesidades de mis clientes y me esfuerzo por superar sus expectativas. Mi objetivo es ayudar a las empresas a crecer en el entorno digital mediante soluciones a medida y un excelente servicio al cliente.": "I firmly believe in the importance of communication and collaboration in every project. I carefully listen to my clients' needs and strive to exceed their expectations. My goal is to help businesses grow in the digital environment through customized solutions and excellent customer service.",
    "¿Listo para Comenzar?": "Ready to Start?",
    "Si estás buscando un desarrollador web que combine experiencia, pasión y dedicación, ¡no dudes en": "If you are looking for a web developer who combines experience, passion and dedication, don't hesitate to",
    "contactarme": "contact me",
    "! Estoy aquí para ayudarte a llevar tu proyecto al siguiente nivel.": "! I am here to help you take your project to the next level.",

    "Contáctenos": "Contact Us",
    "Estamos aquí para ayudarte. Completa el formulario y nos pondremos en contacto contigo.": "We are here to help you. Fill out the form and we will get in touch with you.",
    "Nombre": "Name",
    "Tu nombre": "Your name",
    "Correo Electrónico": "Email Address",
    "Tu correo electrónico": "Your email address",
    "Mensaje": "Message",
    "Tu mensaje": "Your message",
    "Enviar": "Send",
    "Mensaje enviado correctamente.": "Message sent successfully.",

    "Si tienes alguna duda o pregunta, no dudes en ponerte en contacto con nosotros. Estamos aquí para ayudarte en todo lo que necesites.": "If you have any questions, don't hesitate to get in touch with us. We are here to help you with everything you need.",
    "Envíanos un Mensaje": "Send Us a Message",
    "Enviar Mensaje": "Send Message",
    "Todos los derechos reservados.": "All rights reserved."
}
```

- [ ] **Step 2: Crear lang/fr.json**

Crear `lang/fr.json`:
```json
{
    "Mi Sitio Web": "Mon Site Web",
    "Inicio": "Accueil",
    "Servicios": "Services",
    "Nosotros": "À Propos",
    "Contacto": "Contact",
    "Idiomas": "Langues",
    "Español": "Espagnol",
    "English": "Anglais",
    "Français": "Français",

    "Bienvenido a Mi Sitio Web": "Bienvenue sur Mon Site Web",
    "Ofrecemos soluciones a medida para tu negocio": "Nous offrons des solutions sur mesure pour votre entreprise",
    "Sobre Nosotros": "À Propos de Nous",
    "Bienvenido a mi página, soy Sergio Plaza, un apasionado desarrollador web con más de 5 años de experiencia en la creación de soluciones digitales innovadoras y funcionales. Desde el diseño de sitios web atractivos hasta el desarrollo de aplicaciones complejas, me dedico a ofrecer un enfoque personalizado para cada proyecto.": "Bienvenue sur ma page. Je suis Sergio Plaza, un développeur web passionné avec plus de 5 ans d'expérience dans la création de solutions numériques innovantes et fonctionnelles. De la conception de sites web attractifs au développement d'applications complexes, je me consacre à offrir une approche personnalisée à chaque projet.",
    "Nuestros Servicios": "Nos Services",
    "Desarrollo de software": "Développement logiciel",
    "Marketing digital": "Marketing numérique",
    "Soporte técnico": "Support technique",
    "Desarrollo de apps": "Développement d'applications",
    "¿Listo para empezar?": "Prêt à commencer ?",
    "Contáctanos hoy y descubre cómo podemos ayudarte a hacer crecer tu negocio.": "Contactez-nous aujourd'hui et découvrez comment nous pouvons vous aider à développer votre entreprise.",
    "Contáctanos": "Contactez-nous",

    "Servicios Ofrecidos": "Services Proposés",
    "Descubre cómo puedo ayudarte a crecer en el mundo digital.": "Découvrez comment je peux vous aider à grandir dans le monde numérique.",
    "Desarrollo de Sitios Web": "Développement de Sites Web",
    "Creo sitios web responsivos y atractivos que se adaptan a tus necesidades. Desde páginas informativas hasta tiendas en línea, garantizo una experiencia de usuario excepcional.": "Je crée des sites web réactifs et attractifs qui s'adaptent à vos besoins. Des pages informatives aux boutiques en ligne, je garantis une expérience utilisateur exceptionnelle.",
    "Aplicaciones Web Personalizadas": "Applications Web Personnalisées",
    "Desarrollo aplicaciones web a medida que optimizan procesos y mejoran la eficiencia de tu negocio, utilizando las últimas tecnologías del sector.": "Je développe des applications web sur mesure qui optimisent les processus et améliorent l'efficacité de votre entreprise, en utilisant les dernières technologies du secteur.",
    "Consultoría y Estrategia Digital": "Conseil et Stratégie Numérique",
    "Ofrezco consultoría para ayudarte a definir tu estrategia digital, asegurando que tus proyectos estén alineados con tus objetivos de negocio.": "J'offre des conseils pour vous aider à définir votre stratégie numérique, en veillant à ce que vos projets soient alignés sur vos objectifs commerciaux.",
    "Optimización SEO": "Optimisation SEO",
    "Implemento estrategias de SEO para aumentar la visibilidad de tu sitio web en los motores de búsqueda y atraer más tráfico orgánico.": "Je mets en œuvre des stratégies de référencement pour augmenter la visibilité de votre site web dans les moteurs de recherche et attirer plus de trafic organique.",
    "Mantenimiento y Soporte": "Maintenance et Support",
    "Proporciono servicios de mantenimiento y soporte continuo para asegurar que tu sitio web funcione sin problemas y esté siempre actualizado.": "Je fournis des services de maintenance et de support continus pour garantir que votre site web fonctionne correctement et soit toujours à jour.",
    "Formación y Talleres": "Formation et Ateliers",
    "Ofrezco formación y talleres para que tú y tu equipo puedan adquirir habilidades en desarrollo web y gestión de proyectos digitales.": "J'offre des formations et des ateliers pour que vous et votre équipe puissiez acquérir des compétences en développement web et gestion de projets numériques.",

    "Sobre Mí": "À Propos de Moi",
    "Soy un desarrollador web apasionado con más de 5 años de experiencia.": "Je suis un développeur web passionné avec plus de 5 ans d'expérience.",
    "Mi Trayectoria": "Mon Parcours",
    "Desde que comencé mi carrera en el desarrollo web, he tenido la oportunidad de trabajar en una variedad de proyectos desafiantes que han ampliado mis habilidades y conocimientos. He colaborado con startups y empresas consolidadas, siempre enfocado en crear soluciones digitales que realmente marquen la diferencia.": "Depuis que j'ai commencé ma carrière dans le développement web, j'ai eu l'opportunité de travailler sur une variété de projets stimulants qui ont élargi mes compétences et mes connaissances. J'ai collaboré avec des startups et des entreprises établies, toujours concentré sur la création de solutions numériques qui font vraiment la différence.",
    "Lo Que Hago": "Ce Que Je Fais",
    "Mi enfoque principal es el desarrollo de sitios web y aplicaciones web intuitivas y atractivas. Utilizo tecnologías modernas como HTML, CSS, JavaScript y frameworks como Laravel y React para construir productos que no solo son funcionales, sino también estéticamente agradables.": "Mon objectif principal est le développement de sites web et d'applications web intuitifs et attrayants. J'utilise des technologies modernes telles que HTML, CSS, JavaScript et des frameworks comme Laravel et React pour construire des produits qui ne sont pas seulement fonctionnels, mais aussi esthétiquement agréables.",
    "Mi Filosofía": "Ma Philosophie",
    "Creo firmemente en la importancia de la comunicación y la colaboración en cada proyecto. Escucho atentamente las necesidades de mis clientes y me esfuerzo por superar sus expectativas. Mi objetivo es ayudar a las empresas a crecer en el entorno digital mediante soluciones a medida y un excelente servicio al cliente.": "Je crois fermement en l'importance de la communication et de la collaboration dans chaque projet. J'écoute attentivement les besoins de mes clients et m'efforce de dépasser leurs attentes. Mon objectif est d'aider les entreprises à croître dans l'environnement numérique grâce à des solutions personnalisées et un excellent service client.",
    "¿Listo para Comenzar?": "Prêt à Commencer ?",
    "Si estás buscando un desarrollador web que combine experiencia, pasión y dedicación, ¡no dudes en": "Si vous recherchez un développeur web qui combine expérience, passion et dédication, n'hésitez pas à",
    "contactarme": "me contacter",
    "! Estoy aquí para ayudarte a llevar tu proyecto al siguiente nivel.": " ! Je suis ici pour vous aider à amener votre projet au niveau supérieur.",

    "Contáctenos": "Contactez-nous",
    "Estamos aquí para ayudarte. Completa el formulario y nos pondremos en contacto contigo.": "Nous sommes ici pour vous aider. Remplissez le formulaire et nous vous contacterons.",
    "Nombre": "Nom",
    "Tu nombre": "Votre nom",
    "Correo Electrónico": "Adresse e-mail",
    "Tu correo electrónico": "Votre adresse e-mail",
    "Mensaje": "Message",
    "Tu mensaje": "Votre message",
    "Enviar": "Envoyer",
    "Mensaje enviado correctamente.": "Message envoyé avec succès.",

    "Si tienes alguna duda o pregunta, no dudes en ponerte en contacto con nosotros. Estamos aquí para ayudarte en todo lo que necesites.": "Si vous avez des questions, n'hésitez pas à nous contacter. Nous sommes ici pour vous aider dans tout ce dont vous avez besoin.",
    "Envíanos un Mensaje": "Envoyez-nous un Message",
    "Enviar Mensaje": "Envoyer le Message",
    "Todos los derechos reservados.": "Tous droits réservés."
}
```

- [ ] **Step 3: Commit**

```bash
git add lang/en.json lang/fr.json
git commit -m "feat: archivos de traducción EN y FR"
```

---

## Task 8: Actualizar vistas con traducciones

**Files:**
- Modificar: `resources/views/layouts/app.blade.php`
- Modificar: `resources/views/layouts/nav.blade.php`
- Modificar: `resources/views/layouts/footer.blade.php`
- Modificar: `resources/views/pages/home/index.blade.php`
- Modificar: `resources/views/pages/services/index.blade.php`
- Modificar: `resources/views/pages/home/we.blade.php`
- Modificar: `resources/views/pages/contacts/index.blade.php`

- [ ] **Step 1: Ampliar LocaleTest con verificación de traducciones**

Añadir estos tests al final de `tests/Feature/LocaleTest.php` (antes del último `}`):
```php
    public function test_home_shows_spanish_by_default(): void
    {
        $this->get('/')->assertSee('Bienvenido a Mi Sitio Web');
    }

    public function test_home_shows_english_after_switch(): void
    {
        $this->get('/lang/en');
        $this->get('/')->assertSee('Welcome to My Website');
    }

    public function test_home_shows_french_after_switch(): void
    {
        $this->get('/lang/fr');
        $this->get('/')->assertSee('Bienvenue sur Mon Site Web');
    }

    public function test_nav_shows_translated_links(): void
    {
        $this->get('/lang/en');
        $this->get('/')->assertSee('Home')->assertSee('Services');
    }
```

- [ ] **Step 2: Ejecutar LocaleTest — los 3 nuevos deben fallar**

```bash
/opt/homebrew/bin/php artisan test tests/Feature/LocaleTest.php
```
Esperado: los 4 nuevos tests FAIL — vistas aún no usan `__()`.

- [ ] **Step 3: Actualizar app.blade.php**

Reemplazar el contenido de `resources/views/layouts/app.blade.php`:
```blade
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', __('Mi Sitio Web'))</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    @include('layouts.nav')
    <div>
        @yield('pantalla')
    </div>
    <div class="container mt-4">
        @yield('content')
    </div>
    @include('layouts.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
```

- [ ] **Step 4: Actualizar nav.blade.php**

Reemplazar el contenido de `resources/views/layouts/nav.blade.php`:
```blade
<div class="py-2" style="background-color: rgb(84 152 209);"></div>

<div class="py-2" style="background-color: #16171a; color: white;">
    <div class="container d-flex justify-content-end">
        <a href="https://www.facebook.com" target="_blank" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
        <a href="https://www.instagram.com" target="_blank" class="text-white me-3"><i class="fab fa-instagram"></i></a>
        <a href="https://www.google.com" target="_blank" class="text-white me-3"><i class="fab fa-google"></i></a>
        <a href="https://www.linkedin.com" target="_blank" class="text-white"><i class="fab fa-linkedin-in"></i></a>
    </div>
</div>

<nav class="navbar navbar-expand-lg" style="background-color: #16171a;">
    <div class="container">
        <a class="navbar-brand" href="/" style="color: white;">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" width="30" height="30" class="d-inline-block align-text-top">
            {{ __('Mi Sitio Web') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"
                style="background-color: white; border: none;">
            <span class="navbar-toggler-icon" style="background-color: white;"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/home">{{ __('Inicio') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/services">{{ __('Servicios') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/we">{{ __('Nosotros') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/contacts">{{ __('Contacto') }}</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        {{ __('Idiomas') }}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item {{ app()->getLocale() === 'es' ? 'fw-bold' : '' }}"
                               href="{{ route('lang.switch', 'es') }}">{{ __('Español') }}</a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ app()->getLocale() === 'en' ? 'fw-bold' : '' }}"
                               href="{{ route('lang.switch', 'en') }}">{{ __('English') }}</a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ app()->getLocale() === 'fr' ? 'fw-bold' : '' }}"
                               href="{{ route('lang.switch', 'fr') }}">{{ __('Français') }}</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
```

- [ ] **Step 5: Actualizar footer.blade.php**

Reemplazar el contenido de `resources/views/layouts/footer.blade.php`:
```blade
<footer class="bg-light text-center text-lg-start mt-auto py-3" style="background-color: #16171a !important;">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-4">
                <h4>{{ __('Contáctanos') }}</h4>
                <p>{{ __('Si tienes alguna duda o pregunta, no dudes en ponerte en contacto con nosotros. Estamos aquí para ayudarte en todo lo que necesites.') }}</p>
            </div>
            <div class="col-md-6">
                <h4>{{ __('Envíanos un Mensaje') }}</h4>
                <form action="{{ route('contacts.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="footer_name" class="form-label">{{ __('Nombre') }}</label>
                        <input type="text" class="form-control custom-input" id="footer_name"
                               name="name" placeholder="{{ __('Tu nombre') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="footer_email" class="form-label">{{ __('Correo Electrónico') }}</label>
                        <input type="email" class="form-control custom-input" id="footer_email"
                               name="email" placeholder="{{ __('Tu correo electrónico') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="footer_message" class="form-label">{{ __('Mensaje') }}</label>
                        <textarea class="form-control custom-input" id="footer_message"
                                  name="message" rows="4" placeholder="{{ __('Tu mensaje') }}" required></textarea>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">{{ __('Enviar Mensaje') }}</button>
                    </div>
                </form>
            </div>
        </div>
        <p class="text-center mb-0">© {{ date('Y') }} {{ __('Mi Sitio Web') }}. {{ __('Todos los derechos reservados.') }}</p>
    </div>
</footer>
```

- [ ] **Step 6: Actualizar home/index.blade.php**

Reemplazar el contenido de `resources/views/pages/home/index.blade.php`:
```blade
@extends('layouts.app')
@section('pantalla')
<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="{{ asset('img/carrusel/1.jpg') }}" class="d-block w-100 h-70" alt="Imagen 1">
        </div>
        <div class="carousel-item">
            <img src="{{ asset('img/carrusel/2.jpg') }}" class="d-block w-100" alt="Imagen 2">
        </div>
        <div class="carousel-item">
            <img src="{{ asset('img/carrusel/3.jpg') }}" class="d-block w-100" alt="Imagen 3">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Siguiente</span>
    </button>
</div>
@endsection

@section('content')
<header class="py-5 text-center" style="background-color: #16171a; color: white;">
    <div class="container">
        <h1 class="display-4">{{ __('Bienvenido a Mi Sitio Web') }}</h1>
        <p class="lead">{{ __('Ofrecemos soluciones a medida para tu negocio') }}</p>
    </div>
</header>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2>{{ __('Sobre Nosotros') }}</h2>
                <p>{{ __('Bienvenido a mi página, soy Sergio Plaza, un apasionado desarrollador web con más de 5 años de experiencia en la creación de soluciones digitales innovadoras y funcionales. Desde el diseño de sitios web atractivos hasta el desarrollo de aplicaciones complejas, me dedico a ofrecer un enfoque personalizado para cada proyecto.') }}</p>
            </div>
            <div class="col-md-6">
                <h2>{{ __('Nuestros Servicios') }}</h2>
                <ul>
                    <li>{{ __('Desarrollo de software') }}</li>
                    <li>{{ __('Marketing digital') }}</li>
                    <li>{{ __('Soporte técnico') }}</li>
                    <li>{{ __('Desarrollo de apps') }}</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="text-center py-5" style="background-color: #f8f9fa;">
    <div class="container">
        <h2>{{ __('¿Listo para empezar?') }}</h2>
        <p>{{ __('Contáctanos hoy y descubre cómo podemos ayudarte a hacer crecer tu negocio.') }}</p>
        <a href="/contacts" class="btn btn-primary btn-lg">{{ __('Contáctanos') }}</a>
    </div>
</section>
@endsection
```

- [ ] **Step 7: Actualizar services/index.blade.php**

Reemplazar el contenido de `resources/views/pages/services/index.blade.php`:
```blade
@extends('layouts.app')

@section('title')
{{ __('Servicios') }}
@endsection

@section('content')
<header class="py-5 text-center" style="background-color: #16171a; color: white;">
    <div class="container">
        <h1 class="display-4">{{ __('Servicios Ofrecidos') }}</h1>
        <p class="lead">{{ __('Descubre cómo puedo ayudarte a crecer en el mundo digital.') }}</p>
    </div>
</header>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">{{ __('Desarrollo de Sitios Web') }}</h5>
                    </div>
                    <div class="card-body">
                        <p>{{ __('Creo sitios web responsivos y atractivos que se adaptan a tus necesidades. Desde páginas informativas hasta tiendas en línea, garantizo una experiencia de usuario excepcional.') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">{{ __('Aplicaciones Web Personalizadas') }}</h5>
                    </div>
                    <div class="card-body">
                        <p>{{ __('Desarrollo aplicaciones web a medida que optimizan procesos y mejoran la eficiencia de tu negocio, utilizando las últimas tecnologías del sector.') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">{{ __('Consultoría y Estrategia Digital') }}</h5>
                    </div>
                    <div class="card-body">
                        <p>{{ __('Ofrezco consultoría para ayudarte a definir tu estrategia digital, asegurando que tus proyectos estén alineados con tus objetivos de negocio.') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">{{ __('Optimización SEO') }}</h5>
                    </div>
                    <div class="card-body">
                        <p>{{ __('Implemento estrategias de SEO para aumentar la visibilidad de tu sitio web en los motores de búsqueda y atraer más tráfico orgánico.') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">{{ __('Mantenimiento y Soporte') }}</h5>
                    </div>
                    <div class="card-body">
                        <p>{{ __('Proporciono servicios de mantenimiento y soporte continuo para asegurar que tu sitio web funcione sin problemas y esté siempre actualizado.') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">{{ __('Formación y Talleres') }}</h5>
                    </div>
                    <div class="card-body">
                        <p>{{ __('Ofrezco formación y talleres para que tú y tu equipo puedan adquirir habilidades en desarrollo web y gestión de proyectos digitales.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
```

- [ ] **Step 8: Actualizar home/we.blade.php**

Reemplazar el contenido de `resources/views/pages/home/we.blade.php`:
```blade
@extends('layouts.app')

@section('title')
{{ __('Nosotros') }}
@endsection

@section('content')
<header class="py-5 text-center" style="background-color: #16171a; color: white;">
    <div class="container">
        <h1 class="display-4">{{ __('Sobre Mí') }}</h1>
        <p class="lead">{{ __('Soy un desarrollador web apasionado con más de 5 años de experiencia.') }}</p>
    </div>
</header>

<section class="py-5">
    <div class="container">
        <h2>{{ __('Mi Trayectoria') }}</h2>
        <p>{{ __('Desde que comencé mi carrera en el desarrollo web, he tenido la oportunidad de trabajar en una variedad de proyectos desafiantes que han ampliado mis habilidades y conocimientos. He colaborado con startups y empresas consolidadas, siempre enfocado en crear soluciones digitales que realmente marquen la diferencia.') }}</p>

        <h2>{{ __('Lo Que Hago') }}</h2>
        <p>{{ __('Mi enfoque principal es el desarrollo de sitios web y aplicaciones web intuitivas y atractivas. Utilizo tecnologías modernas como HTML, CSS, JavaScript y frameworks como Laravel y React para construir productos que no solo son funcionales, sino también estéticamente agradables.') }}</p>

        <h2>{{ __('Mi Filosofía') }}</h2>
        <p>{{ __('Creo firmemente en la importancia de la comunicación y la colaboración en cada proyecto. Escucho atentamente las necesidades de mis clientes y me esfuerzo por superar sus expectativas. Mi objetivo es ayudar a las empresas a crecer en el entorno digital mediante soluciones a medida y un excelente servicio al cliente.') }}</p>

        <h2>{{ __('¿Listo para Comenzar?') }}</h2>
        <p>
            {{ __('Si estás buscando un desarrollador web que combine experiencia, pasión y dedicación, ¡no dudes en') }}
            <a href="/contacts" class="text-primary">{{ __('contactarme') }}</a>{{ __('! Estoy aquí para ayudarte a llevar tu proyecto al siguiente nivel.') }}
        </p>
    </div>
</section>
@endsection
```

- [ ] **Step 9: Actualizar contacts/index.blade.php**

Reemplazar el contenido de `resources/views/pages/contacts/index.blade.php`:
```blade
@extends('layouts.app')

@section('title')
{{ __('Contáctenos') }}
@endsection

@section('content')
<header class="py-5 text-center" style="background-color: #16171a; color: white;">
    <div class="container">
        <h1 class="display-4">{{ __('Contáctenos') }}</h1>
        <p class="lead">{{ __('Estamos aquí para ayudarte. Completa el formulario y nos pondremos en contacto contigo.') }}</p>
    </div>
</header>

<section class="py-5" style="background-color: #f8f9fa;">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <form action="{{ route('contacts.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">{{ __('Nombre') }}</label>
                <input type="text" class="form-control" id="name" name="name"
                       value="{{ old('name') }}" placeholder="{{ __('Tu nombre') }}" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">{{ __('Correo Electrónico') }}</label>
                <input type="email" class="form-control" id="email" name="email"
                       value="{{ old('email') }}" placeholder="{{ __('Tu correo electrónico') }}" required>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">{{ __('Mensaje') }}</label>
                <textarea class="form-control" id="message" name="message"
                          rows="4" placeholder="{{ __('Tu mensaje') }}" required>{{ old('message') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-lg">{{ __('Enviar') }}</button>
        </form>
    </div>
</section>
@endsection
```

- [ ] **Step 10: Ejecutar suite completa — todos los tests deben pasar**

```bash
/opt/homebrew/bin/php artisan test
```
Esperado: todos los tests PASS (incluidos los 4 nuevos de LocaleTest).

- [ ] **Step 11: Commit**

```bash
git add resources/views/ tests/Feature/LocaleTest.php lang/
git commit -m "feat: i18n completo — vistas traducidas ES/EN/FR con selector de idioma"
```

---

## Task 9: README

**Files:**
- Modificar: `README.md`

- [ ] **Step 1: Reemplazar README con documentación del proyecto**

Reemplazar el contenido de `README.md`:
```markdown
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
```

- [ ] **Step 2: Commit final**

```bash
git add README.md
git commit -m "docs: README con instrucciones de instalación y uso del proyecto"
```

---

## Verificación final

- [ ] Ejecutar suite completa una última vez:

```bash
/opt/homebrew/bin/php artisan test --verbose
```

- [ ] Arrancar servidor y verificar manualmente:

```bash
/opt/homebrew/bin/php artisan serve
```

Comprobar: Home carga, carousel funciona, formulario de contacto envía y muestra flash de éxito, selector de idiomas cambia los textos del navbar y las páginas.
