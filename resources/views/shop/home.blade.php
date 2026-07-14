<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Tudo em Ágata | MVP</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-stone-50 text-stone-800">
    <div class="min-h-screen">
        <header class="border-b border-stone-200 bg-white/90 backdrop-blur">
            <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-stone-500">Tudo em Ágata</p>
                    <h1 class="text-lg font-semibold text-stone-900">Loja própria</h1>
                </div>
                <a href="/catalogo" class="rounded-full bg-stone-900 px-4 py-2 text-sm font-medium text-white">Ver catálogo</a>
            </div>
        </header>

        <main class="mx-auto flex max-w-6xl flex-col gap-8 px-4 py-8 sm:px-6 lg:px-8">
            <section class="grid gap-6 rounded-[2rem] border border-stone-200 bg-white p-6 shadow-sm lg:grid-cols-[1.2fr_0.8fr] lg:p-10">
                <div class="flex flex-col justify-center gap-4">
                    <span class="w-fit rounded-full bg-stone-100 px-3 py-1 text-sm text-stone-700">MVP de validação</span>
                    <h2 class="text-3xl font-semibold leading-tight sm:text-4xl">Uma experiência premium para vender pedras, presentes e peças únicas.</h2>
                    <p class="max-w-xl text-base text-stone-600">Catálogo simples, carrinho, checkout e painel administrativo para validar a ideia com menos complexidade.</p>
                    <div class="flex flex-col gap-3 sm:flex-row">
                        <a href="/catalogo" class="rounded-full bg-stone-900 px-5 py-3 text-center text-sm font-semibold text-white">Explorar produtos</a>
                        <a href="/produto/pulseira-de-agata-verde" class="rounded-full border border-stone-300 px-5 py-3 text-center text-sm font-semibold text-stone-700">Ver peça destaque</a>
                    </div>
                </div>
                <div class="rounded-[1.5rem] bg-stone-100 p-4">
                    <div class="h-full min-h-[260px] rounded-[1.25rem] bg-[radial-gradient(circle_at_top,_#f5efe6,_#e7ddd0)]"></div>
                </div>
            </section>

            <section class="grid gap-4 md:grid-cols-3">
                <div class="rounded-2xl border border-stone-200 bg-white p-5 shadow-sm">
                    <h3 class="font-semibold text-stone-900">Mobile first</h3>
                    <p class="mt-2 text-sm text-stone-600">Fluxo de compra pensado para celular, com etapas claras e menos atrito.</p>
                </div>
                <div class="rounded-2xl border border-stone-200 bg-white p-5 shadow-sm">
                    <h3 class="font-semibold text-stone-900">API simples</h3>
                    <p class="mt-2 text-sm text-stone-600">Front chamando uma API com regras de negócio em serviços e repositórios.</p>
                </div>
                <div class="rounded-2xl border border-stone-200 bg-white p-5 shadow-sm">
                    <h3 class="font-semibold text-stone-900">Escalável</h3>
                    <p class="mt-2 text-sm text-stone-600">Estrutura preparada para evoluir para estoque, checkout e admin.</p>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
