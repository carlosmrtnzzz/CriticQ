<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CriticQ | @yield('titulo')</title>

    <!-- Link estilos CSS -->
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">

    <!-- Link CDN Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Link Librería jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Link a Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Icono de la web con nuestro logo -->
    <link rel="icon" type="image/x-icon" href="{{ asset('extra/icono.ico') }}?v=2">

    <!-- Link Script para el menu dropdown -->
    <script src="{{ asset('js/extra/menuDropdown.js') }}"></script>

</head>

<body>
    <nav class="navbar navbar-expand-md d-md-none fixed-top navBarmovil">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('inicio') }}">
                <img src="{{ asset('extra/logo.png') }}" alt="Logo de la web" height="40">
            </a>
            <button class="toggler-custom" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMobile">
                <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('extra/default-foto.jpg') }}"
                    alt="Foto de perfil" class="toggler-img">
            </button>


            <div class="collapse navbar-collapse" id="navbarMobile">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('inicio') }}"><i class="fas fa-home"></i> Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/buscar"><i class="fas fa-search"></i> Explorar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/notificaciones"><i class="fas fa-bell"></i> Notificaciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('chat') }}"><i class="fas fa-envelope"></i> Mensajes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('perfil', ['username' => auth()->user()->username]) }}">
                            <i class="fas fa-user"></i>Perfil </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 sidebar d-none d-md-flex flex-column">
                <a href="{{ route('inicio') }}"><img src="{{ asset('extra/logo.png') }}" alt="Logo de la web"
                        class="logoImagen"></a>
                <nav class="nav flex-column">
                    <a href="{{ route('inicio') }}" class="nav-link">
                        <i class="fas fa-home"></i>
                        <p>Inicio</p>
                    </a>
                    <a href="/buscar" class="nav-link">
                        <i class="fas fa-search"></i>
                        <p>Explorar</p>
                    </a>
                    <a href="/notificaciones" class="nav-link">
                        <i class="fas fa-bell"></i>
                        <p>Notificaciones</p>
                    </a>
                    <a href="{{ route('chat') }}" class="nav-link">
                        <i class="fas fa-envelope"></i>
                        <p>Mensajes</p>
                    </a>
                    <a href="{{ route('perfil', ['username' => auth()->user()->username]) }}" class="nav-link">
                        <i class="fas fa-user"></i>
                        <p>Perfil</p>
                    </a>
                </nav>

                <div class="user-profile mt-auto text-center" id="userMenu">
                    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('extra/default-foto.jpg') }}"
                        alt="Foto de perfil" class="rounded-circle" width="60" height="60" style="object-fit: cover;">
                    <p style="margin-left: 10px" class="mt-2 mb-0">{{ Auth::user()->username }}</p>
                    <span class="arrow" id="arrow">▼</span>

                    <div id="dropdownMenu" class="dropdown-menu">
                        <a href="{{ route('perfil', ['username' => Auth::user()->username]) }}" class="dropdown-item">Ir
                            a mi perfil</a>
                        <form action="{{ route('logout') }}" method="POST" class="dropdown-item">
                            @csrf
                            <button type="submit" class="btn p-0 m-0 align-baseline">Cerrar sesión</button>
                        </form>
                    </div>
                </div>

            </div>

            <main class="col-12 col-md-9 col-lg-10 ms-sm-auto px-md-4 py-4 main-content">
                @yield('content')
            </main>
        </div>
    </div>

    <footer class="footer mt-auto py-3 w-100">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <p class="mb-0">&copy; {{ date('Y') }} CriticQ. Todos los derechos reservados.</p>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>