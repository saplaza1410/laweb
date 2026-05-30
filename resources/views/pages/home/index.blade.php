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
