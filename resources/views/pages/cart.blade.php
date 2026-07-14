<x-layouts.shop :title="'Carrinho — Tudo em Ágata'">
    <section class="mx-auto max-w-4xl px-4 py-10 sm:px-6 lg:px-8" x-data="cartPage(@js($summary))">
        <h1 class="font-serif text-3xl font-medium text-agata-900">Seu carrinho</h1>

        <template x-if="items.length === 0">
            <div class="mt-10 rounded-2xl border border-dashed border-agata-300 bg-white p-10 text-center">
                <p class="font-serif text-lg text-agata-800">Seu carrinho está vazio.</p>
                <p class="mt-2 text-sm text-agata-500">Explore nosso catálogo e encontre a peça perfeita.</p>
                <a href="{{ route('home') }}" class="mt-4 inline-block rounded-full bg-agata-800 px-5 py-2.5 text-sm font-semibold text-white hover:bg-agata-900">
                    Ver produtos
                </a>
            </div>
        </template>

        <template x-if="items.length > 0">
            <div class="mt-8 flex flex-col gap-4">
                <template x-for="item in items" :key="item.id">
                    <div class="flex items-center justify-between gap-4 rounded-2xl border border-agata-200 bg-white p-4">
                        <div>
                            <p class="font-serif text-base font-medium text-agata-900" x-text="item.product_name"></p>
                            <p class="text-xs text-agata-500" x-text="item.variant_name"></p>
                            <p class="mt-1 text-sm text-agata-600">
                                R$ <span x-text="Number(item.unit_price).toFixed(2).replace('.', ',')"></span>
                            </p>
                        </div>
                        <div class="flex items-center gap-3">
                            <input
                                type="number"
                                min="0"
                                :value="item.quantity"
                                @change="updateQuantity(item.id, $event.target.value)"
                                class="w-16 rounded-lg border border-agata-200 px-2 py-1 text-center text-sm"
                            >
                            <button @click="removeItem(item.id)" class="text-xs font-medium text-agata-500 hover:text-red-600">
                                Remover
                            </button>
                        </div>
                    </div>
                </template>

                <div class="mt-4 flex items-center justify-between border-t border-agata-200 pt-4">
                    <span class="text-sm text-agata-600">Total</span>
                    <span class="font-serif text-2xl font-semibold text-agata-900">
                        R$ <span x-text="total.toFixed(2).replace('.', ',')"></span>
                    </span>
                </div>

                <a href="{{ route('checkout.show') }}" class="mt-2 rounded-full bg-agata-800 px-5 py-3 text-center text-sm font-semibold text-white hover:bg-agata-900">
                    Ir para o checkout
                </a>
            </div>
        </template>
    </section>

    @push('scripts')
    <script>
        function cartPage(initialSummary) {
            return {
                items: initialSummary.items,
                total: Number(initialSummary.total),

                async updateQuantity(itemId, quantity) {
                    const response = await fetch(`/carrinho/itens/${itemId}`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify({ quantity: Number(quantity) }),
                    });
                    const data = await response.json();
                    if (response.ok) {
                        this.items = data.summary.items;
                        this.total = Number(data.summary.total);
                    }
                },

                async removeItem(itemId) {
                    const response = await fetch(`/carrinho/itens/${itemId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                    });
                    const data = await response.json();
                    if (response.ok) {
                        this.items = data.summary.items;
                        this.total = Number(data.summary.total);
                    }
                },
            };
        }
    </script>
    @endpush
</x-layouts.shop>
