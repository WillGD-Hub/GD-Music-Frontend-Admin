<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{asset('images/logo.png')}}">
    <title>GD Music - Login</title>

    {{-- CSS --}}
    <!-- Simple bar CSS -->
    <link rel="stylesheet" href="{{asset('/tinydash/css/simplebar.css')}}">
    <!-- Fonts CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Icons CSS -->
    <link rel="stylesheet" href="{{asset('/tinydash/css/feather.css')}}">
    <link rel="stylesheet" href="{{asset('/tinydash/css/select2.css')}}">
    <link rel="stylesheet" href="{{asset('/tinydash/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('/tinydash/css/uppy.min.css')}}">
    <link rel="stylesheet" href="{{asset('/tinydash/css/jquery.steps.css')}}">
    <link rel="stylesheet" href="{{asset('/tinydash/css/jquery.timepicker.css')}}">
    <link rel="stylesheet" href="{{asset('/tinydash/css/quill.snow.css')}}">
    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="{{asset('/tinydash/css/daterangepicker.css')}}">
    <!-- App CSS -->
    <link rel="stylesheet" href="{{asset('/tinydash/css/app-light.css')}}" id="lightTheme" disabled>
    <link rel="stylesheet" href="{{asset('/tinydash/css/app-dark.css')}}" id="darkTheme">
    {{-- DATATABLE --}}
    <link rel="stylesheet" href="{{asset('/tinydash/css/dataTables.bootstrap4.css')}}">
    {{-- END OF CSS --}}
  </head>
  <body class="dark ">
    <div class="wrapper vh-100">
        <div class="d-flex align-items-center h-100">
            <form class="col-lg-3 col-md-4 col-10 mx-auto text-center" action="{{url('/login')}}" method="post">
                @csrf
                <h1 class="mb-2">LOGIN</h1>
                <div class="mb-2" style="margin-top: 0.25em; font-size: 80%; color: #dc3545;">{{session('login_error')}}</div>
                <div class="form-group">
                    <label for="inputUsername" class="sr-only">Username</label>
                    <input type="text" id="inputUsername" class="form-control form-control-lg @if (count($errors)) @error('username') is-invalid @else is-valid @enderror @elseif(session('login_error')) is-invalid @endif""
                    placeholder="Username" name="username" value="{{old('username')}}" required>
                    <div class="invalid-feedback">@error('username') {{$message}} @enderror</div>
                </div>
                <div class="form-group">
                    <label for="inputPassword" class="sr-only">Password</label>
                    <input type="password" id="inputPassword" class="form-control form-control-lg @if (count($errors)) @error('password') is-invalid @else is-valid @enderror @elseif(session('login_error')) is-invalid @endif"
                    placeholder="Password" name="password" >
                    <div class="invalid-feedback">@error('password') {{$message}} @enderror</div>
                </div>
                <button class="btn btn-lg btn-primary btn-block" type="submit">LOGIN</button>
            </form>
        </div>
    </div>
    <script src="{{asset('/tinydash/js/jquery.min.js')}}"></script>
    <script src="{{asset('/tinydash/js/popper.min.js')}}"></script>
    <script src="{{asset('/tinydash/js/moment.min.js')}}"></script>
    <script src="{{asset('/tinydash/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('/tinydash/js/simplebar.min.js')}}"></script>
    <script src="{{asset('/tinydash/js/daterangepicker.js')}}"></script>
    <script src="{{asset('/tinydash/js/jquery.stickOnScroll.js')}}"></script>
    <script src="{{asset('/tinydash/js/tinycolor-min.js')}}"></script>
    {{-- <script src="{{asset('/tinydash/js/config.js')}}"></script> --}}
    {{-- <script src="{{asset('/tinydash/js/apps.js')}}"></script> --}}
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-56159088-1"></script>
  </body>
</html>
</body>
</html>
