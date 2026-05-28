<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'RaanyProp') }}</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@700;800;900&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
        <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
        <style>
            .outfit { font-family: 'Outfit', sans-serif; }
            .inter  { font-family: 'Inter', sans-serif; }
            .playfair { font-family: 'Playfair Display', serif; }
            .gradient-text { background: linear-gradient(135deg, #b75c1c 0%, #a65319 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
            .glass { background: #ffffff; box-shadow: 0 4px 20px rgba(62, 52, 47, 0.05); border: 1px solid rgba(183, 92, 28, 0.15); border-radius: 1.5rem; }
        </style>
    </head>
    <body class="inter text-[#3e342f] antialiased min-h-screen flex flex-col" style="background: #fdfbf7;">
        {{ $slot }}
    </body>
</html>
