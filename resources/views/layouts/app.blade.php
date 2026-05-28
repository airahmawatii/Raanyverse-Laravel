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
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <style>
            .outfit { font-family: 'Outfit', sans-serif; }
            .inter  { font-family: 'Inter', sans-serif; }
            .playfair { font-family: 'Playfair Display', serif; }
            .gradient-text { background: linear-gradient(135deg, #b75c1c 0%, #a65319 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
            body { background: #fdfbf7; color: #3e342f; }
            .nav-sidebar { background: #3e342f; border-right: 1px solid rgba(255, 255, 255, 0.05); }
            .page-header { background: #ffffff; border: 1px solid rgba(183, 92, 28, 0.1); border-radius: 1.5rem; box-shadow: 0 4px 20px rgba(62, 52, 47, 0.03); }
            .app-footer { background: #fdfbf7; border-top: 1px solid rgba(183, 92, 28, 0.1); }
            [x-cloak] { display: none !important; }
        </style>
    <body class="inter antialiased h-screen flex flex-col lg:flex-row overflow-hidden">
        
        <!-- Sidebar Navigation -->
        @include('layouts.navigation')

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col h-screen overflow-y-auto w-full relative bg-[#fdfbf7]">
            @isset($header)
                <header class="pt-20 lg:pt-8 pb-4 px-4 md:px-8">
                    <div class="max-w-7xl mx-auto">
                        <div class="page-header p-6 md:p-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                            <div class="text-[#3e342f] w-full">
                                {{ $header }}
                            </div>
                        </div>
                    </div>
                </header>
            @endisset

            <main class="flex-grow px-4 md:px-8 pb-16 @if(!isset($header)) pt-20 lg:pt-8 @else pt-4 @endif">
                <div class="max-w-7xl mx-auto">
                    {{ $slot }}
                </div>
            </main>

            <footer class="app-footer px-8 py-6 mt-auto">
                <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl flex items-center justify-center text-white" style="background: linear-gradient(135deg, #b75c1c 0%, #a65319 100%);">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        </div>
                        <span class="outfit font-black text-lg text-[#3e342f] leading-none">Raany<span class="gradient-text">Prop</span></span>
                    </div>
                    <p class="text-[10px] font-bold text-stone-500 uppercase tracking-widest">© 2026 RAANYVERSE PROPERTY</p>
                </div>
            </footer>
        </div>
    </body>
</html>
