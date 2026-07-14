@props(['type'])

@php
$labels = [
    'unique' => 'Peça única',
    'featured' => 'Destaque',
    'sold_out' => 'Esgotado',
    'illustrative' => 'Imagem ilustrativa',
];

$colors = [
    'unique' => 'bg-gold-500 text-white',
    'featured' => 'bg-agata-800 text-white',
    'sold_out' => 'bg-agata-200 text-agata-600',
    'illustrative' => 'bg-agata-100 text-agata-600',
];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-full px-3 py-1 text-[0.65rem] font-semibold uppercase tracking-wide ' . ($colors[$type] ?? 'bg-agata-100 text-agata-600')]) }}>
    {{ $labels[$type] ?? $slot }}
</span>
