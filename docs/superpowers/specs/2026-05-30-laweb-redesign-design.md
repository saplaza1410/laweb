# Diseño: Rediseño Visual laweb

**Fecha:** 2026-05-30
**Proyecto:** Portfolio de Sergio Plaza — Laravel 11 + Bootstrap 5
**Objetivo:** Rediseño visual completo hacia estética profesional/corporativa azul marino + blanco, sin cambiar la arquitectura Laravel ni las funcionalidades existentes.
**Enfoque elegido:** Bootstrap 5 + CSS custom completo + Google Fonts (Inter) + Font Awesome (ya cargado)

---

## 1. Base visual

### Paleta de colores (variables CSS en `:root`)

```css
:root {
    --navy-dark:   #0f172a;
    --navy-mid:    #1e3a5f;
    --blue-accent: #2563eb;
    --blue-light:  #eff6ff;
    --white:       #ffffff;
    --text-muted:  #64748b;
    --border:      #e2e8f0;
}
```

### Tipografía

- **Fuente:** Inter (Google Fonts) — pesos 400, 600, 700
- Añadir en `app.blade.php` antes del CSS propio:
  ```html
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  ```
- `body { font-family: 'Inter', sans-serif; }`
- Headings en `font-weight: 700`, párrafos en `font-weight: 400`, `line-height: 1.75`

### Archivo CSS

Todo el CSS vive en `public/css/style.css` — reescribir completamente manteniendo el mismo nombre de archivo.

---

## 2. Navbar (`layouts/nav.blade.php`)

- **Fondo:** `--navy-dark`
- **Sticky:** `position: sticky; top: 0; z-index: 1000` con `box-shadow: 0 2px 12px rgba(0,0,0,0.3)` al hacer scroll (clase `.scrolled` añadida via JS inline en el propio nav)
- **Logo:** texto con punto decorativo azul antes: `<span class="text-accent">·</span> Mi Sitio Web`
- **Links:**
  - Color base: `rgba(255,255,255,0.85)`
  - Hover: `::after` pseudo-elemento — línea inferior `--blue-accent` con `transform: scaleX(0→1)` en 0.3s
  - Link activo: `background: --blue-accent; border-radius: 6px; padding: 4px 12px; color: white`
- **Dropdown Idiomas:**
  - `.dropdown-menu`: fondo `--navy-mid`, texto blanco, borde `1px solid rgba(255,255,255,0.1)`
  - Hover items: `background: --blue-accent`
  - Idioma activo (`fw-bold`): color `--blue-accent` con check `✓`
- **Social icons bar** (franja superior): mantener, cambiar hover de iconos a color de red (`#1877f2` Facebook, `#e4405f` Instagram, etc.)

---

## 3. Hero + Stats bar (`pages/home/index.blade.php`)

### Carousel hero
- **Altura:** `height: 75vh; min-height: 480px`
- **Overlay:** `::after` sobre `.carousel-item` con `background: linear-gradient(135deg, rgba(15,23,42,0.85) 0%, rgba(37,99,235,0.35) 100%)`
- **Texto centrado** sobre el overlay (nuevo bloque `.hero-caption` absoluto):
  ```html
  <div class="hero-caption">
      <h1>{{ __('Bienvenido a Mi Sitio Web') }}</h1>
      <p>{{ __('Ofrecemos soluciones a medida para tu negocio') }}</p>
      <a href="/contacts" class="btn btn-hero">{{ __('Contáctanos') }}</a>
  </div>
  ```
- `.hero-caption`: `position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%); text-align: center; color: white; z-index: 10; width: 80%`
- `h1`: `font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 700`
- `.btn-hero`: fondo `--blue-accent`, blanco, `border-radius: 50px`, `padding: 12px 36px`, hover `--navy-mid`
- Indicadores: círculos 10px blancos/semitransparentes
- Controles prev/next: circular con fondo `rgba(255,255,255,0.15)`, hover sólido

### Stats bar (nueva sección debajo del carousel)
```html
<div class="stats-bar">
    <div class="stat-item"><span class="stat-number">5+</span><span class="stat-label">{{ __('Años de experiencia') }}</span></div>
    <div class="stat-item"><span class="stat-number">50+</span><span class="stat-label">{{ __('Proyectos completados') }}</span></div>
    <div class="stat-item"><span class="stat-number">3</span><span class="stat-label">{{ __('Idiomas') }}</span></div>
    <div class="stat-item"><span class="stat-number">100%</span><span class="stat-label">{{ __('Dedicación') }}</span></div>
</div>
```
- `.stats-bar`: `background: --blue-accent; display: flex; justify-content: center; gap: 3rem; padding: 1.5rem`
- `.stat-number`: `font-size: 2rem; font-weight: 700; color: white`
- `.stat-label`: `font-size: 0.85rem; color: rgba(255,255,255,0.8); display: block`
- Separadores verticales entre items: `border-right: 1px solid rgba(255,255,255,0.3)`

### Sección "Sobre Nosotros + Nuestros Servicios"
- Título con acento: `border-left: 4px solid --blue-accent; padding-left: 1rem`
- Lista servicios: `<i class="fas fa-check text-accent me-2"></i>` en lugar de `<li>` sin icono

### Sección CTA "¿Listo para empezar?"
- Fondo: `linear-gradient(135deg, --navy-dark, --navy-mid)` en lugar del gris `#f8f9fa`
- Texto: blanco
- Botón: fondo blanco, texto `--blue-accent`, hover invertido

---

## 4. Página Servicios (`pages/services/index.blade.php`)

### Cards rediseñadas
- Fondo: blanco
- `border-top: 4px solid --blue-accent`
- `border-radius: 12px`
- `box-shadow: 0 2px 16px rgba(0,0,0,0.07)`
- Hover: `transform: translateY(-6px); box-shadow: 0 8px 32px rgba(37,99,235,0.15); border-top-color: --navy-mid`
- Transición: `0.3s ease`

### Icono por servicio (añadir en card-header)
| Servicio | Icono FA |
|---|---|
| Desarrollo de Sitios Web | `fa-code` |
| Aplicaciones Web Personalizadas | `fa-laptop-code` |
| Consultoría y Estrategia Digital | `fa-chart-line` |
| Optimización SEO | `fa-magnifying-glass` |
| Mantenimiento y Soporte | `fa-screwdriver-wrench` |
| Formación y Talleres | `fa-graduation-cap` |

Estructura de cada card-header:
```html
<div class="card-header service-header">
    <i class="fas fa-code service-icon"></i>
    <h5>{{ __('Desarrollo de Sitios Web') }}</h5>
</div>
```
- `.service-icon`: `font-size: 2rem; color: --blue-accent; display: block; margin-bottom: 0.5rem`
- `.service-header`: `background: white; border-bottom: 1px solid --border; text-align: center; padding: 1.5rem`
- Card header text (h5): `color: --navy-dark; font-weight: 700`

---

## 5. Página Nosotros (`pages/home/we.blade.php`)

### Timeline "Mi Trayectoria"
Reemplazar el `<p>` de trayectoria por un timeline vertical:
```html
<div class="timeline">
    <div class="timeline-item">
        <div class="timeline-dot"></div>
        <div class="timeline-content">
            <h5>Inicio de carrera</h5>
            <p>{{ __('Desde que comencé mi carrera...') }}</p>
        </div>
    </div>
    <div class="timeline-item">
        <div class="timeline-dot"></div>
        <div class="timeline-content">
            <h5>Proyectos destacados</h5>
            <p>{{ __('He colaborado con startups...') }}</p>
        </div>
    </div>
</div>
```
- `.timeline`: `border-left: 3px solid --blue-accent; margin-left: 1rem; padding-left: 2rem`
- `.timeline-dot`: `width: 14px; height: 14px; background: --blue-accent; border-radius: 50%; margin-left: -2.8rem; float: left; margin-top: 0.4rem`
- `.timeline-content`: `margin-bottom: 2rem`

### Secciones "Lo Que Hago" y "Mi Filosofía"
- Añadir icono decorativo a la izquierda del título:
  - Lo Que Hago: `<i class="fas fa-laptop fa-2x text-accent me-3"></i>`
  - Mi Filosofía: `<i class="fas fa-handshake fa-2x text-accent me-3"></i>`
- Sección CTA final: fondo `--blue-light`, botón `--blue-accent`

---

## 6. Página Contacto (`pages/contacts/index.blade.php`)

### Layout de dos columnas (desktop)
```
| Col izquierda (info)  | Col derecha (formulario) |
```
- Columna info (`col-md-5`): tarjeta con tres filas icono + texto: `fa-location-dot` + "Madrid, España", `fa-envelope` + "sergio@sergioplaza.dev", `fa-phone` + "+34 600 000 000". Fondo `--navy-dark`, texto blanco.
- Columna formulario (`col-md-7`): card blanca con sombra

### Formulario rediseñado
- `.form-control`: `border: 2px solid --border; border-radius: 8px; padding: 12px 16px; font-family: Inter`
- Focus: `border-color: --blue-accent; box-shadow: 0 0 0 3px rgba(37,99,235,0.15)`
- Botón enviar: `--blue-accent`, icono `<i class="fas fa-paper-plane me-2"></i>`, full-width, `border-radius: 8px`
- Alert de éxito: mantener Bootstrap alert-success pero con icono `fa-circle-check`

---

## 7. Footer (`layouts/footer.blade.php`)

- Fondo `--navy-dark`, separador superior `border-top: 1px solid rgba(255,255,255,0.1)`
- **Columna izquierda:** Logo + descripción (1 línea) + iconos sociales con hover en colores reales:
  - Facebook `#1877f2`, Instagram `#e4405f`, Google `#ea4335`, LinkedIn `#0a66c2`
- **Columna derecha:** formulario de contacto con inputs `.custom-input` ya estilados (oscuros), botón `--blue-accent`
- Copyright: `rgba(255,255,255,0.5)`

---

## 8. Traducciones nuevas

Añadir a `lang/en.json` y `lang/fr.json`:
- `"Años de experiencia"` → EN: "Years of experience" / FR: "Années d'expérience"
- `"Proyectos completados"` → EN: "Completed projects" / FR: "Projets complétés"
- `"Dedicación"` → EN: "Dedication" / FR: "Dédication"
- `"Idiomas"` ya existe ✓

---

## 9. Archivos modificados

| Archivo | Tipo de cambio |
|---|---|
| `public/css/style.css` | Reescritura completa |
| `resources/views/layouts/app.blade.php` | Añadir Google Fonts link |
| `resources/views/layouts/nav.blade.php` | Nuevo markup + JS scroll class |
| `resources/views/layouts/footer.blade.php` | Añadir logo/descripción columna izq |
| `resources/views/pages/home/index.blade.php` | Hero caption + stats bar + CTA rediseñado |
| `resources/views/pages/services/index.blade.php` | Iconos en card-headers |
| `resources/views/pages/home/we.blade.php` | Timeline + iconos sección |
| `resources/views/pages/contacts/index.blade.php` | Layout 2 columnas + info card |
| `lang/en.json` | 3 strings nuevas |
| `lang/fr.json` | 3 strings nuevas |

---

## 10. Restricciones

- No romper los 24 tests existentes
- No cambiar rutas, controladores, modelos ni lógica de backend
- Mantener soporte i18n en todos los textos nuevos con `__()` 
- Mantener Bootstrap 5 como grid/componentes base
- No añadir dependencias JavaScript externas
