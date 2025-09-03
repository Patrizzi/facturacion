    <html lang="es">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

        <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}"
            rel="stylesheet">
        <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
        <link href="{{ asset('css/plugins/steps/jquery.steps.css') }}" rel="stylesheet">
        <link href="{{ asset('css/plugins/footable/footable.core.css') }}" rel="stylesheet">
        <link href="{{ asset('css/plugins/blueimp/css/blueimp-gallery.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/plugins/switchery/switchery.css') }}" rel="stylesheet">
        <link href="{{ asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">
        <link href="{{ asset('css/plugins/slick/slick.css') }}" rel="stylesheet">
        <link href="{{ asset('css/plugins/slick/slick-theme.css') }}" rel="stylesheet">
        <link href="{{ asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
        {{-- <link href="{{ asset('css/plugins/c3/c3.min.css') }}" rel="stylesheet"> --}}
        <link href="{{ asset('main.css') }}" rel="stylesheet">
        <link rel="icon" type="image/svg+xml" href="{{ asset('img/icono.svg') }}" sizes="any">
        <link href="{{ asset('css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/plugins/morris/morris-0.4.3.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/plugins/morris/morris-0.4.3.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/side-bar/side-bar.css') }}">
        @yield('styles')
        <link href="{{ asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
    </head>

    <body style="background-color: #fff;margin: 0; padding: 0; height: 100vh; overflow: hidden;">
        <div class="animated fadeInRight">
            <div class="row align-center justify-content-center" style="height: 100vh;">
                <!-- Primera columana de la fila -->
                <div class="col-sm-12 col-md-12 col-lg-6 d-flex align-items-center" style="background-color: #002B94">
                    <!-- CARRUSEL -->
                    <div class="p-3 align-items-center align-items-center">
                        <div id="carouselExampleDark" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item align-content-center active">
                                    <div class="row">
                                        <div class="col-sm-6  d-flex align-items-center">
                                            <img src="{{ asset('img/login/logoazul.png') }}"
                                                class="rounded d-block w-100  imagenes " alt="...">
                                        </div>
                                        <div class="col-sm-6 d-flex align-items-center carousel-text">
                                            <p><b>Con LeonoSoft facturador electrónico</b> sdescubre una gestión de
                                                faturación <b>en menos de un minuto</b> y aumenta el flujo de tus
                                                ventas.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="carousel-item align-content-center">
                                    <div class="row">
                                        <div class="col-sm-6  d-flex align-items-center">
                                            <img src="{{ asset('img/login/logoazul.png') }}"
                                                class="rounded d-block w-100  imagenes " alt="...">
                                        </div>
                                        <div class="col-sm-6 d-flex align-items-center carousel-text">
                                            <p><b>Con LeonoSoft facturador electrónico</b> sdescubre una gestión de
                                                faturación <b>en menos de un minuto</b> y aumenta el flujo de tus
                                                ventas.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="carousel-item align-content-center">
                                    <div class="row">
                                        <div class="col-sm-6 d-flex align-items-center">
                                            <img src="{{ asset('img/login/logoazul.png') }}"
                                                class="rounded d-block w-100  imagenes " alt="...">
                                        </div>
                                        <div class="col-sm-6 d-flex align-items-center carousel-text text-white">
                                            <p><b>Con LeonoSoft facturador electrónico</b> sdescubre una gestión de
                                                faturación <b>en menos de un minuto</b> y aumenta el flujo de tus
                                                ventas.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="carousel-item align-content-center">
                                    <div class="row">
                                        <div class="col-sm-6  d-flex align-items-center">
                                            <img src="{{ asset('img/login/logoazul.png') }}"
                                                class="rounded d-block w-100  imagenes " alt="...">
                                        </div>
                                        <div class="col-sm-6 d-flex align-items-center carousel-text">
                                            <p><b>Con LeonoSoft facturador electrónico</b> sdescubre una gestión de
                                                faturación <b>en menos de un minuto</b> y aumenta el flujo de tus
                                                ventas.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- botones para la selección de ubicación de contenido del CARRUSEL - INDICADORES -->
                            <div class="carousel-indicators float-indicators">
                                <li>
                                    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0"
                                        class="active " aria-current="true" aria-label="Slide 1"></button>
                                </li>
                                <li>
                                    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1"
                                        class="" aria-label="Slide 2"></button>
                                </li>
                                <li>
                                    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2"
                                        class="" aria-label="Slide 3"></button>
                                </li>
                                <li>
                                    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="3"
                                        class="" aria-label="Slide 4"></button>
                                </li>
                            </div>

                        </div>
                        <div class="text-center mt-5">
                            <button type="button" class="btn btn-light text-primary mt-4"><b class="px-3">Conoce
                                    más</b></button>
                        </div>
                    </div>
                    {{-- 
                    <footer>
                        <p>&copy; 2024 - Codecta.pe</p>
                    </footer> --}}

                </div>
                <!-- Segunda columna de la fila -->
                <div class="col-sm-12 col-md-12 col-lg-6 d-flex align-items-center">
                    <!-- FORMULARIO -->
                    <div class="p-3 align-items-center align-items-center" style="width: 100%;margin: 10%;">
                        <!-- LOGO -->
                        <div class="d-flex justify-content-center">
                            <img src="{{ asset('img/login/leono soft.png') }}" alt="Leono Soft"
                                class="logo mb-4 text-center" style="width: 200px">
                        </div>
                        <!-- TÍTULO-->
                        <h2 class="text-center text-leono title-margin"><b>Facturador Electrónico</b></h2>
                        <!-- COMIENZO DEL FORM -->
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="input-box">
                                <label for="usuario"><i class="fa fa-user"></i> <strong>Usuario</strong></label>
                                <input type="email" id="email" type="email" placeholder="Ingresa tu usuario"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <br>
                            <div class="input-box password-container">
                                <label><i class="fa fa-lock"></i> <strong>Contraseña</strong></label>
                                <div class="input-group m-b">
                                    <input type="password" id="password" autocomplete="current-password" required
                                        name="password" placeholder="Ingresa tu contraseña"
                                        class="form-control @error('password') is-invalid @enderror">
                                    <div class="input-group-append">
                                        <span class="input-group-addon toggle-password" onclick="togglePassword()">
                                            <i class="fa fa-eye-slash" id="eye-icon"></i>
                                            <!-- Cambiado a "fa-eye-slash" -->
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <!--  <div class="form-check mb-3 text-center d-flex justify-content-center">
                                <a href="#" class="text-decoration-none fw-bold float-end"
                                data-bs-toggle="modal" data-bs-target="#exampleModal">Recuperar contraseña</a>
                            </div>-->

                            <div class="d-grid gap-2 pb-2">
                                <input type="submit" class="btn btn-primary form-control" value="Ingresar"
                                    style="color: #fff;background-color: #034fb1;border-color: #044aaa;">
                            </div>

                            <p class="text-center pt-2">¿Quieres consultar un comprobante? <b>
                                    <a href="#" class="text-decoration-none fw-bold me-3"
                                        data-bs-toggle="modal"
                                        data-bs-target="#exampleModalComprobante">Consultar</a></b></p>
                        </form>
                    </div>


                    <div id="alert-container">

                    </div>
                </div>
            </div>
            <!-- Botón select - CONTÁCTANOS -->
            <div class="btn-group dropup contact-container" role="group" style="position: absolute">
                <button class="contact-btn" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-phone"></i> Contáctanos <i class="fa fa-angle-up"></i>
                </button>
                <ul class="dropdown-menu contact-info px-2">
                    <li><a class="dropdown-item" href="tel:+51922546853">+51 922 546 853 <i
                                class="bi bi-telephone-inbound-fill text-leono"></i></a></li>
                    <li><a class="dropdown-item" href="mailto:info@codecta.pe">info@codecta.pe <i
                                class="bi bi-envelope-arrow-up-fill text-leono"></i></a></li>
                    <li><a class="dropdown-item" href="tel:+51922546863">+51 922 546 863 <i
                                class="bi bi-headset text-leono"></i></a></li>
                    <li><a class="dropdown-item" href="...">Nuestras oficinas <i
                                class="bi bi-geo-alt-fill text-leono"></i></a></li>
                </ul>
            </div>

            <div class="footer" style="background-color: transparent;border-color: transparent;">
                {{-- <div class="float-right">
                    Visitanos: &nbsp;&nbsp; <a href="https://www.facebook.com/JYPPERIFERICOSSAC" target="_blank"><i
                            class="fa fa-facebook-square" aria-hidden="true"></i></a>&nbsp;
                    <a href="https://api.whatsapp.com/send?phone=51946201443&text=Hola!%20Necesito%20Ayuda%20con%20el%20sistema%20de%20Facturación,%20Gracias!%20"
                        target="_blank"><i class="fa fa-whatsapp" aria-hidden="true"></i></a>
                </div> --}}
                <div style="color: white">
                    <strong>Copyright </strong> &nbsp;<a href="http://www.jypsac.com" target="_blank"> JyP
                        Periféricos</a>&nbsp; &copy; 2019-{{ date('Y') }}
                </div>

            </div>
        </div>

        <!-- Modal - RECUPERAR CONTRASEÑA-->
        <div class="modal fade align-content-md-center" id="exampleModal" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content px-3">
                    <div class="d-flex justify-content-end row p-2">
                        <button type="button"
                            class=" floating-close d-flex justify-content-center align-items-center col-sm-12"
                            data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-circle-fill"></i>
                        </button>
                        <h5 class="modal-title text-primary text-sm-center text-titulo" id="exampleModalLabel"
                            style="color: blue;">Recuperar Contraseña</h5>
                    </div>

                    <div class="modal-body text-sm-center">
                        <p class="mx-5">Ingresa tu Correo Electrónico para identificar tu cuenta. Te enviaremos una
                            contraseña al correo registrado para proceder al cambio de contraseña.</p>
                        <!-- FORMULARIO -->
                        <form action="">
                            <div class="mx-5 d-flex justify-content-center align-items-center">
                                <input type="email" class="correo" id="correo" required
                                    placeholder="Ingresa su correo">
                            </div>
                            <div class="alert alert-success py-2 mt-3" role="alert">
                                <p style="color: green;"><i class="bi bi-info-circle-fill text-success"
                                        style="color: green;"></i> Recuerda que, una vez enviado el correo, tu
                                    contraseña
                                    actual será inválida para iniciar sesión.</p>
                            </div>
                            <button type="button" class="btn btn-primary px-5" data-bs-toggle="modal"
                                data-bs-target="#exampleModalEnviado">Enviar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal - RECUPERAR CONTRASEÑA - CORREO ENVIADO -->
        <div class="modal fade align-content-md-center" id="exampleModalEnviado" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content px-3">
                    <div class="p-2 d-flex justify-content-center">
                        <h1 class="modal-title fs-5 text-primary text-sm-center text-titulo" id="exampleModalLabel"
                            style="color: blue;">Recuperar Contraseña</h1>
                        <button type="button" class="floating-close d-flex justify-content-center align-items-center"
                            data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-circle-fill"></i>
                        </button>
                    </div>
                    <div class="modal-body text-sm-center">
                        <!-- ícono de check -->
                        <i class="bi bi-check-circle-fill text-success"></i>

                        <p class="mx-5">Enviamos un correo a "example@gmail.com"<br>Ingrese a su cuenta y siga las
                            instrucciones para la recuperación de la contraseña.</p>

                        <div class="alert alert-success py-2 mt-3" role="alert">
                            <p style="color: green;"><i class="bi bi-info-circle-fill text-success"
                                    style="color: green;"></i> Recuerda que, una vez enviado el correo, tu contraseña
                                actual
                                será inválida para iniciar sesión.</p>
                        </div>

                        <button type="button" class="btn btn-primary px-5" data-bs-dismiss="modal"
                            aria-label="Close">Ok</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal - CONSULTAR COMPROBANTE -->
        <div class="modal fade align-content-md-center" id="exampleModalComprobant" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content p-2">
                    <div class="modal-header">
                        <h1 class="modal-title fs-4 text-success-emphasis text-titulo fw-normal"
                            id="exampleModalLabel"><i class="bi bi-house-exclamation-fill text-leono"></i> Consulta de
                            Comprobantes de Pago</h1>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"><i
                                class="fa fa-time"></i></button>
                    </div>
                    <div class="modal-body">
                        <div class="m-2 p-2 bg-info-subtle text-center pt-4">
                            <p class="text-secondary">Una vez verificados los datos ingresados se procederá a mostrar
                                el CDP
                                emitido en su nombre, del cual también podrá descargarse un PDF y un archivo XML con
                                todos
                                sus datos.</p>
                        </div>

                        <!-- FORMULARIO DE CONSULTAR COMPROBANTE -->
                        <p class="text-center">Por favor ingrese todos los datos que se solicitan a continuación:</p>
                        <form id="comprobanteForm1" class="text-center" onsubmit="return validateCaptcha(event)">
                            <div class="py-2">
                                <label for="">Tipo de Comprobante: </label>
                                <select name="" class="form-select-sm border border-secondary-subtle">
                                    <option value="boleta">Boleta</option>
                                    <option value="factura" selected>Factura</option>
                                    <option value="nota_debito">Nota Débito</option>
                                    <option value="nota_credito">Nota Crédito</option>
                                    <option value="comprobante_retenicion">Comprobante Retención</option>
                                    <option value="comprobante_percepcion">Comprobante Percepción</option>
                                    <option value="guia_remision">Guía de Remisión Remitente</option>
                                </select>
                            </div>
                            <div class="py-2 ">
                                <label for="" class="">Ruc Emisor: </label>
                                <input type="text" value="2005468910"
                                    class="form-control-sm bg-primary-subtle border border-secondary-subtle" disabled
                                    readonly>
                                <!-- FORMULARIO DE CONSULTAR COMPROBANTE

                                <input type="text" class="form-control-sm border border-secondary-subtle" style="color: rgb(88, 155, 255);">
                                -->
                            </div>
                            <div class="py-2">
                                <label for="">N° Serie: </label>
                                <input type="text" class="form-control-sm border border-secondary-subtle">
                            </div>
                            <div class="py-2">
                                <label for="">N° Correlativo: </label>
                                <input type="text" class="form-control-sm border border-secondary-subtle">
                            </div>
                            <div class="py-2">
                                <label for="">Monto Total: </label>
                                <input type="text" class="form-control-sm border border-secondary-subtle">
                            </div>
                            <div class="py-4 mx-5 my-3">
                                <div class="g-recaptcha" data-sitekey="YOUR_SITE_KEY_HERE"></div>
                            </div>
                            <button type="submit" class="btn btn-primary px-3">Consultar</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>


        <!-- Modal - CONSULTAR COMPROBANTE- NUEVO -->
        <div class="modal fade" id="exampleModalComprobante" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content px-3">
                    <div class="modal-header d-flex justify-content-center">
                        <h1 class="modal-title fs-5 text-primary text-sm-center text-titulo" id="exampleModalLabel"
                            style="color: blue;">Consultar comprobante</h1>
                        <button type="button" class="floating-close d-flex justify-content-center align-items-center"
                            data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <form id="comprobanteForm2" class="" onsubmit="return validateCaptcha(event)">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="inputDni"><strong>DNI-RUC Receptor:</strong></label>
                                        <input type="text" class="form-control" id="inputRuc" name="cliente"
                                            placeholder="Ingrese DNI o RUC del receptor" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="inputDni"><strong>Monto total:</strong></label>
                                        <input type="text" class="form-control" id="inputRuc" name="monto_total"
                                            placeholder="Monto Total solo numerico" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="inputDni"><strong>Comprobante:</strong></label>
                                        <select name="tipo" class="form-control">
                                            <option value="">Selecciona un comprobante</option>
                                            <option value="boleta">Boleta</option>
                                            <option value="factura">Factura</option>
                                            <option value="nota_debito">Nota Débito</option>
                                            <option value="nota_credito">Nota Crédito</option>
                                            {{-- <option value="comprobante_retenicion">Comprobante Retención</option>
                                                <option value="comprobante_percepcion">Comprobante Percepción</option> --}}
                                            <option value="guia_remision">Guía de Remisión Remitente</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for=""><strong>Emisión:</strong></label>
                                        <input type="date" class="form-control" name="fecha_emision"
                                            id="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="inputSerie"><strong>Serie:</strong></label>
                                        <input type="text" class="form-control" id="inputSerie"
                                            placeholder="Ingrese Serie" name="serie" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="inputSerie"><strong>Correlativo:</strong></label>
                                        <input type="text" class="form-control" id="inputSerie"
                                            placeholder="Ingrese Correlativo" name="correlativo" required>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary px-3 text-center">Consultar</button>
                            </div>

                        </form>
                        <div class="mt-3" id="resultContainer">
                            <!-- Aquí se mostrarán los resultados de la consulta -->
                            <div class="row">
                                <div class="col-sm-4">
                                    <strong>Emisor:</strong><br>
                                    <span id="emisor"></span>
                                </div>
                                <div class="col-sm-4">
                                    <strong>Fecha</strong><br>
                                    <span id="fecha"></span>
                                </div>
                                <div class="col-sm-4">
                                    <strong>Total:</strong><br>
                                    <span id="total"></span>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Cantidad</th>
                                                <th>Precio Unitario</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody id="itemsTableBody">
                                            <!-- Aquí se agregarán las filas de los ítems -->
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <button class="btn btn-primary">PDF</button>
                                    <button class="btn btn-secondary">Imprimir</button>
                                    <button class="btn btn-success">XML</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Codigo para la pantalla de carga -->
        <div id="loadingScreen">
            <div class="loading-content">
                <img id="loadingLogo" src="{{ asset('img/login/logo.png') }}" alt="Logo de carga">
                <div class="spinner"></div>
            </div>
        </div>

        <script>
            function validateCaptcha(event) {
                event.preventDefault(); // Prevent form submission
                const response = grecaptcha.getResponse();
                if (response.length === 0) {
                    alert("Por favor, confirme que no es un robot.");
                    return false; // Prevent form submission
                } else {
                    alert("Formulario enviado correctamente.");
                    // Here you can add the logic to submit the form or display the results
                    // e.g., document.getElementById('comprobanteForm').submit();
                    return true; // Allow form submission
                }
            }

            function togglePassword() {
                const passwordInput = document.getElementById("password");
                const eyeIcon = document.getElementById("eye-icon");

                if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                    eyeIcon.classList.remove("fa-eye-slash");
                    eyeIcon.classList.add("fa-eye");
                } else {
                    passwordInput.type = "password";
                    eyeIcon.classList.remove("fa-eye");
                    eyeIcon.classList.add("fa-eye-slash");
                }
            }
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>

        {{-- <div class="row" style="height:100%;width: 100%;">
          <div class="col-sm-8" style="background-image: url('{{ asset('/archivos/imagenes/leonosofts.jpg')}}');background-position: center center;background-size: cover;"></div>
          <div class="col-sm-4" align="center" >
              <form method="POST" action="{{ route('login') }}">
                @csrf
                <div style="padding:28% 12% 0% 12%;" >
                  <img src="{{asset('img/logos/'.$mi_empresa->foto)}}" style="width: 250px;"></center><br><br><br>
                  <h5 style="color: gray;">{{ $buenas}}, Bienvenido.</h5><br>
                  <b>Ingresa a tu cuenta</b><br><br>
                  <div class="input-group mb-4">
                      <span class="input-group-text" id="basic-addon1" style="background:white; border-right:1px solid #00000000;"><i class="fa fa-user" style="color:grey;"></i></span>
                      <input id="email" type="email" style="border-left: 1px solid #00000000; color: grey;" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Nombre Usuario">
                      @error('email')<span class="invalid-feedback" role="alert">  <strong>{{ $message }}</strong></span>@enderror
                  </div>
                  <div class="input-group mb-3">
                      <span class="input-group-text" id="basic-addon1" style="background:white; border-right:1px solid #00000000;"><i class="fa fa-lock" style="color:grey;"></i></span>
                      <input id="password" type="password" style="border-left: 1px solid #00000000; color: grey;" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"  placeholder="Contraseña">
                      @error('password')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                  </div>
                  <input type="submit" class="btn btn-primary form-control" value="Ingresar" style="color: #fff;background-color: #034fb1;border-color: #044aaa;">
              </div>
          </form>
      </div> --}}

        </div>
    </body>
    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
    <!-- Toastr script -->
    <script src="{{ asset('js/plugins/toastr/toastr.min.js') }}"></script>

    <script>
        $('#comprobanteForm2').on('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission
            $.ajax({
                url: "{{ route('pa.consulta_comprobante') }}", // Your route to handle the request
                method: "POST",
                data: $(this).serialize(), // Serialize form data
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log(response.data['cliente']);
                    // Mostrar datos principales
                    $('#emisor').text(response.data['cliente']);
                    $('#fecha').text(response.data['fecha']);
                    $('#total').text(response.data['total']);

                    // Limpiar tabla antes de agregar
                    $('#itemsTableBody').empty();

                    // Agregar filas a la tabla
                    response.data['registros'].forEach(function(item) {
                        $('#itemsTableBody').append(`
                            <tr>
                                <td>${item.item}</td>
                                <td>${item.cantidad}</td>
                                <td>${item.precio_unitario}</td>
                                <td>${item.precio_total}</td>
                            </tr>
                        `);
                    });

                    // Mostrar contenedor si estaba oculto
                    $('#resultContainer').removeClass('d-none').show();

                    toastr.success('Comprobante consultado exitosamente');
                    console.log(response);
                },
                error: function(xhr) {
                    toastr.error('Error al consultar el comprobante');
                }
            });
        });
    </script>

    </html>
