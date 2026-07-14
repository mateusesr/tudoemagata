@php
    $primaryImage = $product->images->firstWhere('is_primary', true) ?? $product->images->first();
    $gallery = $product->images->isNotEmpty() ? $product->images : collect([$primaryImage])->filter();
    $defaultVariant = $product->variants->sortBy('price')->first();
@endphp

<x-layouts.shop :title="$product->name . ' — Tudo em Ágata'" :seoDescription="$product->seo_description ?? $product->short_description">
    <section class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        <nav class="text-xs text-agata-500">
            <a href="{{ route('home') }}" class="hover:text-agata-700">Início</a>
            @if($product->category)
                <span class="mx-1">/</span>
                <a href="{{ route('categories.show', $product->category->slug) }}" class="hover:text-agata-700">{{ $product->category->name }}</a>
            @endif
            <span class="mx-1">/</span>
            <span class="text-agata-700">{{ $product->name }}</span>
        </nav>

        <div class="mt-6 grid gap-10 lg:grid-cols-[1.1fr_0.9fr]">
            <div>
                <div class="aspect-square overflow-hidden rounded-[1.5rem] bg-agata-100">
                    @if($primaryImage)
                        <img
                            src="{{ $primaryImage->path }}"
                            alt="{{ $primaryImage->alt_text ?? $product->name }}"
                            class="h-full w-full object-cover"
                        >
                    @else
                        <div class="flex h-full w-full items-center justify-center text-agata-400">Sem imagem</div>
                    @endif
                </div>

                @if($gallery->count() > 1)
                    <div class="mt-4 grid grid-cols-4 gap-3">
                        @foreach($gallery as $image)
                            <div class="aspect-square overflow-hidden rounded-xl bg-agata-100">
                                <img src="{{ $image->path }}" alt="{{ $image->alt_text ?? $product->name }}" class="h-full w-full object-cover">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="flex flex-col gap-4">
                <div class="flex flex-wrap gap-2">
                    @if($product->isUnique())
                        <x-product-badge type="unique" />
                    @endif
                    @if($product->is_featured)
                        <x-product-badge type="featured" />
                    @endif
                    @if($product->type === 'standard')
                        <x-product-badge type="illustrative" />
                    @endif
                </div>

                <h1 class="font-serif text-3xl font-medium text-agata-900">{{ $product->name }}</h1>

                @if($product->short_description)
                    <p class="text-agata-600">{{ $product->short_description }}</p>
                @endif

                @if($product->isUnique())
                    <p class="rounded-xl bg-gold-500/10 px-4 py-3 text-sm text-agata-700">
                        Peça única: você recebe exatamente o item fotografado.
                    </p>
                @elseif($product->type === 'standard')
                    <p class="rounded-xl bg-agata-100 px-4 py-3 text-sm text-agata-700">
                        Imagem ilustrativa; variações naturais da pedra podem ocorrer.
                    </p>
                @endif

                <form class="rounded-2xl border border-agata-200 bg-white p-5" x-data="{ variantId: {{ $defaultVariant?->id ?? 'null' }} }">
                    @if($product->variants->count() > 1)
                        <label class="text-sm font-medium text-agata-800">Escolha a variação</label>
                        <div class="mt-2 flex flex-wrap gap-2">
                            @foreach($product->variants as $variant)
                                @php $available = $variant->availableQuantity() > 0 && $variant->status === 'active'; @endphp
                                <button
                                    type="button"
                                    @if($available)
                                        @click="variantId = {{ $variant->id }}"
                                        :class="variantId === {{ $variant->id }} ? 'border-agata-800 bg-agata-800 text-white' : 'border-agata-200 text-agata-700'"
                                    @else
                                        disabled
                                        class="cursor-not-allowed border-agata-100 text-agata-300 line-through"
                                    @endif
                                    class="rounded-full border px-4 py-2 text-sm font-medium transition"
                                >
                                    {{ $variant->name }}
                                </button>
                            @endforeach
                        </div>
                    @endif

                    <div class="mt-4 flex items-center justify-between border-t border-agata-100 pt-4">
                        <span class="text-sm text-agata-500">Preço</span>
                        <span class="font-serif text-2xl font-semibold text-agata-900">
                            R$ {{ number_format($defaultVariant->price ?? 0, 2, ',', '.') }}
                        </span>
                    </div>

                    @if($defaultVariant && $defaultVariant->availableQuantity() > 0 && $defaultVariant->status === 'active')
                        <button type="button" class="mt-4 w-full rounded-full bg-agata-800 px-5 py-3 text-center text-sm font-semibold text-white transition hover:bg-agata-900">
                            Adicionar ao carrinho
                        </button>
                    @else
                        <button type="button" disabled class="mt-4 w-full cursor-not-allowed rounded-full bg-agata-200 px-5 py-3 text-center text-sm font-semibold text-agata-500">
                            Esgotado
                        </button>
                    @endif
                </form>

                @if($product->description)
                    <div class="prose prose-sm mt-2 max-w-none text-agata-700">
                        <h2 class="font-serif text-lg font-medium text-agata-900">Sobre a peça</h2>
                        <p>{{ $product->description }}</p>
                    </div>
                @endif
            </div>
        </div>

        @if($product->relatedProducts->isNotEmpty())
            <div class="mt-16">
                <h2 class="font-serif text-2xl font-medium text-agata-900">Combine com</h2>
                <div class="mt-6 grid gap-5 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                    @foreach($product->relatedProducts as $related)
                        <x-product-card :product="$related" />
                    @endforeach
                </div>
            </div>
        @endif
    </section>
</x-layouts.shop>
