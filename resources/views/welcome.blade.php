<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MediLife - Descarte e Reaproveitamento</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
        }

        .btn-custom {
            background-color: #d8f3dc;

            color: #1b4332;

            font-weight: bold;
        }

        .btn-custom:hover {
            background-color: #b7e4c7;
            color: #1b4332;
        }
    </style>
</head>

<body class="d-flex flex-column">


    <main class="flex-fill d-flex flex-column align-items-center justify-content-center text-center px-4 bg-success bg-gradient text-white">
        <h1 class="display-4 fw-bold mb-4">
            Bem-vindo ao Sistema de <span style="color:#d8f3dc;">Descarte e Reaproveitamento</span>
        </h1>
        <p class="lead mb-4">
            Nosso sistema ajuda você a gerenciar medicamentos, evitar desperdícios,
            receber alertas de vencimento e realizar doações de forma segura e sustentável.
        </p>
        <div class="d-flex gap-3">
            <a href="{{ route('register') }}" class="btn btn-custom px-4 py-2 shadow">
                Começar Agora
            </a>
            <a href="{{ route('login') }}" class="btn btn-light text-success fw-bold px-4 py-2 shadow">
                Já tenho conta
            </a>
        </div>
    </main>


    <footer class="w-100 py-3 text-center bg-success text-white small">
        &copy; {{ date('Y') }} MediLife - Sistema de Gerenciamento de Medicamentos | Desenvolvido por Leonardo Mikael C. Cybulski
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>