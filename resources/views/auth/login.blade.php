<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Login &mdash; Stisla</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css')}}">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-social/bootstrap-social.css')}}">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/css/components.css')}}">
<!-- Start GA -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-94034622-3');
</script>
<!-- /END GA --></head>

<body>
  <div id="app">
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">

                    <div class="login-brand">
                        <img src="{{ asset('assets/img/stisla-fill.svg') }}" alt="logo" width="100"
                            class="shadow-light rounded-circle">
                    </div>

                    <div class="text-center mb-3">
                        <div class="dropdown d-inline-block">

                            <button class="btn btn-outline-primary btn-sm dropdown-toggle text-uppercase" type="button"
                                data-toggle="dropdown" aria-expanded="false">

                                <i class="fas fa-globe"></i>
                                {{ app()->getLocale() }}
                            </button>

                            <div class="dropdown-menu">

                                <a href="{{ route('lang.switch', 'en') }}"
                                    class="dropdown-item {{ app()->getLocale() == 'en' ? 'active' : '' }}">

                                    {{ __('English') }}
                                </a>

                                <a href="{{ route('lang.switch', 'id') }}"
                                    class="dropdown-item {{ app()->getLocale() == 'id' ? 'active' : '' }}">

                                    {{ __('Bahasa Indonesia') }}
                                </a>

                            </div>
                        </div>
                    </div>

                    <div class="card card-primary">

                        <div class="card-header">
                            <h4>{{ __('Login') }}</h4>
                        </div>

                        <div class="card-body">

                            <form method="POST" action="{{ route('signin') }}">
                                @csrf
                                @method('POST')

                                <div class="form-group">
                                    <label for="email">
                                        {{ __('Email') }}
                                    </label>

                                    <input id="email" type="email" class="form-control" name="email" tabindex="1"
                                        autofocus>

                                    @error('email')
                                        <span class="text-danger text-sm">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">

                                    <div class="d-block">
                                        <label for="password" class="control-label">
                                            {{ __('Password') }}
                                        </label>
                                    </div>

                                    <input id="password" type="password" class="form-control" name="password"
                                        tabindex="2">

                                    @error('password')
                                        <span class="text-danger text-sm">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">

                                        {{ __('Login') }}
                                    </button>
                                </div>

                            </form>

                        </div>
                    </div>

                    <div class="mt-5 text-muted text-center">
                        {{ __("Don't have an account?") }}

                        <a href="{{ route('register') }}">
                            {{ __('Create one') }}
                        </a>
                    </div>

                    <div class="simple-footer">
                        Copyright &copy; Stisla
                        <span id="year"></span>
                    </div>

                </div>
            </div>
        </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="{{ asset('assets/modules/jquery.min.js')}}"></script>
  <script src="{{ asset('assets/modules/popper.js')}}"></script>
  <script src="{{ asset('assets/modules/tooltip.js')}}"></script>
  <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js')}}"></script>
  <script src="{{ asset('assets/modules/moment.min.js')}}"></script>
  <script src="{{ asset('assets/js/stisla.js')}}"></script>
  
  <!-- JS Libraies -->

  <!-- Page Specific JS File -->
  
  <!-- Template JS File -->
  <script src="{{ asset('assets/js/scripts.js')}}"></script>
  <script src="{{ asset('assets/js/custom.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  @if (@session()->has('success'))
  <script>
    Swal.fire({
      text: "{{ session()->get('success')}}",
      icon: "success",
      toast: true,
      position: 'top-end',
      showComfirmButton: false,
      timer:3000
    })
  </script>
  @endif 

   @if (@session()->has('error'))
  <script>
    Swal.fire({
      text: "{{ session()->get('error')}}",
      icon: "error",
      toast: true,
      position: 'top-end',
      showComfirmButton: false,
      timer:3000
    })
  </script>
  @endif 

  <script>
    const year = document.getElementById('year');
    year.innerHTML = new Date().getFullYear();
  </script>
</body>
</html>