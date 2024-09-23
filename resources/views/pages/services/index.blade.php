@extends('layouts.app')

@section('title')
Servicios
@endsection


@section('content')
<header class="py-5 text-center" style="background-color: #16171a; color: white;">
    <div class="container">
        <h1 class="display-4">Servicios Ofrecidos</h1>
        <p class="lead">Descubre cómo puedo ayudarte a crecer en el mundo digital.</p>
    </div>
</header>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Desarrollo de Sitios Web</h5>
                    </div>
                    <div class="card-body">
                        <p>Creo sitios web responsivos y atractivos que se adaptan a tus necesidades. Desde páginas informativas hasta tiendas en línea, garantizo una experiencia de usuario excepcional.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Aplicaciones Web Personalizadas</h5>
                    </div>
                    <div class="card-body">
                        <p>Desarrollo aplicaciones web a medida que optimizan procesos y mejoran la eficiencia de tu negocio, utilizando las últimas tecnologías del sector.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Consultoría y Estrategia Digital</h5>
                    </div>
                    <div class="card-body">
                        <p>Ofrezco consultoría para ayudarte a definir tu estrategia digital, asegurando que tus proyectos estén alineados con tus objetivos de negocio.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Optimización SEO</h5>
                    </div>
                    <div class="card-body">
                        <p>Implemento estrategias de SEO para aumentar la visibilidad de tu sitio web en los motores de búsqueda y atraer más tráfico orgánico.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Mantenimiento y Soporte</h5>
                    </div>
                    <div class="card-body">
                        <p>Proporciono servicios de mantenimiento y soporte continuo para asegurar que tu sitio web funcione sin problemas y esté siempre actualizado.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Formación y Talleres</h5>
                    </div>
                    <div class="card-body">
                        <p>Ofrezco formación y talleres para que tú y tu equipo puedan adquirir habilidades en desarrollo web y gestión de proyectos digitales.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
