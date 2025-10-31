<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','ProTrack')</title>
    <!-- Bootstrap CDN para un look atractivo sin build steps -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding-top: 70px; background: linear-gradient(120deg,#f8fafc,#eef2ff); }
        .card-hero { height: 140px; object-fit: cover; border-bottom-left-radius: .5rem; border-bottom-right-radius: .5rem; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container">
    <a class="navbar-brand" href="{{ route('home') }}">ProTrack</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="{{ route('lang.switch','es') }}">ES</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('lang.switch','en') }}">EN</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
