    <html lang="es">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    </head>
    <body>
      <div class="row" style="height:100%;width: 100%;">
          <div class="col-sm-8" style="background-image: url('{{ asset('/archivos/imagenes/leonosoft.jpg')}}');background-position: center center;background-size: cover;"></div>
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
                      <input id="password" type="password" style="border-left: 1px solid #00000000; color: grey;" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"  placeholder="contraseña">
                      @error('password')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                  </div>
                  <input type="submit" class="btn btn-primary form-control" value="Ingresar" style="color: #fff;background-color: #034fb1;border-color: #044aaa;">
              </div>
          </form>
      </div>
<style>
    .form-control{height: 40px;}
</style>
  </div>
</body>
</html>