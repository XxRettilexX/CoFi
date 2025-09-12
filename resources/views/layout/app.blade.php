<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="CoFi - Gestione finanziaria familiare semplice, sicura e collaborativa.">
    <title>CoFi – Gestione Finanziaria Familiare</title>

    {{-- Bootstrap CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">


    {{-- CSS personalizzato --}}
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f4f8;
            color: #333;
            line-height: 1.6;
        }

        /* Navbar */
        .navbar {
            background-color: #3b82f6;
            /* blu pastello dominante */
            padding: 1rem 2rem;
        }

        .navbar .navbar-brand,
        .navbar .nav-link {
            color: #fff;
        }

        .navbar .nav-link:hover {
            color: #dbeafe;
        }

        /* Footer */
        footer {
            background: #e0e7ff;
            color: #1e3a8a;
            text-align: center;
            padding: 1rem;
            margin-top: 3rem;
            font-size: 0.9rem;
        }

        footer a {
            color: #1e3a8a;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        /* Welcome Page */
        .welcome-container {
            min-height: 80vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 2rem;
        }

        .welcome-container h1 {
            font-size: 3rem;
            font-weight: 700;
            color: #1e40af;
            /* blu pastello scuro per eleganza */
            margin-bottom: 1.5rem;
        }

        .welcome-container p {
            font-size: 1.2rem;
            color: #1e3a8a;
            margin-bottom: 2rem;
            max-width: 600px;
        }

        .btn-primary-pastel {
            background-color: #3b82f6;
            color: #fff;
            padding: 0.75rem 2rem;
            border-radius: 12px;
            font-weight: 500;
        }

        .btn-primary-pastel:hover {
            background-color: #2563eb;
            color: #fff;
        }
    </style>
</head>

<body>

    {{-- Navbar --}}
    @include('layout.navbar')

    {{-- Contenuto principale --}}
    <main class="container">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('layout.footer')

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</html>