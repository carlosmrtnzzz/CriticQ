<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CriticQ | @yield('titulo')</title>

    <!-- Link estilos CSS -->
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">

    <!-- Link CDN Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <!-- Link Librería jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <!-- Link a Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Icono de la web con nuestro logo -->
    <link rel="icon" type="image/x-icon" href="{{ asset('extra/icono.ico') }}?v=2">

</head>

<body class="d-flex flex-column min-vh-100 justify-content-center align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-5 text-center mb-4">
                <a href="{{ route('welcome') }}"> <img src="{{ asset('extra/logo.png') }}" alt="Logo de la web"
                        height="120" class="logoGrande"></a>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-5">
                @yield('content')
            </div>
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