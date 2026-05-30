# Rediseño Visual Laweb — Plan de implementación

> **Para agentes:** REQUIRED SUB-SKILL: Usar `superpowers:subagent-driven-development` (recomendado) o `superpowers:executing-plans` para ejecutar tarea a tarea. Los pasos usan sintaxis checkbox (`- [ ]`) para seguimiento.

**Goal:** Rediseñar visualmente el sitio portfolio de Sergio Plaza con estética profesional azul marino + blanco, sin tocar backend, rutas ni lógica existente.

**Architecture:** Reescritura completa de `style.css` con variables CSS, Bootstrap 5 como grid base, Google Fonts Inter, Font Awesome ya cargado. Cada tarea actualiza una sección HTML + valida con tests de estructura.

**Tech Stack:** PHP 8.4 (`/opt/homebrew/bin/php`), Laravel 11, Bootstrap 5, Font Awesome 6, Google Fonts (Inter), PHPUnit 11

---

## Mapa de archivos

| Acción | Archivo |
|---|---|
| Reescribir | `public/css/style.css` |
| Modificar | `resources/views/layouts/app.blade.php` |
| Modificar | `resources/views/layouts/nav.blade.php` |
| Modificar | `resources/views/layouts/footer.blade.php` |
| Modificar | `resources/views/pages/home/index.blade.php` |
| Modificar | `resources/views/pages/services/index.blade.php` |
| Modificar | `resources/views/pages/home/we.blade.php` |
| Modificar | `resources/views/pages/contacts/index.blade.php` |
| Modificar | `lang/en.json` |
| Modificar | `lang/fr.json` |
| Crear | `tests/Feature/DesignTest.php` |

---

## Task 1: CSS completo + Google Fonts

**Files:**
- Reescribir: `public/css/style.css`
- Modificar: `resources/views/layouts/app.blade.php`
- Crear: `tests/Feature/DesignTest.php`

- [ ] **Step 1: Escribir el test (fallará hasta que añadamos la fuente)**

Crear `tests/Feature/DesignTest.php`:
```php
<?php

namespace Tests\Feature;

use Tests\TestCase;

class DesignTest extends TestCase
{
    public function test_app_loads_inter_font(): void
    {
        $this->get('/')->assertSee('fonts.googleapis.com', false);
    }
}
```

- [ ] **Step 2: Ejecutar — debe fallar**

```bash
/opt/homebrew/bin/php artisan test tests/Feature/DesignTest.php
```
Esperado: FAIL — `fonts.googleapis.com` no está en `app.blade.php` todavía.

- [ ] **Step 3: Añadir Google Fonts en `resources/views/layouts/app.blade.php`**

Reemplazar el contenido completo del archivo:
```blade
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', __('Mi Sitio Web'))</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    @include('layouts.nav')
    <div>
        @yield('pantalla')
    </div>
    <div class="container-fluid px-0">
        @yield('content')
    </div>
    @include('layouts.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
```

> Nota: se cambia `container mt-4` por `container-fluid px-0` para que el `.page-header` y secciones de fondo lleguen a los bordes.

- [ ] **Step 4: Reescribir `public/css/style.css` completamente**

```css
/* ============================================
   CSS Variables & Base
   ============================================ */
:root {
    --navy-dark:   #0f172a;
    --navy-mid:    #1e3a5f;
    --blue-accent: #2563eb;
    --blue-light:  #eff6ff;
    --white:       #ffffff;
    --text-muted:  #64748b;
    --border:      #e2e8f0;
}

*, *::before, *::after { box-sizing: border-box; }

body {
    font-family: 'Inter', sans-serif;
    color: #1e293b;
    line-height: 1.75;
}

h1, h2, h3, h4, h5, h6 {
    font-weight: 700;
    color: var(--navy-dark);
}

.text-accent { color: var(--blue-accent); }

/* ============================================
   Navbar
   ============================================ */
.navbar {
    background-color: var(--navy-dark) !important;
    transition: box-shadow 0.3s ease;
    position: sticky;
    top: 0;
    z-index: 1000;
}

.navbar.scrolled {
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.35);
}

.navbar-brand {
    color: white !important;
    font-weight: 700;
    font-size: 1.1rem;
}

.brand-dot {
    color: var(--blue-accent);
    margin-right: 2px;
    font-size: 1.4rem;
    line-height: 0;
    vertical-align: middle;
}

.nav-link {
    color: rgba(255, 255, 255, 0.85) !important;
    padding: 6px 14px !important;
    position: relative;
    transition: color 0.3s;
    border: none !important;
    border-radius: 0 !important;
    background: transparent !important;
}

.nav-link::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 14px;
    right: 14px;
    height: 2px;
    background: var(--blue-accent);
    transform: scaleX(0);
    transition: transform 0.3s ease;
    border-radius: 2px;
}

.nav-link:hover { color: white !important; }
.nav-link:hover::after { transform: scaleX(1); }

.nav-link.active {
    background-color: var(--blue-accent) !important;
    color: white !important;
    border-radius: 6px !important;
    padding: 4px 12px !important;
}

.nav-link.active::after { display: none; }

.dropdown-menu {
    background-color: var(--navy-mid);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 8px;
    padding: 6px;
}

.dropdown-item {
    color: rgba(255, 255, 255, 0.85);
    border-radius: 6px;
    padding: 6px 14px;
    transition: background 0.2s;
}

.dropdown-item:hover,
.dropdown-item:focus {
    background-color: var(--blue-accent);
    color: white;
}

.dropdown-item.fw-bold { color: var(--blue-accent); }

/* Social bar */
.social-bar a { transition: color 0.3s; }
.social-bar .fa-facebook-f:hover  { color: #1877f2 !important; }
.social-bar .fa-instagram:hover   { color: #e4405f !important; }
.social-bar .fa-google:hover      { color: #ea4335 !important; }
.social-bar .fa-linkedin-in:hover { color: #0a66c2 !important; }

/* ============================================
   Hero Carousel
   ============================================ */
.carousel {
    height: 75vh;
    min-height: 480px;
    overflow: hidden;
    position: relative;
}

.carousel-item {
    height: 75vh;
    min-height: 480px;
    position: relative;
}

.carousel-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    filter: brightness(0.9);
}

.carousel-item::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(15,23,42,0.85) 0%, rgba(37,99,235,0.35) 100%);
}

.hero-caption {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    color: white;
    z-index: 10;
    width: 80%;
    max-width: 800px;
}

.hero-caption h1 {
    font-size: clamp(2rem, 5vw, 3.5rem);
    font-weight: 700;
    color: white;
    text-shadow: 0 2px 8px rgba(0,0,0,0.3);
    margin-bottom: 1rem;
}

.hero-caption p {
    font-size: clamp(1rem, 2vw, 1.25rem);
    color: rgba(255,255,255,0.85);
    margin-bottom: 2rem;
}

.btn-hero {
    background-color: var(--blue-accent);
    color: white;
    border: none;
    border-radius: 50px;
    padding: 14px 40px;
    font-weight: 600;
    font-size: 1rem;
    transition: background 0.3s, transform 0.2s;
    text-decoration: none;
    display: inline-block;
}

.btn-hero:hover {
    background-color: var(--navy-mid);
    color: white;
    transform: translateY(-2px);
}

.carousel-indicators [data-bs-target] {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background-color: rgba(255,255,255,0.5);
    border: none;
    margin: 0 4px;
}

.carousel-indicators .active { background-color: white; }

.carousel-control-prev-icon,
.carousel-control-next-icon {
    background-color: rgba(255,255,255,0.15);
    border-radius: 50%;
    width: 44px;
    height: 44px;
    padding: 8px;
    transition: background 0.3s;
}

.carousel-control-prev:hover .carousel-control-prev-icon,
.carousel-control-next:hover .carousel-control-next-icon {
    background-color: var(--blue-accent);
}

/* Stats bar */
.stats-bar {
    background-color: var(--blue-accent);
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    padding: 1.5rem 2rem;
}

.stat-item {
    text-align: center;
    padding: 0.5rem 2.5rem;
    border-right: 1px solid rgba(255,255,255,0.3);
}

.stat-item:last-child { border-right: none; }

.stat-number {
    display: block;
    font-size: 2rem;
    font-weight: 700;
    color: white;
    line-height: 1.1;
}

.stat-label {
    display: block;
    font-size: 0.82rem;
    color: rgba(255,255,255,0.8);
    margin-top: 2px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

/* ============================================
   Home Content Sections
   ============================================ */
.section-title {
    border-left: 4px solid var(--blue-accent);
    padding-left: 1rem;
    margin-bottom: 1.25rem;
}

.services-list { list-style: none; padding-left: 0; }
.services-list li { padding: 4px 0; }

.cta-section {
    background: linear-gradient(135deg, var(--navy-dark) 0%, var(--navy-mid) 100%);
    color: white;
    padding: 4rem 0;
    text-align: center;
}

.cta-section h2 { color: white; }
.cta-section p  { color: rgba(255,255,255,0.85); }

.btn-cta-outline {
    background-color: white;
    color: var(--blue-accent);
    border: 2px solid white;
    border-radius: 50px;
    padding: 12px 36px;
    font-weight: 600;
    transition: all 0.3s;
    text-decoration: none;
    display: inline-block;
}

.btn-cta-outline:hover {
    background-color: var(--blue-accent);
    color: white;
    border-color: var(--blue-accent);
}

/* ============================================
   Page Header (services, contacts, we)
   ============================================ */
.page-header {
    background: linear-gradient(135deg, var(--navy-dark) 0%, var(--navy-mid) 100%);
    color: white;
    padding: 4rem 0;
    text-align: center;
}

.page-header h1 {
    color: white;
    font-size: clamp(1.8rem, 4vw, 2.8rem);
}

.page-header p {
    color: rgba(255,255,255,0.8);
    font-size: 1.1rem;
}

/* ============================================
   Service Cards
   ============================================ */
.service-card {
    border: none;
    border-top: 4px solid var(--blue-accent);
    border-radius: 12px;
    box-shadow: 0 2px 16px rgba(0,0,0,0.07);
    transition: transform 0.3s ease, box-shadow 0.3s ease, border-top-color 0.3s ease;
    height: 100%;
}

.service-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 8px 32px rgba(37,99,235,0.15);
    border-top-color: var(--navy-mid);
}

.service-header {
    background: white;
    border-bottom: 1px solid var(--border);
    text-align: center;
    padding: 1.5rem 1rem 1rem;
    border-radius: 8px 8px 0 0;
}

.service-icon {
    font-size: 2.2rem;
    color: var(--blue-accent);
    display: block;
    margin-bottom: 0.6rem;
}

.service-header h5 {
    color: var(--navy-dark);
    font-weight: 700;
    margin: 0;
    font-size: 1rem;
}

.service-card .card-body {
    padding: 1.25rem;
    color: var(--text-muted);
    font-size: 0.95rem;
}

/* ============================================
   Timeline (Nosotros)
   ============================================ */
.timeline {
    border-left: 3px solid var(--blue-accent);
    margin-left: 1.5rem;
    padding-left: 2rem;
    margin-top: 1rem;
}

.timeline-item {
    position: relative;
    margin-bottom: 2rem;
}

.timeline-dot {
    position: absolute;
    left: -2.65rem;
    top: 0.4rem;
    width: 14px;
    height: 14px;
    background-color: var(--blue-accent);
    border-radius: 50%;
    border: 2px solid white;
    box-shadow: 0 0 0 3px rgba(37,99,235,0.25);
}

.timeline-item h5 {
    color: var(--navy-dark);
    font-weight: 700;
    margin-bottom: 0.4rem;
}

.timeline-item p {
    color: var(--text-muted);
    margin: 0;
}

.section-icon {
    color: var(--blue-accent);
    margin-right: 0.75rem;
    vertical-align: middle;
}

.cta-light {
    background-color: var(--blue-light);
    border-radius: 12px;
    padding: 2rem;
    text-align: center;
}

/* ============================================
   Contact Form & Info
   ============================================ */
.contact-info-card {
    background-color: var(--navy-dark);
    border-radius: 12px;
    padding: 2rem;
    height: 100%;
    color: white;
}

.contact-info-card h4 {
    color: white;
    font-weight: 700;
    margin-bottom: 1.5rem;
}

.contact-info-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 1.25rem;
    color: rgba(255,255,255,0.85);
}

.contact-info-item i {
    color: var(--blue-accent);
    font-size: 1.1rem;
    margin-top: 2px;
    flex-shrink: 0;
}

.contact-form-card {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 4px 24px rgba(0,0,0,0.08);
}

.contact-form-card .form-control {
    border: 2px solid var(--border);
    border-radius: 8px;
    padding: 12px 16px;
    font-family: 'Inter', sans-serif;
    font-size: 0.95rem;
    transition: border-color 0.3s, box-shadow 0.3s;
}

.contact-form-card .form-control:focus {
    border-color: var(--blue-accent);
    box-shadow: 0 0 0 3px rgba(37,99,235,0.15);
    outline: none;
}

.contact-form-card .form-label {
    font-weight: 600;
    color: var(--navy-dark);
    margin-bottom: 0.4rem;
}

.btn-submit {
    background-color: var(--blue-accent);
    color: white;
    border: none;
    border-radius: 8px;
    padding: 12px 28px;
    font-weight: 600;
    width: 100%;
    transition: background 0.3s, transform 0.2s;
}

.btn-submit:hover {
    background-color: var(--navy-mid);
    color: white;
    transform: translateY(-1px);
}

/* ============================================
   Footer
   ============================================ */
footer {
    background-color: var(--navy-dark) !important;
    border-top: 1px solid rgba(255,255,255,0.08);
    color: white;
    padding: 3rem 0 1.5rem;
}

.footer-brand {
    font-size: 1.2rem;
    font-weight: 700;
    color: white;
    margin-bottom: 0.4rem;
}

.footer-tagline {
    color: rgba(255,255,255,0.55);
    font-size: 0.9rem;
    margin-bottom: 1.25rem;
}

.social-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(255,255,255,0.08);
    color: rgba(255,255,255,0.7);
    text-decoration: none;
    transition: background 0.3s, color 0.3s;
    margin-right: 8px;
}

.social-icon:hover { background: rgba(255,255,255,0.15); color: white; }
.social-icon:hover .fa-facebook-f  { color: #1877f2; }
.social-icon:hover .fa-instagram   { color: #e4405f; }
.social-icon:hover .fa-google      { color: #ea4335; }
.social-icon:hover .fa-linkedin-in { color: #0a66c2; }

footer h4 {
    color: white;
    font-weight: 700;
    font-size: 1rem;
    margin-bottom: 1.25rem;
}

footer .form-label { color: rgba(255,255,255,0.75); }

.custom-input {
    background-color: rgba(255,255,255,0.07);
    border: 1px solid rgba(255,255,255,0.15);
    color: white;
    border-radius: 8px;
    padding: 10px 14px;
    font-family: 'Inter', sans-serif;
    transition: border-color 0.3s, background 0.3s;
}

.custom-input::placeholder { color: rgba(255,255,255,0.4); }

.custom-input:focus {
    border-color: var(--blue-accent);
    background-color: rgba(255,255,255,0.1);
    outline: none;
    box-shadow: 0 0 0 2px rgba(37,99,235,0.3);
    color: white;
}

.footer-copyright {
    text-align: center;
    color: rgba(255,255,255,0.35);
    font-size: 0.85rem;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid rgba(255,255,255,0.06);
}

footer .btn-primary {
    background-color: var(--blue-accent);
    border-color: var(--blue-accent);
    border-radius: 8px;
    font-weight: 600;
    transition: background 0.3s;
}

footer .btn-primary:hover {
    background-color: var(--navy-mid);
    border-color: var(--navy-mid);
}
```

- [ ] **Step 5: Ejecutar DesignTest — debe pasar**

```bash
/opt/homebrew/bin/php artisan test tests/Feature/DesignTest.php
```
Esperado: `1 test, 1 assertion` — PASS.

- [ ] **Step 6: Ejecutar suite completa — todos los 24 tests deben seguir pasando**

```bash
/opt/homebrew/bin/php artisan test
```
Esperado: 25 tests, todos pasan.

- [ ] **Step 7: Commit**

```bash
git add public/css/style.css resources/views/layouts/app.blade.php tests/Feature/DesignTest.php
git commit -m "feat: CSS completo azul marino — variables, tipografía Inter, todos los componentes"
```

---

## Task 2: Navbar rediseño

**Files:**
- Modificar: `resources/views/layouts/nav.blade.php`
- Modificar: `tests/Feature/DesignTest.php`

- [ ] **Step 1: Añadir test al final de `tests/Feature/DesignTest.php`** (antes del `}` final de la clase)

```php
    public function test_navbar_has_brand_dot(): void
    {
        $this->get('/')->assertSee('brand-dot', false);
    }

    public function test_navbar_has_scroll_script(): void
    {
        $this->get('/')->assertSee('scrolled', false);
    }

    public function test_navbar_has_social_bar_class(): void
    {
        $this->get('/')->assertSee('social-bar', false);
    }
```

- [ ] **Step 2: Ejecutar — deben fallar**

```bash
/opt/homebrew/bin/php artisan test tests/Feature/DesignTest.php
```
Esperado: 3 nuevos tests FAIL.

- [ ] **Step 3: Reemplazar `resources/views/layouts/nav.blade.php`**

```blade
<div class="py-2" style="background-color: rgb(84 152 209);"></div>

<div class="py-2 social-bar" style="background-color: var(--navy-dark, #0f172a); color: white;">
    <div class="container d-flex justify-content-end">
        <a href="https://www.facebook.com" target="_blank" class="text-white me-3">
            <i class="fab fa-facebook-f"></i>
        </a>
        <a href="https://www.instagram.com" target="_blank" class="text-white me-3">
            <i class="fab fa-instagram"></i>
        </a>
        <a href="https://www.google.com" target="_blank" class="text-white me-3">
            <i class="fab fa-google"></i>
        </a>
        <a href="https://www.linkedin.com" target="_blank" class="text-white">
            <i class="fab fa-linkedin-in"></i>
        </a>
    </div>
</div>

<nav class="navbar navbar-expand-lg" style="background-color: #0f172a;">
    <div class="container">
        <a class="navbar-brand" href="/" style="color: white;">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" width="30" height="30" class="d-inline-block align-text-top me-1">
            <span class="brand-dot">·</span>{{ __('Mi Sitio Web') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"
                style="background-color: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center">
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
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
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

<script>
window.addEventListener('scroll', function () {
    document.querySelector('.navbar').classList.toggle('scrolled', window.scrollY > 20);
});
</script>
```

- [ ] **Step 4: Ejecutar DesignTest — todos deben pasar**

```bash
/opt/homebrew/bin/php artisan test tests/Feature/DesignTest.php
```
Esperado: 4 tests, todos pasan.

- [ ] **Step 5: Verificar suite completa**

```bash
/opt/homebrew/bin/php artisan test
```
Esperado: 28 tests, todos pasan.

- [ ] **Step 6: Commit**

```bash
git add resources/views/layouts/nav.blade.php tests/Feature/DesignTest.php
git commit -m "feat: navbar azul marino con hover animado, brand-dot y sticky scroll"
```

---

## Task 3: Hero + Stats bar

**Files:**
- Modificar: `resources/views/pages/home/index.blade.php`
- Modificar: `tests/Feature/DesignTest.php`

- [ ] **Step 1: Añadir tests**

Añadir al final de la clase en `tests/Feature/DesignTest.php`:
```php
    public function test_home_has_hero_caption(): void
    {
        $this->get('/')->assertSee('hero-caption', false);
    }

    public function test_home_has_stats_bar(): void
    {
        $this->get('/')->assertSee('stats-bar', false);
    }

    public function test_stats_bar_has_four_items(): void
    {
        $this->get('/')->assertSee('stat-item', false);
    }
```

- [ ] **Step 2: Ejecutar — deben fallar**

```bash
/opt/homebrew/bin/php artisan test tests/Feature/DesignTest.php --filter="hero\|stats"
```
Esperado: 3 tests FAIL.

- [ ] **Step 3: Reemplazar el `@section('pantalla')` en `resources/views/pages/home/index.blade.php`**

Reemplazar el contenido completo del archivo:
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
            <img src="{{ asset('img/carrusel/1.jpg') }}" alt="Imagen 1">
        </div>
        <div class="carousel-item">
            <img src="{{ asset('img/carrusel/2.jpg') }}" alt="Imagen 2">
        </div>
        <div class="carousel-item">
            <img src="{{ asset('img/carrusel/3.jpg') }}" alt="Imagen 3">
        </div>
    </div>
    <div class="hero-caption">
        <h1>{{ __('Bienvenido a Mi Sitio Web') }}</h1>
        <p>{{ __('Ofrecemos soluciones a medida para tu negocio') }}</p>
        <a href="/contacts" class="btn-hero">{{ __('Contáctanos') }}</a>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">{{ __('Anterior') }}</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">{{ __('Siguiente') }}</span>
    </button>
</div>

<div class="stats-bar">
    <div class="stat-item">
        <span class="stat-number">5+</span>
        <span class="stat-label">{{ __('Años de experiencia') }}</span>
    </div>
    <div class="stat-item">
        <span class="stat-number">50+</span>
        <span class="stat-label">{{ __('Proyectos completados') }}</span>
    </div>
    <div class="stat-item">
        <span class="stat-number">3</span>
        <span class="stat-label">{{ __('Idiomas') }}</span>
    </div>
    <div class="stat-item">
        <span class="stat-number">100%</span>
        <span class="stat-label">{{ __('Dedicación') }}</span>
    </div>
</div>
@endsection

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2 class="section-title">{{ __('Sobre Nosotros') }}</h2>
                <p>{{ __('Bienvenido a mi página, soy Sergio Plaza, un apasionado desarrollador web con más de 5 años de experiencia en la creación de soluciones digitales innovadoras y funcionales. Desde el diseño de sitios web atractivos hasta el desarrollo de aplicaciones complejas, me dedico a ofrecer un enfoque personalizado para cada proyecto.') }}</p>
            </div>
            <div class="col-md-6">
                <h2 class="section-title">{{ __('Nuestros Servicios') }}</h2>
                <ul class="services-list">
                    <li><i class="fas fa-check text-accent me-2"></i>{{ __('Desarrollo de software') }}</li>
                    <li><i class="fas fa-check text-accent me-2"></i>{{ __('Marketing digital') }}</li>
                    <li><i class="fas fa-check text-accent me-2"></i>{{ __('Soporte técnico') }}</li>
                    <li><i class="fas fa-check text-accent me-2"></i>{{ __('Desarrollo de apps') }}</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<div class="cta-section">
    <div class="container">
        <h2>{{ __('¿Listo para empezar?') }}</h2>
        <p class="mb-4">{{ __('Contáctanos hoy y descubre cómo podemos ayudarte a hacer crecer tu negocio.') }}</p>
        <a href="/contacts" class="btn-cta-outline">{{ __('Contáctanos') }}</a>
    </div>
</div>
@endsection
```

- [ ] **Step 4: Ejecutar DesignTest — todos deben pasar**

```bash
/opt/homebrew/bin/php artisan test tests/Feature/DesignTest.php
```
Esperado: 7 tests, todos pasan.

- [ ] **Step 5: Verificar suite completa**

```bash
/opt/homebrew/bin/php artisan test
```
Esperado: 31 tests, todos pasan.

- [ ] **Step 6: Commit**

```bash
git add resources/views/pages/home/index.blade.php tests/Feature/DesignTest.php
git commit -m "feat: hero con overlay gradiente, stats bar azul y CTA navy"
```

---

## Task 4: Página Servicios — cards con iconos

**Files:**
- Modificar: `resources/views/pages/services/index.blade.php`
- Modificar: `tests/Feature/DesignTest.php`

- [ ] **Step 1: Añadir tests**

```php
    public function test_services_page_has_service_icons(): void
    {
        $this->get('/services')->assertSee('service-icon', false);
    }

    public function test_services_page_has_fa_code_icon(): void
    {
        $this->get('/services')->assertSee('fa-code', false);
    }

    public function test_services_page_has_page_header(): void
    {
        $this->get('/services')->assertSee('page-header', false);
    }
```

- [ ] **Step 2: Ejecutar — deben fallar**

```bash
/opt/homebrew/bin/php artisan test tests/Feature/DesignTest.php --filter="service"
```
Esperado: 3 tests FAIL.

- [ ] **Step 3: Reemplazar `resources/views/pages/services/index.blade.php`**

```blade
@extends('layouts.app')

@section('title')
{{ __('Servicios') }}
@endsection

@section('content')
<div class="page-header">
    <div class="container">
        <h1 class="display-4">{{ __('Servicios Ofrecidos') }}</h1>
        <p class="lead">{{ __('Descubre cómo puedo ayudarte a crecer en el mundo digital.') }}</p>
    </div>
</div>

<section class="py-5 bg-white">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card service-card">
                    <div class="service-header">
                        <i class="fas fa-code service-icon"></i>
                        <h5>{{ __('Desarrollo de Sitios Web') }}</h5>
                    </div>
                    <div class="card-body">
                        <p>{{ __('Creo sitios web responsivos y atractivos que se adaptan a tus necesidades. Desde páginas informativas hasta tiendas en línea, garantizo una experiencia de usuario excepcional.') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card service-card">
                    <div class="service-header">
                        <i class="fas fa-laptop-code service-icon"></i>
                        <h5>{{ __('Aplicaciones Web Personalizadas') }}</h5>
                    </div>
                    <div class="card-body">
                        <p>{{ __('Desarrollo aplicaciones web a medida que optimizan procesos y mejoran la eficiencia de tu negocio, utilizando las últimas tecnologías del sector.') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card service-card">
                    <div class="service-header">
                        <i class="fas fa-chart-line service-icon"></i>
                        <h5>{{ __('Consultoría y Estrategia Digital') }}</h5>
                    </div>
                    <div class="card-body">
                        <p>{{ __('Ofrezco consultoría para ayudarte a definir tu estrategia digital, asegurando que tus proyectos estén alineados con tus objetivos de negocio.') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card service-card">
                    <div class="service-header">
                        <i class="fas fa-magnifying-glass service-icon"></i>
                        <h5>{{ __('Optimización SEO') }}</h5>
                    </div>
                    <div class="card-body">
                        <p>{{ __('Implemento estrategias de SEO para aumentar la visibilidad de tu sitio web en los motores de búsqueda y atraer más tráfico orgánico.') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card service-card">
                    <div class="service-header">
                        <i class="fas fa-screwdriver-wrench service-icon"></i>
                        <h5>{{ __('Mantenimiento y Soporte') }}</h5>
                    </div>
                    <div class="card-body">
                        <p>{{ __('Proporciono servicios de mantenimiento y soporte continuo para asegurar que tu sitio web funcione sin problemas y esté siempre actualizado.') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card service-card">
                    <div class="service-header">
                        <i class="fas fa-graduation-cap service-icon"></i>
                        <h5>{{ __('Formación y Talleres') }}</h5>
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

- [ ] **Step 4: Ejecutar tests — todos deben pasar**

```bash
/opt/homebrew/bin/php artisan test tests/Feature/DesignTest.php
```
Esperado: 10 tests, todos pasan.

- [ ] **Step 5: Verificar suite completa**

```bash
/opt/homebrew/bin/php artisan test
```
Esperado: 34 tests, todos pasan.

- [ ] **Step 6: Commit**

```bash
git add resources/views/pages/services/index.blade.php tests/Feature/DesignTest.php
git commit -m "feat: cards de servicios con iconos Font Awesome y hover elevación"
```

---

## Task 5: Página Nosotros — timeline

**Files:**
- Modificar: `resources/views/pages/home/we.blade.php`
- Modificar: `tests/Feature/DesignTest.php`

- [ ] **Step 1: Añadir tests**

```php
    public function test_we_page_has_timeline(): void
    {
        $this->get('/we')->assertSee('timeline', false);
    }

    public function test_we_page_has_timeline_dot(): void
    {
        $this->get('/we')->assertSee('timeline-dot', false);
    }

    public function test_we_page_has_section_icons(): void
    {
        $this->get('/we')->assertSee('section-icon', false);
    }
```

- [ ] **Step 2: Ejecutar — deben fallar**

```bash
/opt/homebrew/bin/php artisan test tests/Feature/DesignTest.php --filter="we_page"
```
Esperado: 3 tests FAIL.

- [ ] **Step 3: Reemplazar `resources/views/pages/home/we.blade.php`**

```blade
@extends('layouts.app')

@section('title')
{{ __('Nosotros') }}
@endsection

@section('content')
<div class="page-header">
    <div class="container">
        <h1 class="display-4">{{ __('Sobre Mí') }}</h1>
        <p class="lead">{{ __('Soy un desarrollador web apasionado con más de 5 años de experiencia.') }}</p>
    </div>
</div>

<section class="py-5">
    <div class="container">
        <h2 class="section-title">{{ __('Mi Trayectoria') }}</h2>
        <div class="timeline">
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <h5>{{ __('Inicio de carrera') }}</h5>
                <p>{{ __('Desde que comencé mi carrera en el desarrollo web, he tenido la oportunidad de trabajar en una variedad de proyectos desafiantes que han ampliado mis habilidades y conocimientos.') }}</p>
            </div>
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <h5>{{ __('Proyectos destacados') }}</h5>
                <p>{{ __('He colaborado con startups y empresas consolidadas, siempre enfocado en crear soluciones digitales que realmente marquen la diferencia.') }}</p>
            </div>
        </div>

        <h2 class="section-title mt-5">
            <i class="fas fa-laptop fa-lg section-icon"></i>{{ __('Lo Que Hago') }}
        </h2>
        <p>{{ __('Mi enfoque principal es el desarrollo de sitios web y aplicaciones web intuitivas y atractivas. Utilizo tecnologías modernas como HTML, CSS, JavaScript y frameworks como Laravel y React para construir productos que no solo son funcionales, sino también estéticamente agradables.') }}</p>

        <h2 class="section-title mt-5">
            <i class="fas fa-handshake fa-lg section-icon"></i>{{ __('Mi Filosofía') }}
        </h2>
        <p>{{ __('Creo firmemente en la importancia de la comunicación y la colaboración en cada proyecto. Escucho atentamente las necesidades de mis clientes y me esfuerzo por superar sus expectativas. Mi objetivo es ayudar a las empresas a crecer en el entorno digital mediante soluciones a medida y un excelente servicio al cliente.') }}</p>

        <div class="cta-light mt-5">
            <h4>{{ __('¿Listo para Comenzar?') }}</h4>
            <p class="mb-3">
                {{ __('Si estás buscando un desarrollador web que combine experiencia, pasión y dedicación, ¡no dudes en') }}
                <a href="/contacts" class="text-primary">{{ __('contactarme') }}</a>{{ __('! Estoy aquí para ayudarte a llevar tu proyecto al siguiente nivel.') }}
            </p>
            <a href="/contacts" class="btn btn-primary px-4">{{ __('Contáctanos') }}</a>
        </div>
    </div>
</section>
@endsection
```

- [ ] **Step 4: Ejecutar tests — todos deben pasar**

```bash
/opt/homebrew/bin/php artisan test tests/Feature/DesignTest.php
```
Esperado: 13 tests, todos pasan.

- [ ] **Step 5: Verificar suite completa**

```bash
/opt/homebrew/bin/php artisan test
```
Esperado: 37 tests, todos pasan.

- [ ] **Step 6: Commit**

```bash
git add resources/views/pages/home/we.blade.php tests/Feature/DesignTest.php
git commit -m "feat: página Nosotros con timeline y iconos de sección"
```

---

## Task 6: Página Contacto — 2 columnas

**Files:**
- Modificar: `resources/views/pages/contacts/index.blade.php`
- Modificar: `tests/Feature/DesignTest.php`

- [ ] **Step 1: Añadir tests**

```php
    public function test_contacts_page_has_info_card(): void
    {
        $this->get('/contacts')->assertSee('contact-info-card', false);
    }

    public function test_contacts_page_has_form_card(): void
    {
        $this->get('/contacts')->assertSee('contact-form-card', false);
    }

    public function test_contacts_page_has_paper_plane_icon(): void
    {
        $this->get('/contacts')->assertSee('fa-paper-plane', false);
    }
```

- [ ] **Step 2: Ejecutar — deben fallar**

```bash
/opt/homebrew/bin/php artisan test tests/Feature/DesignTest.php --filter="contacts_page"
```
Esperado: 3 tests FAIL.

- [ ] **Step 3: Reemplazar `resources/views/pages/contacts/index.blade.php`**

```blade
@extends('layouts.app')

@section('title')
{{ __('Contáctenos') }}
@endsection

@section('content')
<div class="page-header">
    <div class="container">
        <h1 class="display-4">{{ __('Contáctenos') }}</h1>
        <p class="lead">{{ __('Estamos aquí para ayudarte. Completa el formulario y nos pondremos en contacto contigo.') }}</p>
    </div>
</div>

<section class="py-5" style="background-color: #f8fafc;">
    <div class="container">
        <div class="row g-4 align-items-stretch">
            <div class="col-md-5">
                <div class="contact-info-card">
                    <h4><i class="fas fa-address-card me-2"></i>{{ __('Información de contacto') }}</h4>
                    <div class="contact-info-item">
                        <i class="fas fa-location-dot"></i>
                        <span>Madrid, España</span>
                    </div>
                    <div class="contact-info-item">
                        <i class="fas fa-envelope"></i>
                        <span>sergio@sergioplaza.dev</span>
                    </div>
                    <div class="contact-info-item">
                        <i class="fas fa-phone"></i>
                        <span>+34 600 000 000</span>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="contact-form-card">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-circle-check me-2"></i>{{ session('success') }}
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
                                      rows="5" placeholder="{{ __('Tu mensaje') }}" required>{{ old('message') }}</textarea>
                        </div>
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-paper-plane me-2"></i>{{ __('Enviar') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
```

- [ ] **Step 4: Ejecutar tests — todos deben pasar**

```bash
/opt/homebrew/bin/php artisan test tests/Feature/DesignTest.php
```
Esperado: 16 tests, todos pasan.

- [ ] **Step 5: Verificar suite completa (incluyendo ContactFormTest)**

```bash
/opt/homebrew/bin/php artisan test
```
Esperado: 40 tests, todos pasan.

- [ ] **Step 6: Commit**

```bash
git add resources/views/pages/contacts/index.blade.php tests/Feature/DesignTest.php
git commit -m "feat: contacto en 2 columnas — info card + formulario elevado"
```

---

## Task 7: Footer rediseño

**Files:**
- Modificar: `resources/views/layouts/footer.blade.php`
- Modificar: `tests/Feature/DesignTest.php`

- [ ] **Step 1: Añadir tests**

```php
    public function test_footer_has_social_icons(): void
    {
        $this->get('/')->assertSee('social-icon', false);
    }

    public function test_footer_has_brand_section(): void
    {
        $this->get('/')->assertSee('footer-brand', false);
    }

    public function test_footer_has_copyright(): void
    {
        $this->get('/')->assertSee('footer-copyright', false);
    }
```

- [ ] **Step 2: Ejecutar — deben fallar**

```bash
/opt/homebrew/bin/php artisan test tests/Feature/DesignTest.php --filter="footer"
```
Esperado: 3 tests FAIL.

- [ ] **Step 3: Reemplazar `resources/views/layouts/footer.blade.php`**

```blade
<footer>
    <div class="container">
        <div class="row g-4">
            <div class="col-md-6 mb-2">
                <div class="footer-brand">
                    <span class="brand-dot">·</span> {{ __('Mi Sitio Web') }}
                </div>
                <p class="footer-tagline">{{ __('Desarrollador web freelance. Soluciones digitales a medida.') }}</p>
                <div class="mt-2">
                    <a href="https://www.facebook.com" target="_blank" class="social-icon">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://www.instagram.com" target="_blank" class="social-icon">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://www.google.com" target="_blank" class="social-icon">
                        <i class="fab fa-google"></i>
                    </a>
                    <a href="https://www.linkedin.com" target="_blank" class="social-icon">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
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
                                  name="message" rows="3" placeholder="{{ __('Tu mensaje') }}" required></textarea>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">{{ __('Enviar Mensaje') }}</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="footer-copyright">
            © {{ date('Y') }} {{ __('Mi Sitio Web') }}. {{ __('Todos los derechos reservados.') }}
        </div>
    </div>
</footer>
```

- [ ] **Step 4: Añadir string footer-tagline a traducciones**

En `lang/en.json`, añadir antes del último `}`:
```json
,
    "Desarrollador web freelance. Soluciones digitales a medida.": "Freelance web developer. Custom digital solutions."
```

En `lang/fr.json`, añadir antes del último `}`:
```json
,
    "Desarrollador web freelance. Soluciones digitales a medida.": "Développeur web freelance. Solutions numériques sur mesure."
```

- [ ] **Step 5: Ejecutar tests — todos deben pasar**

```bash
/opt/homebrew/bin/php artisan test tests/Feature/DesignTest.php
```
Esperado: 19 tests, todos pasan.

- [ ] **Step 6: Verificar suite completa**

```bash
/opt/homebrew/bin/php artisan test
```
Esperado: 43 tests, todos pasan.

- [ ] **Step 7: Commit**

```bash
git add resources/views/layouts/footer.blade.php lang/en.json lang/fr.json tests/Feature/DesignTest.php
git commit -m "feat: footer con brand, iconos sociales coloridos y formulario integrado"
```

---

## Task 8: Traducciones nuevas — stats bar

**Files:**
- Modificar: `lang/en.json`
- Modificar: `lang/fr.json`
- Modificar: `tests/Feature/DesignTest.php`

- [ ] **Step 1: Añadir test**

```php
    public function test_stats_bar_translates_to_english(): void
    {
        $this->get('/lang/en');
        $this->get('/')->assertSee('Years of experience');
    }

    public function test_stats_bar_translates_to_french(): void
    {
        $this->get('/lang/fr');
        $this->get('/')->assertSee("Années d'expérience");
    }
```

- [ ] **Step 2: Ejecutar — deben fallar**

```bash
/opt/homebrew/bin/php artisan test tests/Feature/DesignTest.php --filter="stats_bar_translates"
```
Esperado: 2 tests FAIL — strings no existen en JSON todavía.

- [ ] **Step 3: Añadir strings en `lang/en.json`**

Añadir antes del último `}`:
```json
,
    "Años de experiencia": "Years of experience",
    "Proyectos completados": "Completed projects",
    "Dedicación": "Dedication",
    "Inicio de carrera": "Career start",
    "Proyectos destacados": "Notable projects",
    "Información de contacto": "Contact information"
```

- [ ] **Step 4: Añadir strings en `lang/fr.json`**

Añadir antes del último `}`:
```json
,
    "Años de experiencia": "Années d'expérience",
    "Proyectos completados": "Projets complétés",
    "Dedicación": "Dédication",
    "Inicio de carrera": "Début de carrière",
    "Proyectos destacados": "Projets notables",
    "Información de contacto": "Informations de contact"
```

- [ ] **Step 5: Ejecutar DesignTest — todos deben pasar**

```bash
/opt/homebrew/bin/php artisan test tests/Feature/DesignTest.php
```
Esperado: 21 tests, todos pasan.

- [ ] **Step 6: Ejecutar suite completa**

```bash
/opt/homebrew/bin/php artisan test
```
Esperado: 45 tests, todos pasan.

- [ ] **Step 7: Commit + push**

```bash
git add lang/en.json lang/fr.json tests/Feature/DesignTest.php
git commit -m "feat: traducciones stats bar y nuevas strings EN/FR"
git push origin main
```

---

## Verificación final

- [ ] Ejecutar suite completa:

```bash
/opt/homebrew/bin/php artisan test --verbose
```

- [ ] Verificar servidor en http://127.0.0.1:8080 (si no está corriendo: `/opt/homebrew/bin/php artisan serve --port=8080`)

Comprobar visualmente:
- Home: carousel con overlay + texto centrado + stats bar azul
- Servicios: cards con iconos Font Awesome y hover
- Nosotros: timeline vertical azul + iconos de sección
- Contacto: 2 columnas (info navy + formulario blanco)
- Footer: brand + iconos sociales + formulario
- Navbar: sticky + hover animado + dropdown estilado
- Cambio de idioma: textos cambian en todas las páginas
