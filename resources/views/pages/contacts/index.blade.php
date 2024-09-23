@extends('layouts.app')

@section('title')
Contactenos
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
        <form>
            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="name" placeholder="Tu nombre" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="email" placeholder="Tu correo electrónico" required>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Mensaje</label>
                <textarea class="form-control" id="message" rows="4" placeholder="Tu mensaje" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-lg">Enviar</button>
        </form>
    </div>
</section>
@endsection
