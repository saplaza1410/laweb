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
