<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Catálogo | Tudo em Ágata</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-stone-50 text-stone-800">
    <div class="min-h-screen">
        <header class="border-b border-stone-200 bg-white/90 backdrop-blur">
            <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                <a href="/" class="text-sm font-medium text-stone-700">Voltar</a>
                <h1 class="text-lg font-semibold text-stone-900">Catálogo</h1>
                <span class="text-sm text-stone-500">MVP</span>
            </div>
        </header>

        <main class="mx-auto max-w-6xl px-4 py-6 sm:px-6 lg:px-8">
            <div id="catalog-root" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3"></div>
        </main>
    </div>

    <script>
        fetch('/api/products')
            .then(response => response.json())
            .then(({ products }) => {
                const root = document.getElementById('catalog-root');
                root.innerHTML = products.map(product => `
                    <article class="overflow-hidden rounded-[1.5rem] border border-stone-200 bg-white shadow-sm">
                        <img src="${product.image_url || 'https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?auto=format&fit=crop&w=800&q=80'}" alt="${product.name}" class="h-48 w-full object-cover" />
                        <div class="p-4">
                            <p class="text-xs uppercase tracking-[0.25em] text-stone-500">${product.category?.name || 'Catálogo'}</p>
                            <h2 class="mt-2 text-lg font-semibold text-stone-900">${product.name}</h2>
                            <p class="mt-2 text-sm text-stone-600">${product.short_description || product.description}</p>
                            <div class="mt-4 flex items-center justify-between">
                                <span class="text-base font-semibold text-stone-900">R$ ${Number(product.price).toFixed(2)}</span>
                                <a href="/produto/${product.slug}" class="rounded-full bg-stone-900 px-3 py-2 text-sm font-medium text-white">Ver mais</a>
                            </div>
                        </div>
                    </article>
                `).join('');
            });
    </script>
</body>
</html>
