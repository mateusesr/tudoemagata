<x-layouts.shop :title="'Checkout — Tudo em Ágata'">
    <section
        class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:px-8"
        x-data="checkoutPage(@js($addresses), @js($summary))"
    >
        <h1 class="font-serif text-3xl font-medium text-agata-900">Finalizar compra</h1>

        <div class="mt-8 rounded-2xl border border-agata-200 bg-white p-6">
            <h2 class="font-serif text-lg font-medium text-agata-900">Endereço de entrega</h2>

            <div class="mt-4 flex flex-col gap-2" x-show="addresses.length > 0">
                <template x-for="address in addresses" :key="address.id">
                    <label class="flex cursor-pointer items-start gap-3 rounded-xl border p-4 text-sm" :class="addressId === address.id ? 'border-agata-800 bg-agata-50' : 'border-agata-200'">
                        <input type="radio" :value="address.id" x-model.number="addressId" @change="quotes = []; selectedQuote = null" class="mt-1">
                        <span>
                            <span class="block font-medium text-agata-900" x-text="address.recipient_name"></span>
                            <span class="block text-agata-600" x-text="`${address.street}, ${address.number} - ${address.neighborhood}, ${address.city}/${address.state}`"></span>
                            <span class="block text-agata-500" x-text="address.zip_code"></span>
                        </span>
                    </label>
                </template>
            </div>

            <div x-show="!showAddressForm" class="mt-4">
                <button type="button" @click="showAddressForm = true" class="text-sm font-semibold text-agata-800 hover:text-agata-900">
                    + Adicionar novo endereço
                </button>
            </div>

            <form x-show="showAddressForm" @submit.prevent="submitAddress()" class="mt-4 grid grid-cols-2 gap-3 rounded-xl border border-agata-200 p-4">
                <input x-model="newAddress.recipient_name" type="text" placeholder="Nome do destinatário" class="col-span-2 rounded-lg border border-agata-200 px-3 py-2 text-sm" required>
                <input x-model="newAddress.zip_code" type="text" placeholder="CEP" class="rounded-lg border border-agata-200 px-3 py-2 text-sm" required>
                <input x-model="newAddress.number" type="text" placeholder="Número" class="rounded-lg border border-agata-200 px-3 py-2 text-sm" required>
                <input x-model="newAddress.street" type="text" placeholder="Rua" class="col-span-2 rounded-lg border border-agata-200 px-3 py-2 text-sm" required>
                <input x-model="newAddress.complement" type="text" placeholder="Complemento (opcional)" class="col-span-2 rounded-lg border border-agata-200 px-3 py-2 text-sm">
                <input x-model="newAddress.neighborhood" type="text" placeholder="Bairro" class="rounded-lg border border-agata-200 px-3 py-2 text-sm" required>
                <input x-model="newAddress.city" type="text" placeholder="Cidade" class="rounded-lg border border-agata-200 px-3 py-2 text-sm" required>
                <input x-model="newAddress.state" type="text" placeholder="UF" maxlength="2" class="rounded-lg border border-agata-200 px-3 py-2 text-sm" required>

                <p x-show="addressError" x-text="addressError" class="col-span-2 text-sm text-red-600"></p>

                <div class="col-span-2 flex gap-2">
                    <button type="submit" :disabled="savingAddress" class="rounded-full bg-agata-800 px-5 py-2 text-sm font-semibold text-white hover:bg-agata-900 disabled:opacity-60">
                        <span x-show="!savingAddress">Salvar endereço</span>
                        <span x-show="savingAddress">Salvando...</span>
                    </button>
                    <button type="button" @click="showAddressForm = false" class="rounded-full border border-agata-200 px-5 py-2 text-sm font-medium text-agata-700">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>

        <div class="mt-6 rounded-2xl border border-agata-200 bg-white p-6" x-show="addressId">
            <h2 class="font-serif text-lg font-medium text-agata-900">Frete</h2>

            <button
                type="button"
                @click="fetchShipping()"
                :disabled="loadingShipping"
                class="mt-3 rounded-full border border-agata-800 px-5 py-2 text-sm font-semibold text-agata-800 hover:bg-agata-800 hover:text-white disabled:opacity-60"
            >
                <span x-show="!loadingShipping">Calcular frete</span>
                <span x-show="loadingShipping">Calculando...</span>
            </button>

            <p x-show="shippingError" x-text="shippingError" class="mt-3 text-sm text-red-600"></p>

            <div class="mt-4 flex flex-col gap-2" x-show="quotes.length > 0">
                <template x-for="(quote, index) in quotes" :key="index">
                    <label class="flex cursor-pointer items-center justify-between rounded-xl border p-4 text-sm" :class="selectedQuote === quote ? 'border-agata-800 bg-agata-50' : 'border-agata-200'">
                        <span class="flex items-center gap-3">
                            <input type="radio" @change="selectedQuote = quote" class="mt-0">
                            <span>
                                <span class="block font-medium text-agata-900" x-text="`${quote.provider} - ${quote.service}`"></span>
                                <span class="block text-agata-500" x-text="`Prazo: ${quote.deadline_days} dia(s)`"></span>
                            </span>
                        </span>
                        <span class="font-semibold text-agata-900" x-text="`R$ ${Number(quote.price).toFixed(2).replace('.', ',')}`"></span>
                    </label>
                </template>
            </div>
        </div>

        <div class="mt-6 rounded-2xl border border-agata-200 bg-white p-6" x-show="selectedQuote">
            <h2 class="font-serif text-lg font-medium text-agata-900">Revisão do pedido</h2>

            <div class="mt-4 flex flex-col gap-2 text-sm">
                <template x-for="item in summary.items" :key="item.id">
                    <div class="flex justify-between text-agata-700">
                        <span x-text="`${item.product_name} (${item.variant_name}) x${item.quantity}`"></span>
                        <span x-text="`R$ ${Number(item.subtotal).toFixed(2).replace('.', ',')}`"></span>
                    </div>
                </template>
                <div class="flex justify-between text-agata-700">
                    <span>Frete</span>
                    <span x-text="selectedQuote ? `R$ ${Number(selectedQuote.price).toFixed(2).replace('.', ',')}` : '-'"></span>
                </div>
                <div class="flex justify-between border-t border-agata-100 pt-2 font-serif text-lg font-semibold text-agata-900">
                    <span>Total</span>
                    <span x-text="`R$ ${(summary.total + (selectedQuote ? Number(selectedQuote.price) : 0)).toFixed(2).replace('.', ',')}`"></span>
                </div>
            </div>

            <p x-show="submitError" x-text="submitError" class="mt-3 text-sm text-red-600"></p>

            <button
                type="button"
                @click="submitOrder()"
                :disabled="submitting"
                class="mt-6 w-full rounded-full bg-agata-800 px-5 py-3 text-center text-sm font-semibold text-white transition hover:bg-agata-900 disabled:opacity-60"
            >
                <span x-show="!submitting">Finalizar e pagar</span>
                <span x-show="submitting">Redirecionando para o pagamento...</span>
            </button>
        </div>
    </section>

    @push('scripts')
    <script>
        function checkoutPage(initialAddresses, initialSummary) {
            return {
                addresses: initialAddresses,
                summary: initialSummary,
                addressId: initialAddresses.length === 1 ? initialAddresses[0].id : null,
                quotes: [],
                selectedQuote: null,
                loadingShipping: false,
                shippingError: null,
                submitting: false,
                submitError: null,
                showAddressForm: initialAddresses.length === 0,
                savingAddress: false,
                addressError: null,
                newAddress: {
                    recipient_name: '',
                    zip_code: '',
                    street: '',
                    number: '',
                    complement: '',
                    neighborhood: '',
                    city: '',
                    state: '',
                },

                async submitAddress() {
                    this.savingAddress = true;
                    this.addressError = null;

                    try {
                        const response = await fetch('{{ route('checkout.addresses.store') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                            },
                            body: JSON.stringify(this.newAddress),
                        });
                        const data = await response.json();
                        if (response.ok) {
                            this.addresses.push(data.address);
                            this.addressId = data.address.id;
                            this.showAddressForm = false;
                        } else {
                            this.addressError = data.message ?? 'Não foi possível salvar o endereço.';
                        }
                    } finally {
                        this.savingAddress = false;
                    }
                },

                async fetchShipping() {
                    const address = this.addresses.find(a => a.id === this.addressId);
                    if (!address) return;

                    this.loadingShipping = true;
                    this.shippingError = null;
                    this.quotes = [];
                    this.selectedQuote = null;

                    try {
                        const response = await fetch('{{ route('checkout.shipping.quote') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                            },
                            body: JSON.stringify({ zip_code: address.zip_code }),
                        });
                        const data = await response.json();
                        if (response.ok) {
                            this.quotes = data.quotes;
                        } else {
                            this.shippingError = data.message ?? 'Não foi possível calcular o frete. Fale conosco pelo WhatsApp.';
                        }
                    } finally {
                        this.loadingShipping = false;
                    }
                },

                async submitOrder() {
                    if (!this.addressId || !this.selectedQuote) return;

                    this.submitting = true;
                    this.submitError = null;

                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route('checkout.store') }}';

                    const fields = {
                        _token: document.querySelector('meta[name=csrf-token]').content,
                        customer_address_id: this.addressId,
                        shipping_provider: this.selectedQuote.provider,
                        shipping_service: this.selectedQuote.service,
                        shipping_price: this.selectedQuote.price,
                        shipping_deadline_days: this.selectedQuote.deadline_days,
                    };

                    for (const [key, value] of Object.entries(fields)) {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = key;
                        input.value = value;
                        form.appendChild(input);
                    }

                    document.body.appendChild(form);
                    form.submit();
                },
            };
        }
    </script>
    @endpush
</x-layouts.shop>
