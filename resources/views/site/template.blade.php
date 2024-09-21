<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <link rel="icon" href="{{ asset('static/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <title>felizNiver</title>
</head>
<body class="bg-cyan-400 scroll-smooth">
    <img src="{{ asset('static/flags.png') }}" alt="" class="fixed -z-10 w-full opacity-60 md:opacity-20 transition">
    <nav class="flex justify-center sticky top-0 z-40">
        <a href="{{ route('site.create') }}" class="flex items-center gap-1 text-xl h-16 text-white font-bold">
            <img src="{{ asset('static/logo.png') }}" alt="Emoji de aniversário" class="w-8">
            felizNiver
        </a>
    </nav>
    <main class="p-4">
        <div class="w-full md:w-1/2 m-auto">
            @yield('content')
        </div>
    </main>
    <footer>

    </footer>
</body>
</html>
