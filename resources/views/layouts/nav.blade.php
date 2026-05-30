<div class="py-2" style="background-color: rgb(84 152 209);"></div>

<div class="py-2 social-bar" style="background-color: #0f172a; color: white;">
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
