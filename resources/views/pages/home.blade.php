<x-layouts.shop :title="'Tudo em Ágata — Pedras naturais, decoração e presentes'">
    <section class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="grid gap-8 rounded-[2rem] border border-agata-200 bg-white p-8 shadow-sm lg:grid-cols-[1.1fr_0.9fr] lg:p-12">
            <div class="flex flex-col justify-center gap-5">
                <span class="w-fit rounded-full bg-agata-100 px-3 py-1 text-xs font-medium uppercase tracking-wide text-agata-700">
                    Produção própria &middot; mais de 30 anos
                </span>
                <h1 class="font-serif text-4xl font-medium leading-tight text-agata-900 sm:text-5xl">
                    Peças em ágata e pedras naturais para casa e presente.
                </h1>
                <p class="max-w-xl text-agata-600">
                    Curadoria de peças únicas e produção própria em decoração, lavabo e presentes — com a mesma
                    confiança do nosso atendimento no WhatsApp, agora em um canal completo de compra.
                </p>
                <div class="flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('search') }}" class="rounded-full bg-agata-800 px-6 py-3 text-center text-sm font-semibold text-white transition hover:bg-agata-900">
                        Explorar catálogo
                    </a>
                </div>
            </div>
            <div class="rounded-[1.5rem] bg-agata-100 p-4">
                <div class="h-full min-h-[260px] rounded-[1.25rem] bg-[radial-gradient(circle_at_top,_#f3ebdd,_#d6b78d)]"></div>
            </div>
        </div>
    </section>

    <x-trust-badges />

    @if($categories->isNotEmpty())
        <section class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
            <h2 class="font-serif text-2xl font-medium text-agata-900">Navegue por categoria</h2>
            <div class="mt-6 grid gap-4 sm:grid-cols-2 md:grid-cols-4">
                @foreach($categories as $category)
                    <a href="{{ route('categories.show', $category->slug) }}" class="group rounded-2xl border border-agata-200 bg-white p-5 text-center shadow-sm transition hover:shadow-md">
                        <p class="font-serif text-lg font-medium text-agata-900 group-hover:text-agata-700">{{ $category->name }}</p>
                        @if($category->description)
                            <p class="mt-1 text-xs text-agata-500">{{ \Illuminate\Support\Str::limit($category->description, 50) }}</p>
                        @endif
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    @if($featured_products->isNotEmpty())
        <section class="mx-auto max-w-6xl px-4 pb-16 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <h2 class="font-serif text-2xl font-medium text-agata-900">Destaques e peças únicas</h2>
                <a href="{{ route('search') }}" class="text-sm font-medium text-agata-700 hover:text-agata-900">Ver tudo</a>
            </div>
            <div class="mt-6 grid gap-5 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                @foreach($featured_products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </section>
    @endif
</x-layouts.shop>
