
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Biblioteca Leitura Ativa')</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        body {
            background: #f5f6f8;
            color: #263238;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background: #ffffff;
            border-bottom: 1px solid #e8eaed;
        }

        .brand-name {
            font-weight: 700;
            color: #263b53;
        }

        .main-content {
            padding-top: 40px;
            padding-bottom: 40px;
        }

        .card {
            border: 1px solid #e8eaed;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .03);
        }

        .btn-primary {
            background: #315b83;
            border-color: #315b83;
        }

        .btn-primary:hover {
            background: #254766;
            border-color: #254766;
        }
    </style>

    @stack('styles')
</head>
<body>

    @auth
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand brand-name" href="{{ route('painel') }}">
                    Biblioteca Leitura Ativa
                </a>

                <div class="d-flex align-items-center gap-3">
                    <span class="text-secondary small">
                        {{ auth()->user()->name }}
                    </span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button type="submit" class="btn btn-outline-secondary btn-sm">
                            Sair
                        </button>
                    </form>
                </div>
            </div>
        </nav>
    @endauth

    <main class="container main-content">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
