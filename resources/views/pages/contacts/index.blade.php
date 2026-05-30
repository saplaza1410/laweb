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
