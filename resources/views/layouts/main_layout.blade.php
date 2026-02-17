<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dashboard')</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  @livewireStyles
</head>
<body class="bg-light">

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">
      <a class="navbar-brand" href="{{ url('/') }}">MyApp</a>
      <a class="navbar-brand"> - Login as: {{ auth()->user()->name }}</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          @auth
          
            <li class="nav-item ">
            <a href="{{ route('posts.index') }}" class="btn btn-outline-light btn-sm">Posts</a>
          </li>
           <li class="nav-item ms-2">
            <a href="{{ route('users.create') }}" class="btn btn-outline-light btn-sm">Create User</a>
          <li class="nav-item ms-2">
            <form action="{{ route('auth.logout') }}" method="post" class="d-flex">
              @csrf
              <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
            </form>
          </li>
         
          @endauth
        </ul>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="container">
    @yield('content')
  </div>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  @livewireScript
  @stack('scripts')
</body>
</html>