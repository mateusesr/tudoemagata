# Tudo em Ágata — Plataforma de Vendas (MVP Varejo)

E-commerce próprio (Laravel + Filament) da Tudo em Ágata, focado em venda varejo direta ao consumidor. Para entender as regras de negócio e o escopo completo, leia [`escopo.MD`](escopo.MD). Para o resumo operacional do estado atual do projeto, veja [`CLAUDE.md`](CLAUDE.md).

## Stack

- Laravel 13 (PHP 8.3)
- Breeze (auth tradicional) + Socialite (login Google)
- Filament (painel administrativo)
- Blade + Tailwind CSS
- MySQL 8
- Docker / Docker Compose

## Rodando o projeto localmente (Docker)

Pré-requisitos: Docker e Docker Compose instalados.

### 1. Clonar e configurar o `.env`

```bash
git clone git@github.com:mateusesr/tudoemagata.git
cd tudoemagata
cp .env.example .env
```

O `.env.example` já vem configurado para o ambiente Docker deste projeto (`DB_HOST=db`, credenciais do MySQL do `docker-compose.yml`). Não é necessário alterar nada para rodar localmente.

### 2. Subir os containers

```bash
docker compose up -d
```

Isso sobe três serviços:

| Serviço            | Container         | Porta local |
|--------------------|-------------------|-------------|
| App (PHP-FPM)      | `mvparejo_app`    | —           |
| Nginx              | `mvparejo_nginx`  | `8091`      |
| MySQL 8            | `mvparejo_db`     | `3308`      |

O container `node` (para `npm run dev`) só sobe sob demanda, via profile `assets` (veja passo 5).

### 3. Instalar dependências PHP e gerar a chave da aplicação

```bash
docker exec mvparejo_app composer install
docker exec mvparejo_app php artisan key:generate
```

### 4. Rodar as migrations e popular o banco com dados de exemplo

```bash
docker exec mvparejo_app php artisan migrate:fresh --seed
```

O seeder cria categorias (peças únicas, decoração, presentes, lavabo) e produtos de exemplo cobrindo os 4 tipos do catálogo: produto padrão, com variação, peça única e kit.

### 5. Instalar dependências JS e compilar assets

```bash
docker exec mvparejo_app npm install
docker exec mvparejo_app npm run build
```

Para desenvolvimento com hot-reload, use o container `node` do compose (profile `assets`):

```bash
docker compose --profile assets up -d node
```

Isso expõe o Vite dev server em `http://localhost:5173`.

### 6. Criar um usuário administrador (Filament)

```bash
docker exec -it mvparejo_app php artisan make:filament-user
```

Siga o prompt interativo para definir nome, e-mail e senha.

### 7. Acessar a aplicação

- **Site público**: http://localhost:8091
- **Login / cadastro**: http://localhost:8091/login
- **Painel administrativo**: http://localhost:8091/admin/login

### Comandos úteis do dia a dia

Todos os comandos `artisan` e `composer` rodam dentro do container `mvparejo_app`:

```bash
docker exec mvparejo_app php artisan migrate
docker exec mvparejo_app php artisan tinker
docker exec mvparejo_app composer require <pacote>
docker exec mvparejo_app php artisan test
```

Para parar os containers:

```bash
docker compose down
```

Para parar e apagar também os dados do banco (reset completo):

```bash
docker compose down -v
```

## Rodando sem Docker (PHP local)

Se preferir rodar com PHP instalado localmente em vez de Docker, ajuste o `.env` para apontar para um MySQL acessível (ou SQLite, criando `database/database.sqlite` e usando `DB_CONNECTION=sqlite`), e siga os mesmos passos de `composer install`, `php artisan migrate --seed`, `npm install && npm run build`.

## Estrutura do projeto

Veja [`CLAUDE.md`](CLAUDE.md) para o estado atual do schema, regras de negócio não-negociáveis (peça única, reserva de estoque, snapshot de pedido, etc.) e o que ainda falta implementar.
