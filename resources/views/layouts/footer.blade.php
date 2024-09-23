<footer class="bg-light text-center text-lg-start mt-auto py-3" style="background-color: #16171a !important;">

    <div class="container">
        <div class="row">
            <!-- Sección de Título y Texto -->
            <div class="col-md-6 mb-4">
                <h4>Contáctanos</h4>
                <p>
                    Si tienes alguna duda o pregunta, no dudes en ponerte en contacto con nosotros. Estamos aquí para ayudarte en todo lo que necesites.
                </p>
            </div>

            <!-- Sección del Formulario -->
            <div class="col-md-6">
                <h4>Envíanos un Mensaje</h4>
                <form>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control custom-input" id="name" placeholder="Tu nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control custom-input" id="email" placeholder="Tu correo electrónico" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Mensaje</label>
                        <textarea class="form-control custom-input" id="message" rows="4" placeholder="Tu mensaje" required></textarea>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Enviar Mensaje</button>
                    </div>
                </form>
            </div>
        </div>

        <p class="text-center mb-0">© {{ date('Y') }} Mi Sitio Web. Todos los derechos reservados.</p>
    </div>
</footer>
