<x-layouts.shop :title="$category->name . ' — Tudo em Ágata'">
    <section class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        <nav class="text-xs text-agata-500">
            <a href="{{ route('home') }}" class="hover:text-agata-700">Início</a>
            <span class="mx-1">/</span>
            <span class="text-agata-700">{{ $category->name }}</span>
        </nav>

        <h1 class="mt-3 font-serif text-3xl font-medium text-agata-900">{{ $category->name }}</h1>
        @if($category->description)
            <p class="mt-2 max-w-2xl text-agata-600">{{ $category->description }}</p>
        @endif

        @if($products->isEmpty())
            <div class="mt-10 rounded-2xl border border-dashed border-agata-300 bg-white p-10 text-center">
                <p class="font-serif text-lg text-agata-800">Nenhum produto encontrado nesta categoria no momento.</p>
                <p class="mt-2 text-sm text-agata-500">Fale com a gente pelo WhatsApp ou explore outras categorias.</p>
                <a href="{{ route('home') }}" class="mt-4 inline-block rounded-full bg-agata-800 px-5 py-2.5 text-sm font-semibold text-white hover:bg-agata-900">
                    Voltar para a home
                </a>
            </div>
        @else
            <div class="mt-8 grid gap-5 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                @foreach($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        @endif
    </section>
</x-layouts.shop>
