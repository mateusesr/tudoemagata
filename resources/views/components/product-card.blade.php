@props(['product'])

@php
    $primaryImage = $product->images->firstWhere('is_primary', true) ?? $product->images->first();
    $cheapestVariant = $product->variants->sortBy('price')->first();
    $isSoldOut = $product->variants->every(fn ($variant) => $variant->status === 'sold_out' || $variant->availableQuantity() <= 0);
@endphp

<a href="{{ route('products.show', $product->slug) }}" class="group flex flex-col overflow-hidden rounded-2xl border border-agata-200 bg-white shadow-sm transition hover:shadow-md">
    <div class="relative aspect-square overflow-hidden bg-agata-100">
        @if($primaryImage)
            <img
                src="{{ $primaryImage->path }}"
                alt="{{ $primaryImage->alt_text ?? $product->name }}"
                class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                loading="lazy"
            >
        @else
            <div class="flex h-full w-full items-center justify-center text-agata-400">
                <span class="text-xs">Sem imagem</span>
            </div>
        @endif

        <div class="absolute left-3 top-3 flex flex-col gap-1">
            @if($product->isUnique())
                <x-product-badge type="unique" />
            @endif
            @if($product->is_featured)
                <x-product-badge type="featured" />
            @endif
            @if($isSoldOut)
                <x-product-badge type="sold_out" />
            @endif
        </div>
    </div>

    <div class="flex flex-1 flex-col gap-1 p-4">
        <p class="text-[0.65rem] uppercase tracking-[0.25em] text-agata-500">{{ $product->category?->name }}</p>
        <h3 class="font-serif text-lg font-medium leading-snug text-agata-900">{{ $product->name }}</h3>
        @if($cheapestVariant)
            <p class="mt-1 text-base font-semibold text-agata-800">
                R$ {{ number_format($cheapestVariant->price, 2, ',', '.') }}
            </p>
        @endif
    </div>
</a>
