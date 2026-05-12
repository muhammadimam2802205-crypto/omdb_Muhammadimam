<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Ecom         merce Dashboard &mdash; Stisla</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{asset('assets/modules/bootstrap/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/modules/fontawesome/css/all.min.css')}}">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{asset('assets/modules/jqvmap/dist/jqvmap.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/modules/summernote/summernote-bs4.css')}}">
  <link rel="stylesheet" href="{{asset('assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css')}}">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
  <link rel="stylesheet" href="{{asset('assets/css/components.css')}}">
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
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li>
                <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg">
                    <i class="fas fa-bars"></i>
                </a>
            </li>

            <li>
                <a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none">
                    <i class="fas fa-search"></i>
                </a>
            </li>
        </ul>
    </form>

    <ul class="navbar-nav navbar-right">

        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user"
                aria-expanded="false">

                <div class="d-sm-none d-lg-inline-block">
                    <i class="fas fa-globe"></i>
                    {{ app()->getLocale() == 'en' ? 'EN' : 'ID' }}
                </div>
            </a>

            <div class="dropdown-menu dropdown-menu-right">

                <a href="{{ route('lang.switch', 'en') }}"
                    class="dropdown-item has-icon {{ app()->getLocale() == 'en' ? 'text-primary' : '' }}">

                    <i class="fas fa-check-circle"></i>
                    {{ __('English') }}
                </a>

                <a href="{{ route('lang.switch', 'id') }}"
                    class="dropdown-item has-icon {{ app()->getLocale() == 'id' ? 'text-primary' : '' }}">

                    <i class="fas fa-check-circle"></i>
                    {{ __('Bahasa Indonesia') }}
                </a>

            </div>
        </li>

        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">

                <img alt="image" src="{{ url('/') }}/assets/img/avatar/avatar-1.png"
                    class="rounded-circle mr-1">

                <div class="d-sm-none d-lg-inline-block">
                    {{ __('Hi') }}, {{ Auth::user()->name ?? __('Guest') }}
                </div>
            </a>

            <div class="dropdown-menu dropdown-menu-right">

                <a href="{{ route('signout') }}" class="dropdown-item has-icon text-danger">

                    <i class="fas fa-sign-out-alt"></i>
                    {{ __('Logout') }}
                </a>

            </div>
        </li>

    </ul>
</nav>
@include('template.sidebar')
