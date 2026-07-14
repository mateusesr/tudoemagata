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
- Pagamento: Mercado Pago SDK oficial (Pix + cartão; sem boleto no MVP)
- Frete: camada `ShippingGateway` (interface própria) — provedor concreto (Melhor Envio/Frenet/Kangu/Braspress) ainda **depende de decisão do cliente** (ver dependências abaixo)
- Imagens: storage local em dev, S3-compatible em produção

## Estado atual do código (verificar antes de assumir)
Fase 0 (fundação) concluída:
- Schema completo do modelo conceitual (escopo 10.3) criado via migrations: `categories` (com subcategoria via `parent_id`), `products`, `product_variants`, `customers`, `social_accounts`, `customer_addresses`, `product_images`, `product_relations`, `tags`/`product_tag`, `carts`/`cart_items`, `orders`/`order_items` (com snapshot), `payments`, `shipments`, `inventory_reservations`, `stock_movements`, `settings`, `audit_logs`. Todas migrando limpo em MySQL.
- **Estoque/preço/peso vivem só em `ProductVariant`** — `Product` não tem mais `stock_quantity`/`price`/`is_unique` própria; todo produto vendável (mesmo "padrão") tem ao menos 1 variante. `Product.type` é enum (`standard`/`variant`/`unique`/`kit`).
- Models Eloquent com relacionamentos criados para todas as tabelas acima.
- Breeze (stack Blade) instalado e funcionando. Socialite instalado com `GoogleAuthController` (`app/Http/Controllers/Auth/GoogleAuthController.php`) vinculando login Google por e-mail em `social_accounts` — falta só preencher `GOOGLE_CLIENT_ID`/`SECRET` reais no `.env`.
- Filament instalado, painel ativo em `/admin` (cor primária âmbar). Ainda **sem nenhum Resource criado** — CRUDs de produto/pedido/estoque etc. são o próximo passo.
- Ambiente local roda via Docker (`docker-compose.yml`): container `mvparejo_app` (PHP 8.3 + intl/gd/zip/bcmath), `mvparejo_db` (MySQL 8, porta 3308), `mvparejo_nginx` (porta 8091). `.env` já aponta para `DB_HOST=db` (nome do serviço docker, não `127.0.0.1`). Rodar comandos artisan/composer via `docker exec mvparejo_app ...`.
- Falta ainda: seeders de catálogo de exemplo, páginas públicas (home/categoria/produto/busca), área do cliente, carrinho/checkout, integração Mercado Pago, `ShippingGateway`, Filament Resources.

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
