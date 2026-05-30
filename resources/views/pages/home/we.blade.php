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
