<footer>
    <div class="container">
        <div class="row g-4">
            <div class="col-md-6 mb-2">
                <div class="footer-brand">
                    <span class="brand-dot">·</span> {{ __('Mi Sitio Web') }}
                </div>
                <p class="footer-tagline">{{ __('Desarrollador web freelance. Soluciones digitales a medida.') }}</p>
                <div class="mt-2">
                    <a href="https://www.facebook.com" target="_blank" class="social-icon">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://www.instagram.com" target="_blank" class="social-icon">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://www.google.com" target="_blank" class="social-icon">
                        <i class="fab fa-google"></i>
                    </a>
                    <a href="https://www.linkedin.com" target="_blank" class="social-icon">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                <h4>{{ __('Envíanos un Mensaje') }}</h4>
                <form action="{{ route('contacts.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="footer_name" class="form-label">{{ __('Nombre') }}</label>
                        <input type="text" class="form-control custom-input" id="footer_name"
                               name="name" placeholder="{{ __('Tu nombre') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="footer_email" class="form-label">{{ __('Correo Electrónico') }}</label>
                        <input type="email" class="form-control custom-input" id="footer_email"
                               name="email" placeholder="{{ __('Tu correo electrónico') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="footer_message" class="form-label">{{ __('Mensaje') }}</label>
                        <textarea class="form-control custom-input" id="footer_message"
                                  name="message" rows="3" placeholder="{{ __('Tu mensaje') }}" required></textarea>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">{{ __('Enviar Mensaje') }}</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="footer-copyright">
            © {{ date('Y') }} {{ __('Mi Sitio Web') }}. {{ __('Todos los derechos reservados.') }}
        </div>
    </div>
</footer>