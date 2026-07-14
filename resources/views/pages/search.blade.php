<x-layouts.shop :title="'Busca — Tudo em Ágata'">
    <section class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        <form action="{{ route('search') }}" method="GET" class="mx-auto max-w-xl">
            <label for="q" class="sr-only">Buscar produtos</label>
            <div class="flex gap-2">
                <input
                    type="search"
                    name="q"
                    id="q"
                    value="{{ $term }}"
                    placeholder="Buscar por peça, pedra ou uso..."
                    class="w-full rounded-full border border-agata-200 bg-white px-4 py-3 text-sm text-agata-800 placeholder:text-agata-400 focus:border-agata-400 focus:outline-none focus:ring-2 focus:ring-agata-300"
                    autofocus
                >
                <button type="submit" class="rounded-full bg-agata-800 px-6 py-3 text-sm font-semibold text-white hover:bg-agata-900">
                    Buscar
                </button>
            </div>
        </form>

        @if($term === '')
            <p class="mt-10 text-center text-agata-500">Digite um termo para buscar produtos.</p>
        @elseif($products->isEmpty())
            <div class="mt-10 rounded-2xl border border-dashed border-agata-300 bg-white p-10 text-center">
                <p class="font-serif text-lg text-agata-800">Nenhum resultado para "{{ $term }}".</p>
                <p class="mt-2 text-sm text-agata-500">Tente outro termo ou explore nossos destaques na home.</p>
                <a href="{{ route('home') }}" class="mt-4 inline-block rounded-full bg-agata-800 px-5 py-2.5 text-sm font-semibold text-white hover:bg-agata-900">
                    Ver destaques
                </a>
            </div>
        @else
            <p class="mt-8 text-sm text-agata-500">{{ $products->count() }} resultado(s) para "{{ $term }}"</p>
            <div class="mt-4 grid gap-5 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                @foreach($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        @endif
    </section>
</x-layouts.shop>
