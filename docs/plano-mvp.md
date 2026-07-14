# Plano de execução do MVP

## 1. Visão do projeto
O MVP deve entregar uma loja varejo própria da Tudo em Ágata, com experiência premium, catálogo bem estruturado, carrinho, checkout, pagamento, frete, pedidos, estoque e painel administrativo.

## 2. Escopo inicial priorizado
### Fase 1 - Fundação
- estrutura do projeto
- autenticação e cadastro
- modelos de usuário, produto, variação e estoque
- configuração inicial de admin

### Fase 2 - Catálogo e vitrine
- home
- categorias e listagem
- página de produto
- variações, selos, estoque e imagens
- SEO básico

### Fase 3 - Compra
- carrinho
- checkout com login obrigatório
- cálculo de frete
- integração com Mercado Pago
- confirmação de pedido

### Fase 4 - Operação
- painel administrativo
- gestão de pedidos e estoque
- baixa manual para vendas externas
- área do cliente com histórico e detalhes

### Fase 5 - Polimento e lançamento
- ajustes de UX/UI
- testes de fluxos críticos
- validação de mobile
- preparação para go-live

## 3. Backlog inicial
### Essencial
- cadastro e login tradicional
- login com Google
- catálogo público com produtos e variações
- peças únicas com regra especial
- carrinho persistente
- checkout com dados de cliente e endereço
- pagamento via Mercado Pago
- pedidos com status
- controle de estoque
- painel administrativo básico

### Importante
- frete com provedor desacoplado
- recomendações manuais
- páginas institucionais e políticas
- mensagens de erro claras
- rastreio e comunicação básica

## 4. Regras de negócio chave
- venda somente varejo no MVP
- estoque deve ser protegido para produtos unitários
- baixa automática só após pagamento aprovado
- reserva temporária para itens críticos
- frete indisponível deve bloquear fechamento automático e orientar contato

## 5. Critérios de aceite por módulo
### Catálogo
- produto com imagem, preço, descrição e disponibilidade
- variações com estoque próprio
- peça única devidamente identificada

### Checkout
- login ou cadastro obrigatório para finalizar compra
- resumo do pedido exibido antes do pagamento
- pagamento aprovado altera status do pedido

### Admin
- cadastro e edição de produto
- alteração de estoque
- visualização e atualização de pedidos

## 6. Próximo passo recomendado
Começar pela implementação da base de dados e do fluxo de catálogo, pois isso permite validar rapidamente os principais cenários de negócio antes de avançar para pagamento e integrações.
