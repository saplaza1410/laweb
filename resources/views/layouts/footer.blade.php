<footer class="bg-light text-center text-lg-start mt-auto py-3" style="background-color: #16171a !important;">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-4">
                <h4>{{ __('Contáctanos') }}</h4>
                <p>{{ __('Si tienes alguna duda o pregunta, no dudes en ponerte en contacto con nosotros. Estamos aquí para ayudarte en todo lo que necesites.') }}</p>
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
                                  name="message" rows="4" placeholder="{{ __('Tu mensaje') }}" required></textarea>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">{{ __('Enviar Mensaje') }}</button>
                    </div>
                </form>
            </div>
        </div>
        <p class="text-center mb-0">© {{ date('Y') }} {{ __('Mi Sitio Web') }}. {{ __('Todos los derechos reservados.') }}</p>
    </div>
</footer>
