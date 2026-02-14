<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gerenciamento de Medicamentos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background-color: #1b4332;
        }

        .navbar-brand {
            font-weight: bold;
            color: #ffffff !important;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-brand img {
            height: 90px;
            object-fit: contain;
        }

        .navbar-brand span {
            color: #d8f3dc !important;
            font-weight: bold;
        }

        .nav-link {
            color: #ffffff !important;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .nav-link:hover {
            color: #d8f3dc !important;
        }

        footer {
            padding: 12px 0;
            text-align: center;
            background-color: #1b4332;
            color: #ffffff;
        }

        .nav-link.btn {
            color: #ffffff !important;
            background: none;
            padding: 0;
            border: 0;
        }
    </style>

    @stack('styles')
</head>

<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg">
        <div class="container">

            <a class="navbar-brand" href="{{ Auth::check() ? route('home') : route('login') }}">
                <img src="{{ asset('logo.jpg') }}" alt="MediLife Logo">
                <span class="fs-4">MediLife</span>
            </a>

            <button class="navbar-toggler text-white border-white" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">

                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">
                            <i class="bi bi-person-plus"></i> Registrar
                        </a>
                    </li>
                    @endguest

                    @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                            <i class="bi bi-house"></i> Início
                        </a>
                    </li>

                    @if(Auth::user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('medications.index') }}">
                            <i class="bi bi-capsule"></i> Medicamentos
                        </a>
                    </li>
                    @endif

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('informative') }}">
                            <i class="bi bi-info-circle"></i> Informações
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('reuse.index') }}">
                            <i class="bi bi-arrow-repeat"></i> Reaproveitamento
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-file-earmark-text"></i> Relatórios
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('reports.medications') }}">Medicamentos</a></li>
                            <li><a class="dropdown-item" href="{{ route('reports.donations') }}">Doações</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="nav-link btn">
                                <i class="bi bi-box-arrow-right"></i> Sair
                            </button>
                        </form>
                    </li>
                    @endauth

                </ul>
            </div>

        </div>
    </nav>

    <main class="flex-fill container mt-4">
        @yield('content')
    </main>

    <footer class="mt-auto">
        <p>&copy; {{ date('Y') }} MediLife - Sistema de Gerenciamento de Medicamentos</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')

</body>

</html>