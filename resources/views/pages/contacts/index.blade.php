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
