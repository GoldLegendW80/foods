<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Elsan Food') }}</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        :root {
            --bg-primary: #121212;
            --bg-secondary: #1E1E1E;
            --text-primary: #E0E0E0;
            --text-secondary: #B0B0B0;
            --accent: #FFB708;
            --border: #333333;
            --hover: #FF9500;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background-color: var(--bg-primary);
            color: var(--text-primary);
        }

        .navbar {
            background-color: var(--bg-secondary) !important;
        }

        .navbar-brand, .nav-link {
            color: var(--text-primary) !important;
        }

        .navbar-brand:hover, .nav-link:hover {
            color: var(--accent) !important;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 255, 255, 0.55)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .navbar-toggler {
            border-color: var(--border);
        }

        .footer {
            background-color: var(--bg-secondary);
            color: var(--text-secondary);
        }

        .bg-dark {
            background-color: var(--bg-primary) !important;
        }

        .bg-secondary {
            background-color: var(--bg-secondary) !important;
        }

        .text-light {
            color: var(--text-primary) !important;
        }

        .text-secondary {
            color: var(--text-secondary) !important;
        }

        .text-accent {
            color: var(--accent) !important;
        }

        .border-dark {
            border-color: var(--border) !important;
        }

        .btn-accent {
            background-color: var(--accent);
            border-color: var(--accent);
            color: var(--bg-primary);
        }

        .btn-accent:hover {
            background-color: var(--hover);
            border-color: var(--hover);
            color: var(--bg-primary);
        }

        .btn-outline-accent {
            color: var(--accent);
            border-color: var(--accent);
        }

        .btn-outline-accent:hover {
            background-color: var(--accent);
            color: var(--bg-primary);
        }

        .btn-outline-light {
            color: var(--text-primary);
            border-color: var(--text-primary);
        }

        .btn-outline-light:hover {
            background-color: var(--text-primary);
            color: var(--bg-primary);
        }

        .restaurant-card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .restaurant-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .restaurant-card .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .restaurant-card .card-title {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .restaurant-card .rating {
            font-size: 0.9rem;
        }

        .pagination .page-link {
            background-color: var(--bg-secondary);
            border-color: var(--border);
            color: var(--text-primary);
        }

        .pagination .page-link:hover {
            background-color: var(--hover);
            border-color: var(--hover);
            color: var(--bg-primary);
        }

        .pagination .page-item.active .page-link {
            background-color: var(--accent);
            border-color: var(--accent);
            color: var(--bg-primary);
        }

        #map {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .modal-content {
            background-color: var(--bg-secondary);
            border: none;
            border-radius: 10px;
        }

        .modal-header, .modal-footer {
            border-color: var(--border);
        }

        .form-control {
            background-color: var(--bg-primary);
            border-color: var(--border);
            color: var(--text-primary);
        }

        .form-control:focus {
            background-color: var(--bg-primary);
            border-color: var(--accent);
            box-shadow: 0 0 0 0.25rem rgba(255, 183, 8, 0.25);
            color: var(--text-primary);
        }

        .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }

        .toast {
            background-color: var(--bg-secondary);
            border-radius: 10px;
        }

        .toast-success {
            border-left: 4px solid #4caf50;
        }

        .toast-error {
            border-left: 4px solid #f44336;
        }

        /* Personnalisation des scrollbars pour les navigateurs WebKit */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-secondary);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--accent);
        }
    </style>
    @stack('styles')
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    @stack('scripts')
</head>
<body class="font-sans antialiased">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('restaurants.index') }}">Elsan Food</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('restaurants.index') }}">Restaurants</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('categories.index') }}">Catégories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('fortune-wheel') }}">Roue de la Fortune</a>
                </li>
            </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <footer class="footer text-center text-lg-start mt-4">
        <div class="text-center p-3">
            © {{ date('Y') }} Elsan Food. Tous droits réservés.
        </div>
    </footer>
</body>
</html>