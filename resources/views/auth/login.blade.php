<!doctype html>
    <html lang="es">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

        <!-- Bootstrap CSS -->

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

        {{-- <title>Hello, world!</title> --}}
    </head>
    <body>
     <div class="ibox">
        <div class="ibox-content">
          <div class="row ">
              <div class="col-lg-8" style="background-image: url('{{ asset('/archivos/imagenes/leonosoft.jpg')}}');background-position: center center;background-size: cover;">
              </div>

              <div class="col-lg-4" align="center" >
                <div style="padding:25% 15% 35% 15%" >
                  <img src="{{asset('img/logos/'.$mi_empresa->foto)}}" style="width: 250px;"></center><br><br>
                  <h5 style="color: gray;">{{ $buenas}}, Bienvenido.</h5>
                  <p>Ingresa a tu cuenta</p>
                  <div class="input-group mb-3">
                      <span class="input-group-text" id="basic-addon1"><i class="fa fa-user"></i></span>
                      <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Usuario" name="email" value="{{ old('email') }}" required  id="email">
                      @error('email')<span class="invalid-feedback" role="alert">  <strong>{{ $message }}</strong></span> @enderror
                  </div>
                  <div class="input-group mb-3">
                      <span class="input-group-text" id="basic-addon1"><i class="fa fa-lock"></i></span>
                      <input type="text" class="form-control" placeholder="Contraseña" aria-label="Username" aria-describedby="basic-addon1">
                  </div>
                  <input type="submit" class="btn btn-primary form-control" value="Ingresar" style="color: #fff;background-color: #034fb1;border-color: #044aaa;">
              </div>
          </div>

      </div>
  </div>
</div>

{{-- <h1>Hello, world!<h1> --}}

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
-->
</body>
</html>