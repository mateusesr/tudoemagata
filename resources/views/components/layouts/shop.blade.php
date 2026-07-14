<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Tudo em Ágata' }}</title>
    @if(isset($seoDescription))
        <meta name="description" content="{{ $seoDescription }}">
    @endif
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-agata-50 font-sans text-agata-900 antialiased">
    <header class="sticky top-0 z-40 border-b border-agata-200/70 bg-agata-50/90 backdrop-blur">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="flex flex-col">
                <span class="font-serif text-2xl font-semibold tracking-wide text-agata-800">Tudo em Ágata</span>
                <span class="-mt-1 text-[0.65rem] uppercase tracking-[0.3em] text-agata-500">Pedras naturais &amp; decoração</span>
            </a>

            <form action="{{ route('search') }}" method="GET" class="hidden max-w-sm flex-1 sm:block">
                <label for="q" class="sr-only">Buscar produtos</label>
                <input
                    type="search"
                    name="q"
                    id="q"
                    value="{{ request('q') }}"
                    placeholder="Buscar por peça, pedra ou uso..."
                    class="w-full rounded-full border border-agata-200 bg-white px-4 py-2 text-sm text-agata-800 placeholder:text-agata-400 focus:border-agata-400 focus:outline-none focus:ring-2 focus:ring-agata-300"
                >
            </form>

            <nav class="flex items-center gap-4 text-sm font-medium text-agata-700">
                <a href="{{ route('search') }}" class="sm:hidden" aria-label="Buscar">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.65 4.65a7.5 7.5 0 0011.99 11.99z" />
                    </svg>
                </a>
                <a href="{{ route('cart.show') }}" class="hover:text-agata-900">Carrinho</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="hover:text-agata-900">Minha conta</a>
                @else
                    <a href="{{ route('login') }}" class="hover:text-agata-900">Entrar</a>
                @endauth
            </nav>
        </div>
    </header>

    <main>
        {{ $slot }}
    </main>

    <footer class="mt-16 border-t border-agata-200 bg-agata-100/60">
        <div class="mx-auto grid max-w-6xl gap-8 px-4 py-10 sm:px-6 md:grid-cols-3 lg:px-8">
            <div>
                <span class="font-serif text-xl font-semibold text-agata-800">Tudo em Ágata</span>
                <p class="mt-3 text-sm text-agata-600">Produção própria de peças em ágata, pedras naturais e decoração para casa, com tradição de mais de 30 anos.</p>
            </div>
            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wide text-agata-800">Atendimento</h3>
                <ul class="mt-3 space-y-2 text-sm text-agata-600">
                    <li><a href="#" class="hover:text-agata-900">WhatsApp</a></li>
                    <li><a href="#" class="hover:text-agata-900">Instagram</a></li>
                    <li><a href="#" class="hover:text-agata-900">Contato</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wide text-agata-800">Políticas</h3>
                <ul class="mt-3 space-y-2 text-sm text-agata-600">
                    <li><a href="#" class="hover:text-agata-900">Envio e prazos</a></li>
                    <li><a href="#" class="hover:text-agata-900">Trocas e devoluções</a></li>
                    <li><a href="#" class="hover:text-agata-900">Privacidade</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-agata-200 py-4 text-center text-xs text-agata-500">
            &copy; {{ date('Y') }} Tudo em Ágata. Todos os direitos reservados.
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
