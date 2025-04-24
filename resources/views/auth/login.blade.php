    <html lang="es">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link href="{{ asset('css/bootstrap-v5.3.3.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/alerts.css') }}" rel="stylesheet">
        <link href="{{asset('css/index/loading-screen.css')}}" rel="stylesheet">
        <link href="{{ asset('css/index/style.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="container-fluid ">
            <div class="row h-100">
                <!-- Primera columana de la fila -->
                <div class="col-sm-12 col-md-12 col-lg-7  px-5 align-item bg-leono desaparece">
                    <!-- CARRUSEL -->
                    <div class="p-3 align-items-center">
                        <div id="carouselExampleDark" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item align-content-center active">
                                    <div class="row">
                                        <div class="col-sm-6  d-flex align-items-center">
                                            <img src="{{asset('img/login/logoazul.png')}}"
                                                class="rounded d-block w-100  imagenes " alt="...">
                                        </div>
                                        <div class="col-sm-6 d-flex align-items-center carousel-text">
                                            <p><b>Con LeonoSoft facturador electrónico</b> sdescubre una gestión de
                                                faturación <b>en menos de un minuto</b> y aumenta el flujo de tus ventas.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="carousel-item align-content-center">
                                    <div class="row">
                                        <div class="col-sm-6  d-flex align-items-center">
                                            <img src="{{asset('img/login/logoazul.png')}}"
                                                class="rounded d-block w-100  imagenes " alt="...">
                                        </div>
                                        <div class="col-sm-6 d-flex align-items-center carousel-text">
                                            <p><b>Con LeonoSoft facturador electrónico</b> sdescubre una gestión de
                                                faturación <b>en menos de un minuto</b> y aumenta el flujo de tus ventas.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="carousel-item align-content-center">
                                    <div class="row">
                                        <div class="col-sm-6 d-flex align-items-center">
                                            <img src="{{asset('img/login/logoazul.png')}}"
                                                class="rounded d-block w-100  imagenes " alt="...">
                                        </div>
                                        <div class="col-sm-6 d-flex align-items-center carousel-text">
                                            <p><b>Con LeonoSoft facturador electrónico</b> sdescubre una gestión de
                                                faturación <b>en menos de un minuto</b> y aumenta el flujo de tus ventas.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="carousel-item align-content-center">
                                    <div class="row">
                                        <div class="col-sm-6  d-flex align-items-center">
                                            <img src="{{asset('img/login/logoazul.png')}}"
                                                class="rounded d-block w-100  imagenes " alt="...">
                                        </div>
                                        <div class="col-sm-6 d-flex align-items-center carousel-text">
                                            <p><b>Con LeonoSoft facturador electrónico</b> sdescubre una gestión de
                                                faturación <b>en menos de un minuto</b> y aumenta el flujo de tus ventas.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- botones para la selección de ubicación de contenido del CARRUSEL - INDICADORES -->
                            <div class="carousel-indicators float-indicators">
                                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0"
                                    class="active px-4" aria-current="true" aria-label="Slide 1"></button>
                                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1"
                                    class="px-4" aria-label="Slide 2"></button>
                                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2"
                                    class="px-4" aria-label="Slide 3"></button>
                                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="3"
                                    class="px-4" aria-label="Slide 4"></button>
                            </div>

                        </div>
                        <div class="text-center mt-5">
                            <button type="button" class="btn btn-light text-primary mt-4"><b class="px-3">Conoce
                                    más</b></button>
                        </div>
                    </div>

                    <footer>
                        <p>&copy; 2024 - Codecta.pe</p>
                    </footer>

                </div>
                <!-- Segunda columna de la fila -->
            <div class="col-sm-12 col-md-12 col-lg-5 align-item right-side">
                <!-- FORMULARIO -->
                <div class="p-3 div-small">
                    <!-- LOGO -->
                    <img src="{{asset('img/login/leono soft.png')}}" alt="Leono Soft" class="mx-auto logo">
                    <!-- TÍTULO-->
                    <h5 class="text-center text-leono title-margin"><b>Facturador Electrónico</b></h5>
                    <!-- COMIENZO DEL FORM -->
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="input-box">
                                <label for="usuario"><i class="fa fa-user"></i> <strong>Usuario</strong></label>
                                <input type="email" id="email" type="email" placeholder="Ingresa tu usuario" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')<span class="invalid-feedback" role="alert">  <strong>{{ $message }}</strong></span>@enderror
                            </div>

                            <div class="input-box password-container">
                                <label><i class="fa fa-lock"></i> <strong>Contraseña</strong></label>
                                <input type="password" id="password" autocomplete="current-password" required name="password"
                                    placeholder="Ingresa tu contraseña" class="form-control @error('password') is-invalid @enderror">
                                <span class="toggle-password" onclick="togglePassword()">
                                    <i class="fa fa-eye-slash" id="eye-icon"></i> <!-- Cambiado a "fa-eye-slash" -->
                                </span>
                            </div>

                            <div class="form-check mb-3 text-center d-flex justify-content-center">
                                <a href="..." data-bs-toggle="modal" data-bs-target="#exampleModal"
                                    class="link-offset-2 link-underline link-underline-opacity-0 float-end">Recuperar
                                    contraseña</a>
                            </div>

                            <div class="d-grid gap-2 pb-2">
                                <input type="submit" class="btn btn-primary form-control" value="Ingresar" style="color: #fff;background-color: #034fb1;border-color: #044aaa;">
                            </div>

                            <p class="text-center pt-2">¿Quieres consultar un comprobante? <b><a href="#"
                                class="link-offset-2 link-underline link-underline-opacity-0" data-bs-toggle="modal"
                                data-bs-target="#exampleModalComprobante"> Consultar </a></b></p>
                    </form>
                </div>

                <!-- Botón select - CONTÁCTANOS -->
                <div class="btn-group dropup contact-container" role="group">
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
                <div id="alert-container">

                </div>
            </div>
        </div>
    </div>

    <!-- Modal - RECUPERAR CONTRASEÑA-->
    <div class="modal fade align-content-md-center" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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
                            <input type="email" class="correo" id="correo" required placeholder="Ingresa su correo">
                        </div>
                        <div class="alert alert-success py-2 mt-3" role="alert">
                            <p style="color: green;"><i class="bi bi-info-circle-fill text-success"
                                    style="color: green;"></i> Recuerda que, una vez enviado el correo, tu contraseña
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
                                style="color: green;"></i> Recuerda que, una vez enviado el correo, tu contraseña actual
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
                    <h1 class="modal-title fs-4 text-success-emphasis text-titulo fw-normal" id="exampleModalLabel"><i
                            class="bi bi-house-exclamation-fill text-leono"></i> Consulta de Comprobantes de Pago</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="m-2 p-2 bg-info-subtle text-center pt-4">
                        <p class="text-secondary">Una vez verificados los datos ingresados se procederá a mostrar el CDP
                            emitido en su nombre, del cual también podrá descargarse un PDF y un archivo XML con todos
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
    <div class="modal fade align-content-md-center" id="exampleModalComprobante" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content px-3">
                <div class="modal-header d-flex justify-content-center">
                    <h1 class="modal-title fs-5 text-primary text-sm-center text-titulo" id="exampleModalLabel"
                        style="color: blue;">Consultar comprobante</h1>
                    <button type="button" class="floating-close d-flex justify-content-center align-items-center"
                        data-bs-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x-circle-fill"></i>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form id="comprobanteForm2" class="" onsubmit="return validateCaptcha(event)">

                        <div class="mb-2 row">
                            <label for="inputRuc" class="col-sm-3 col-form-label">Ruc Emisor:</label>
                            <div class="col-sm-9">
                                <input type="number" value="2005468910"
                                    class="form-control bg-primary-subtle border border-secondary-subtle" id="inputRuc"
                                    disabled readonly>
                            </div>
                        </div>

                        <div class="my-2 row">
                            <div class="col-5">
                                <label for="" class="pe-2">Tipo: </label>
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

                            <div class="col d-flex justify-content-end">
                                <label for="" class="px-2">Fecha de emisión: </label>
                                <input type="text" class="form-control-sm border border-secondary-subtle">
                            </div>
                        </div>

                        <div class="row my-2">
                            <div class="col">
                                <label for="" class="pe-1">Serie: </label>
                                <input type="text" class="form-control-sm border border-secondary-subtle">
                            </div>
                            <div class="col d-flex justify-content-end">
                                <label for="" class="px-2">Correlativo: </label>
                                <input type="text" class="form-control-sm border border-secondary-subtle">
                            </div>
                        </div>

                        <div class=" mx-5 my-2 d-flex justify-content-center">
                            <div class="g-recaptcha" data-sitekey="YOUR_SITE_KEY_HERE"></div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary px-3 text-center">Consultar</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Codigo para la pantalla de carga -->
    <div id="loadingScreen">
        <div class="loading-content">
            <img id="loadingLogo" src="{{asset('img/login/logo.png')}}" alt="Logo de carga">
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
</html>
