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
