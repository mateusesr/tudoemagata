# CLAUDE.md

## Contexto do projeto
MVP de e-commerce varejo da Tudo em Ágata (pedras naturais, decoração, presentes), baseado no escopo consolidado em `escopo.MD`. Projeto Laravel single-tenant, não é SaaS multiempresa. Leia `escopo.MD` para qualquer dúvida de regra de negócio — este arquivo é um resumo operacional, não substitui o escopo.

## Objetivo principal
Substituir parte do atendimento manual via WhatsApp por um canal de vendas estruturado: catálogo com identidade premium, compra segura no varejo, controle de estoque (com atenção especial a peças únicas), pagamento via Mercado Pago, frete desacoplado de provedor, e painel administrativo simples para a equipe da marca operar sozinha.

## Prioridades do MVP
1. Fundação: modelo de domínio (users/customers, produtos, variações, estoque)
2. Catálogo público (home, categoria, produto, busca)
3. Autenticação (tradicional + Google) e área do cliente
4. Carrinho e checkout
5. Pagamento (Mercado Pago) e reserva de estoque
6. Frete (gateway desacoplado)
7. Painel administrativo (Filament)
8. Polimento visual premium e mobile-first, homologação

## Regras de negócio não-negociáveis
- **Somente varejo no MVP.** Sem preço atacado, pedido mínimo ou aprovação de lojista — mas o schema deve deixar espaço para isso depois (ver "Preparação para atacado" abaixo).
- Login obrigatório para finalizar compra (cadastro pode acontecer dentro do próprio checkout, sem barreira antes disso). Login tradicional + Google (Socialite) no MVP.
- **CPF/telefone nunca são chave primária.** `users.id` é a chave técnica; CPF fica em `customers.cpf`. Ver Apêndice B do escopo.
- **Peça única é caso crítico de estoque**: estoque = 1, selo visível, reserva temporária (`inventory_reservations`) criada ao iniciar o pagamento, convertida em baixa definitiva quando aprovado, liberada se expirar/cancelar/recusar. Nunca permitir venda duplicada.
- Baixa de estoque só acontece após pagamento aprovado (webhook). Pedido criado com status "pendente" antes do pagamento.
- Frete indisponível **não fecha o pedido automaticamente** — orienta contato via WhatsApp, salvo decisão comercial em contrário.
- Todo pedido guarda **snapshot** dos dados do produto/variação (nome, preço, imagem) no momento da compra — não referenciar apenas o produto atual.
- Vendas externas (WhatsApp/Instagram/presencial) precisam de baixa manual de estoque pelo admin.

## Stack (decidida, não é mais "a definir")
- Backend: Laravel 13 (já iniciado neste repo)
- Auth: Breeze + Socialite (Google)
- Admin: Filament
- Frontend: Blade + Tailwind, Alpine.js/Livewire onde precisar de interatividade pontual (SSR, evitar SPA)
- Banco: SQLite em dev local (já configurado); **MySQL em homologação/produção** conforme escopo — ajustar `.env` ao subir ambiente real
- Pagamento: **Mercado Pago Checkout Pro** (redirect hospedado pelo MP — Pix + cartão; sem checkout transparente/tokenização de cartão no servidor; sem boleto no MVP). Sem SDK oficial — cliente HTTP fino via `Http::` facade.
- Frete: camada `ShippingGateway` (interface própria) — **Melhor Envio** é o provedor concreto decidido (agregador REST que cota Correios PAC/SEDEX e outras transportadoras; sandbox em `MELHOR_ENVIO_BASE_URL`). Sem SDK — `Http::` facade, mesmo padrão do Mercado Pago.
- Imagens: storage local em dev, S3-compatible em produção

## Estado atual do código (verificar antes de assumir)
Fase 0 (fundação) concluída:
- Schema completo do modelo conceitual (escopo 10.3) criado via migrations: `categories` (com subcategoria via `parent_id`), `products`, `product_variants`, `customers`, `social_accounts`, `customer_addresses`, `product_images`, `product_relations`, `tags`/`product_tag`, `carts`/`cart_items`, `orders`/`order_items` (com snapshot), `payments`, `shipments`, `inventory_reservations`, `stock_movements`, `settings`, `audit_logs`. Todas migrando limpo em MySQL.
- **Estoque/preço/peso vivem só em `ProductVariant`** — `Product` não tem mais `stock_quantity`/`price`/`is_unique` própria; todo produto vendável (mesmo "padrão") tem ao menos 1 variante. `Product.type` é enum (`standard`/`variant`/`unique`/`kit`).
- Models Eloquent com relacionamentos criados para todas as tabelas acima.
- Breeze (stack Blade) instalado e funcionando. Socialite instalado com `GoogleAuthController` (`app/Http/Controllers/Auth/GoogleAuthController.php`) vinculando login Google por e-mail em `social_accounts` — falta só preencher `GOOGLE_CLIENT_ID`/`SECRET` reais no `.env`.
- Filament instalado, painel ativo em `/admin` (cor primária âmbar). Resources criados: `CategoryResource` (com subcategoria), `ProductResource` (com `VariantsRelationManager` e `ImagesRelationManager` inline), `OrderResource` (somente leitura + edição de status/rastreio — pedido não é criado manualmente pelo admin, nasce do checkout).
- **Locale da aplicação é `pt_BR`** (`APP_LOCALE`), com `en` de fallback. Traduções do Filament (panels/forms/tables/actions/notifications) publicadas em `lang/vendor/filament-*`. Toda tela do admin deve estar em português — Resources definem `getModelLabel()`/`getPluralModelLabel()`/`$navigationLabel` explicitamente (não confiar em inferência automática do Filament a partir do nome da classe).
- Seeder (`database/seeders/DatabaseSeeder.php`) popula categorias (peças únicas, decoração, presentes, lavabo como subcategoria) e um produto de cada tipo (`standard`, `variant`, `unique`, `kit`), incluindo imagens e uma relação `combine_with`.
- Ambiente local roda via Docker (`docker-compose.yml`): container `mvparejo_app` (PHP 8.3 + intl/gd/zip/bcmath — `intl` foi adicionado ao Dockerfile por exigência do Filament), `mvparejo_db` (MySQL 8, porta 3308), `mvparejo_nginx` (porta 8091). `.env` já aponta para `DB_HOST=db` (nome do serviço docker, não `127.0.0.1`). Rodar comandos artisan/composer via `docker exec mvparejo_app ...`. Setup completo documentado no README.

Fase 1 (catálogo público) concluída:
- Páginas SSR (Blade, sem SPA) em `resources/views/pages/`: `home.blade.php` (hero, blocos de confiança, categorias, destaques), `category.blade.php`, `product.blade.php` (galeria, seleção de variante via Alpine, selos de peça única/imagem ilustrativa, "combine com"), `search.blade.php`. Rotas: `/`, `/categoria/{slug}`, `/produto/{slug}`, `/busca`.
- Layout público em `resources/views/components/layouts/shop.blade.php` (precisa estar em `components/layouts/`, não em `views/layouts/`, para o Blade resolver `<x-layouts.shop>` — `views/layouts/` continua reservada para os layouts do Breeze/Filament).
- Componentes reutilizáveis: `x-product-card`, `x-product-badge` (peça única/destaque/esgotado/imagem ilustrativa), `x-trust-badges`.
- Paleta e tipografia do escopo (seção 6) aplicadas via `tailwind.config.js` (cores `agata`/`gold`, fonte serifada Cormorant Garamond para títulos + Figtree para o resto).
- `ProductRepository`/`ProductService` (já existiam como esqueleto do Copilot, estendidos aqui) centralizam as queries do catálogo — sempre eager-loading `category`, `variants`, `images`.
- Produtos sem imagem cadastrada mostram um estado "sem imagem" simples (decisão consciente: sem placeholder externo tipo Picsum, para não mascarar dados de catálogo incompletos).

Fase 2 (carrinho, checkout, frete, pagamento) concluída — **ciclo completo de compra testado ponta a ponta** (adicionar ao carrinho → checkout → pedido pending+reserva → aprovação via webhook → baixa de estoque):
- **Correção de gap crítico**: nem o registro tradicional (Breeze) nem o login Google criavam `Customer` para o `User`. Corrigido via `CreateCustomerRecordListener` (no evento `Registered`) + criação inline em `GoogleAuthController::callback()`.
- **Correção de gap crítico**: `routes/api.php` nunca esteve registrado em `bootstrap/app.php` (faltava `api: __DIR__.'/../routes/api.php'` em `withRouting()`) — a API de produtos já estava morta desde a Fase 0/1. Corrigido; necessário para o webhook do Mercado Pago funcionar.
- **Carrinho** (`app/Services/CartService.php` + `app/Repositories/CartRepository.php`, seguindo o padrão de `ProductService`/`ProductRepository`): resolve por `user_id` (logado) ou `session_id` (convidado); `MergeGuestCartListener` (evento `Login`) funde carrinho de sessão no carrinho do usuário. `CartController` + rotas `/carrinho*` (Alpine.js + fetch, sem Livewire). Valida `ProductVariant::availableQuantity()` antes de adicionar/atualizar — lança `InsufficientStockException` → 422.
- **`ShippingGateway`** (`app/Services/Shipping/`): interface + `MelhorEnvioGateway` (bind em `AppServiceProvider::register()`). Valida peso/dimensões de cada variante **antes** de chamar a API — lança `ShippingUnavailableException` com mensagem clara se faltar dado (hoje nenhuma variante do seeder tem `height_cm`/`width_cm`/`length_cm` preenchidos, só `weight_grams` — isso está correto/esperado, é dependência externa pendente do escopo). Se a API falhar/não retornar opções, mesma exceção — o checkout captura e orienta contato via WhatsApp, sem fechar pedido automaticamente.
- **`InventoryReservationService`** (`app/Services/InventoryReservationService.php`): `reserve()`/`convert()`/`release()`/`releaseExpired()`. `convert()` decrementa `stock_quantity` de fato + cria `StockMovement` (`sale_deduction`); `release()` marca reserva como liberada sem alterar estoque físico (`StockMovement` tipo `release`, quantidade 0). Comando `php artisan app:release-expired-reservations` varre reservas expiradas, agendado a cada 5min em `routes/console.php` via `Schedule::command(...)`.
- **`CheckoutController`** (`/checkout`, `auth` middleware): mostra endereços do `Customer` + resumo do carrinho → `POST /checkout/frete` cota via `ShippingGateway` → `POST /checkout` cria `Order`(pending)+`OrderItem`s(snapshot)+`InventoryReservation`s **numa única transação com `lockForUpdate()` na variante** (garantia real anti-venda-duplicada de peça única, testada com tentativas sequenciais) → fora da transação, chama `MercadoPagoService::createPreference()` e redireciona para `init_point`.
- **`MercadoPagoService`** (`app/Services/Payment/`): cria preference via `Http::` facade (sem SDK), `external_reference = order->id` amarra o webhook ao pedido. `Payment` continua `hasOne` em `Order`, atualizado in-place (`updateOrCreate([], [...])`) a cada tentativa — não duplica linha por retry.
- **Webhook** (`app/Http/Controllers/Api/MercadoPagoWebhookController.php`, `POST /api/webhooks/mercadopago`, sem CSRF): busca o pagamento real via API (nunca confia no payload do POST em si), localiza `Order` por `external_reference`, idempotente (`lockForUpdate()` no `Payment`, ignora se já `approved`), converte/libera reservas conforme status. Testado com evento duplicado — não duplica baixa de estoque.
- **Retorno do pagamento** (`GET /checkout/retorno`): tela informativa apenas ("pagamento em processamento") — nunca confirma pagamento pela query string do redirect, só o webhook confirma de fato.
- Testado via `Http::fake()` + tinker (sem credenciais reais de sandbox ainda): ciclo completo, idempotência do webhook, e bloqueio de reserva concorrente em peça única.
- Falta ainda: área do cliente (histórico de pedidos, gestão de endereços — hoje só existe o model/dados, sem UI), Filament Resources de estoque/vendas externas/configurações, credenciais reais de sandbox (Mercado Pago e Melhor Envio) para validar a chamada de rede de verdade e o webhook via túnel público (ngrok).

## Preparação para atacado (não implementar agora, mas não travar)
- Evitar nomes de tabela/coluna que assumam "cliente só pode ser varejo".
- Se for barato, incluir campo `customer_type` (default `retail`) em `customers` desde já.
- Não construir telas de atacado nem regras de preço por cliente no MVP.

## Critérios de sucesso do MVP
- Fluxo completo do catálogo ao pagamento aprovado, testado ponta a ponta.
- Zero venda duplicada de peça única (testar compra simultânea).
- Checkout simples e responsivo no mobile.
- Painel administrativo operável pela equipe sem suporte técnico constante.
- Arquitetura pronta para atacado sem reescrita.

## Dependências externas ainda em aberto
Não travar o desenvolvimento nelas, mas sinalizar quando chegarem perto:
- Provedor de frete definitivo
- Credenciais Mercado Pago (sandbox primeiro)
- Configuração do OAuth Google
- Pesos/medidas reais dos produtos (crítico para frete)
- Identidade visual final (logo, paleta, fontes)
- Definição de quais produtos são peça única vs. imagem ilustrativa
