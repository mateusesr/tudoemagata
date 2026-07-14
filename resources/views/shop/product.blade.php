<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Produto | Tudo em Ágata</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-stone-50 text-stone-800">
    <div class="min-h-screen">
        <header class="border-b border-stone-200 bg-white/90 backdrop-blur">
            <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                <a href="/catalogo" class="text-sm font-medium text-stone-700">Voltar</a>
                <h1 class="text-lg font-semibold text-stone-900">Produto</h1>
                <span class="text-sm text-stone-500">MVP</span>
            </div>
        </header>

        <main class="mx-auto max-w-6xl px-4 py-6 sm:px-6 lg:px-8">
            <div id="product-root" class="rounded-[2rem] border border-stone-200 bg-white p-4 shadow-sm sm:p-6"></div>
        </main>
    </div>

    <script>
        const slug = window.location.pathname.split('/').filter(Boolean).pop();
        fetch(`/api/products/${slug}`)
            .then(response => response.json())
            .then(({ product }) => {
                const root = document.getElementById('product-root');
                root.innerHTML = `
                    <div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
                        <img src="${product.image_url || 'https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?auto=format&fit=crop&w=800&q=80'}" alt="${product.name}" class="h-[320px] w-full rounded-[1.5rem] object-cover sm:h-[420px]" />
                        <div class="flex flex-col gap-4">
                            <p class="text-sm uppercase tracking-[0.3em] text-stone-500">${product.category?.name || 'Catálogo'}</p>
                            <h2 class="text-3xl font-semibold text-stone-900">${product.name}</h2>
                            <p class="text-stone-600">${product.description}</p>
                            <div class="rounded-2xl border border-stone-200 bg-stone-50 p-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-stone-500">Preço</span>
                                    <span class="text-2xl font-semibold text-stone-900">R$ ${Number(product.price).toFixed(2)}</span>
                                </div>
                                <div class="mt-3 flex items-center justify-between text-sm text-stone-600">
                                    <span>Estoque</span>
                                    <span>${product.stock_quantity}</span>
                                </div>
                                <div class="mt-3 flex items-center justify-between text-sm text-stone-600">
                                    <span>Peça única</span>
                                    <span>${product.is_unique ? 'Sim' : 'Não'}</span>
                                </div>
                            </div>
                            <button class="rounded-full bg-stone-900 px-5 py-3 text-center text-sm font-semibold text-white">Adicionar ao carrinho</button>
                        </div>
                    </div>
                `;
            });
    </script>
</body>
</html>
