@php
    $messages = [
        'success' => ['title' => 'Pagamento em confirmação', 'text' => 'Recebemos seu pagamento e estamos confirmando com o Mercado Pago. Assim que for aprovado, seu pedido avança para separação.'],
        'pending' => ['title' => 'Pagamento pendente', 'text' => 'Seu pagamento está pendente de confirmação (comum em Pix). Assim que for aprovado, atualizaremos seu pedido automaticamente.'],
        'failure' => ['title' => 'Pagamento não aprovado', 'text' => 'Não conseguimos confirmar o pagamento. Você pode tentar novamente pela área do cliente ou falar conosco pelo WhatsApp.'],
    ];
    $current = $messages[$status] ?? $messages['pending'];
@endphp

<x-layouts.shop :title="'Retorno do pagamento — Tudo em Ágata'">
    <section class="mx-auto max-w-lg px-4 py-16 text-center sm:px-6 lg:px-8">
        <h1 class="font-serif text-2xl font-medium text-agata-900">{{ $current['title'] }}</h1>
        <p class="mt-4 text-agata-600">{{ $current['text'] }}</p>
        <a href="{{ route('home') }}" class="mt-8 inline-block rounded-full bg-agata-800 px-6 py-3 text-sm font-semibold text-white hover:bg-agata-900">
            Voltar para a loja
        </a>
    </section>
</x-layouts.shop>
