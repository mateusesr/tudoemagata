ESCOPO DE PROJETO
Plataforma Própria de Vendas - MVP Varejo
Tudo em Ágata
Documento consolidado a partir da proposta, apresentação, briefing técnico, atualização estratégica do projeto e diretrizes visuais observadas no Instagram da marca.
Campo
Definição
Cliente
Tudo em Ágata
Projeto
E-commerce próprio com gestão de catálogo, carrinho, pagamento, frete, pedidos, estoque, experiência visual premium e painel administrativo.
Versão
1.1 - Escopo atualizado para MVP Varejo com UX/UI e regras de produto de ágata
Data
Julho de 2026
Elaboração
EKLO Digital
 
Decisão central do novo escopo
O MVP será focado exclusivamente em venda varejo. As regras de atacado, pedido mínimo, preço atacado e aprovação de lojistas não serão implementadas no lançamento. A arquitetura, porém, será preparada para expansão futura sem exigir reconstrução do sistema. O login com Google faz parte do MVP.
 

Sumário
● 1. Resumo executivo
● 2. Contexto do projeto e mudança estratégica
● 3. Definição do produto: e-commerce customizado, não SaaS
● 4. Objetivos do projeto
● 5. Escopo do MVP Varejo
● 6. Direção de produto, UX/UI e design system
● 7. Jornada do cliente e fluxo operacional
● 8. Requisitos funcionais detalhados
● 9. Requisitos não funcionais
● 10. Arquitetura, stack e modelagem de dados
● 11. Integrações
● 12. Painel administrativo
● 13. Entregáveis
● 14. Fora de escopo e fase 2
● 15. Dependências do cliente
● 16. Cronograma sugerido
● 17. Critérios de aceite
● 18. Riscos, premissas e governança
● 19. Apêndices técnicos e operacionais

1. Resumo executivo
Este documento define o escopo técnico, funcional e visual da Plataforma Própria de Vendas da Tudo em Ágata. O projeto será desenvolvido como um e-commerce customizado, com foco inicial em venda varejo, permitindo ao cliente final navegar pelo catálogo, selecionar produtos, adicionar itens ao carrinho, calcular frete, realizar pagamento via Mercado Pago e acompanhar seus pedidos em uma área autenticada.
A versão anterior do projeto contemplava dois ambientes comerciais: varejo e atacado. A atualização estratégica retira o atacado do MVP, eliminando do lançamento funcionalidades como preço atacado, pedido mínimo, aprovação de lojistas e área exclusiva B2B. Mesmo assim, a estrutura técnica será pensada para receber essas funcionalidades em fase futura sem comprometer a base atual.
Além das funções essenciais de venda, esta versão do escopo adiciona diretrizes de experiência de compra, design visual, regras para peças únicas, recomendações de produtos, estados de erro, SEO operacional e critérios de aceite por tela. O objetivo é reduzir ambiguidades para desenvolvimento por equipe técnica, programador sênior ou IA assistida.
Resumo do novo MVP
Um e-commerce próprio de varejo, com login do cliente, login com Google, catálogo com variações, peças únicas, carrinho, checkout, Mercado Pago, cálculo de frete, controle de estoque, reserva temporária para itens críticos, painel administrativo, experiência visual premium e preparação arquitetural para atacado no futuro.
 
1.1 Visão executiva do escopo
Tipo de projeto
Definição
Tipo de projeto
E-commerce próprio customizado, single-tenant, desenvolvido sob medida para a operação da Tudo em Ágata.
Foco do MVP
Venda varejo direta ao consumidor final.
Atacado no MVP
Não contemplado no lançamento. Será mantido como possibilidade de expansão futura.
Cadastro do cliente
Obrigatório para finalização da compra, com login tradicional e login com Google.
Pagamento
Mercado Pago, priorizando Pix e cartão de crédito.
Frete
Integração a definir entre hub logístico ou transportadora específica, com arquitetura desacoplada para troca futura.
Estoque
Controle por SKU/variação, baixa automática após confirmação de pagamento, baixa manual para vendas externas e reserva temporária quando aplicável.
Produto de ágata
Suporte a produto padrão, produto com variação e peça única fotografada individualmente.
Nota fiscal
Emissão manual, fora do sistema, pela equipe da Tudo em Ágata.
Painel administrativo
Gerenciamento de produtos, variações, imagens, estoque, pedidos, vendas externas, clientes, SEO básico, recomendações manuais e configurações.
Visual do site
Sofisticado, natural, premium, limpo e alinhado ao universo de ágatas, pedras naturais, decoração para casa e presentes.
 
1.2 Decisões fechadas nesta versão
● O login com Google será incluído no MVP, junto com login tradicional por e-mail e senha.
● A reserva temporária de estoque será tratada como essencial para peças únicas e itens de estoque unitário.
● As recomendações de produto no MVP serão manuais ou baseadas em regras simples, não por algoritmo avançado.
● O Mercado Livre será usado como referência de usabilidade e confiança, não como referência visual.
● O visual seguirá uma linha premium, artesanal e natural, com inspiração na identidade observada no Instagram da Tudo em Ágata.
● O checkout deve priorizar segurança e previsibilidade. A experiência pode usar fluxo oficial do Mercado Pago, desde que pedido, webhook e status sejam corretamente registrados.
● O fallback padrão para frete indisponível será impedir fechamento automático e orientar contato pelo WhatsApp, salvo decisão comercial diferente antes do desenvolvimento.
2. Contexto do projeto e mudança estratégica
A Tudo em Ágata possui uma operação consolidada, com tradição na produção e comercialização de pedras naturais. O canal atual é fortemente apoiado em atendimento manual, especialmente via WhatsApp, o que gera proximidade com o cliente, mas limita escala, padronização, controle de estoque, cálculo de frete e acompanhamento de pedidos.
O projeto digital tem como finalidade transformar parte desse atendimento manual em um canal estruturado de vendas, permitindo que o site assuma tarefas repetitivas e operacionais: apresentação do catálogo, coleta dos dados do cliente, montagem do pedido, cálculo de frete, pagamento, registro do pedido e atualização de estoque.
Pelo posicionamento visual observado nos canais da marca, o site não deve se comportar apenas como uma loja funcional. Ele deve transmitir curadoria, exclusividade, tradição, acabamento artesanal, confiança e desejo de compra. A operação envolve decoração para casa, presentes, peças de ágata, pedras naturais e produtos com forte apelo visual.
2.1 O que mudou em relação ao escopo anterior
Item
Escopo anterior
Novo escopo MVP
Ambientes comerciais
Varejo + Atacado
Somente Varejo
Preço atacado
Previsto para lojistas
Não implementar no MVP
Pedido mínimo
R$ 800,00 no atacado
Não existe no MVP
Cadastro B2B
Cadastro + aprovação de lojista
Não existe no MVP
Área do lojista
Prevista
Fase futura
Cliente varejo
Compra B2C
Compra B2C com login obrigatório
Login Google
Ponto a validar
Incluído no MVP
Peças únicas
Tratadas de forma genérica
Tratadas como regra central do catálogo e estoque
Experiência visual
Pouco especificada
Incluída como requisito de produto e critérios de aceite
Expansão futura
B2B nativo
Arquitetura preparada para B2B em fase 2
 
2.2 Princípio de decisão
O projeto deve entregar o necessário para vender no varejo com segurança e boa experiência, evitando complexidade prematura. Ao mesmo tempo, as decisões estruturais de banco de dados, permissões, produtos, preços e clientes não devem impedir a implementação futura do atacado.
Sempre que houver dúvida entre adicionar uma funcionalidade avançada ou melhorar a clareza da compra, a prioridade do MVP deve ser: vender bem, vender com segurança, evitar erro de estoque, evitar erro de frete e permitir operação administrativa simples.
3. Definição do produto: e-commerce customizado, não SaaS
Para fins técnicos e comerciais, o projeto deve ser tratado como uma plataforma própria de vendas, desenvolvida sob medida para uma única empresa. Ele não é um SaaS em sentido estrito, pois não será uma solução multiempresa vendida como serviço padronizado para vários clientes.
A existência de manutenção mensal ou percentual sobre faturamento não transforma a arquitetura em SaaS. Esses elementos dizem respeito ao modelo comercial de suporte e evolução. Tecnicamente, o sistema será um e-commerce customizado single-tenant, com código, regras e operação direcionados à Tudo em Ágata.
3.1 Posicionamento recomendado
● Nome interno recomendado: Plataforma Própria de Vendas Tudo em Ágata.
● Nome comercial recomendado: E-commerce próprio com gestão de pedidos, estoque e frete.
● Descrição objetiva: canal digital de vendas varejo com catálogo, carrinho, pagamento, frete, painel administrativo e experiência visual premium.
● Evitar chamar de SaaS para o cliente, para não gerar expectativa de produto genérico, multiempresa ou recorrência de licença.
3.2 Natureza comercial do produto
O site deve ser tratado como um ativo próprio da marca, não apenas como vitrine. A experiência precisa conduzir o cliente da descoberta à compra com clareza, confiança e desejo. Para isso, o desenvolvimento deve considerar tanto a estrutura técnica quanto a narrativa visual de produto.
4. Objetivos do projeto
4.1 Objetivo principal
Criar uma plataforma própria de e-commerce varejo para a Tudo em Ágata, capaz de reduzir a dependência de vendas manuais pelo WhatsApp, organizar pedidos, controlar estoque, calcular frete, receber pagamentos, permitir acompanhamento pelo cliente e apresentar os produtos com uma experiência visual compatível com o posicionamento da marca.
4.2 Objetivos específicos
● Disponibilizar um catálogo digital de produtos com categorias, fotos, descrições, variações e selos comerciais.
● Permitir compra direta no site por clientes varejo autenticados.
● Incluir login tradicional e login com Google.
● Coletar dados essenciais do comprador, incluindo nome, e-mail, telefone, CPF e endereço.
● Integrar pagamento via Mercado Pago, priorizando Pix e cartão de crédito.
● Integrar cálculo de frete por provedor definido durante o projeto.
● Controlar estoque por SKU/variação e bloquear compra acima do estoque disponível.
● Garantir proteção especial para peças únicas e produtos de estoque unitário.
● Registrar pedidos no painel administrativo para separação, faturamento manual e expedição.
● Permitir baixa manual de estoque para vendas externas realizadas fora do site.
● Permitir recomendações manuais ou por regra simples, como produtos semelhantes e combinações.
● Criar páginas com estética sofisticada, natural, intuitiva e mobile-first.
● Preparar a arquitetura para futura inclusão de atacado, regras comerciais, preços especiais e aprovação de lojistas.
4.3 Indicadores de sucesso
Indicador
Como medir
Meta inicial sugerida
Funcionamento do fluxo de compra
Testes ponta a ponta do produto ao pagamento aprovado.
100% dos cenários críticos aprovados antes do go-live.
Redução de atendimento manual
Volume de pedidos concluídos sem orçamento manual prévio.
Acompanhar no primeiro mês pós-lançamento.
Consistência de estoque
Comparação entre estoque físico e estoque no sistema.
Divergências tratadas por rotina operacional.
Proteção de peças únicas
Testes de compra simultânea e reserva temporária.
Nenhuma venda duplicada de produto unitário.
Experiência mobile
Teste em dispositivos móveis e resolução de problemas visuais.
Páginas principais responsivas e utilizáveis.
Qualidade visual
Revisão de home, categoria, produto e checkout contra diretriz visual aprovada.
Layout aprovado antes da implementação completa.
Operação administrativa
Equipe consegue cadastrar produto, alterar estoque, relacionar produtos e processar pedido.
Treinamento e simulação aprovados.
 
5. Escopo do MVP Varejo
O MVP corresponde à primeira versão funcional da plataforma, suficiente para operar vendas varejo com segurança. O foco é entregar o ciclo completo de compra, pagamento, registro do pedido e controle de estoque, sem incluir as regras de atacado previstas na visão inicial.
5.1 Módulos contemplados
Módulo
Descrição
Site público
Home, catálogo varejo, categorias, produto, sobre, contato e políticas.
UX/UI e design system
Direção visual premium, componentes consistentes, mobile-first, padrões de cards, botões, selos e estados de interação.
Autenticação
Login, cadastro, recuperação de senha e login com Google.
Área do cliente
Histórico de pedidos, detalhes do pedido, dados cadastrais e endereços.
Catálogo
Produtos com variações, imagens, estoque, preço, descrição, status, selos, SEO e tipo de produto.
Peças únicas
Produtos unitários com imagem real, selo de peça única, estoque unitário e reserva temporária.
Carrinho
Adicionar, remover, alterar quantidade, validar estoque e manter persistência por sessão/usuário.
Checkout
Dados do cliente, endereço, frete, pagamento e confirmação.
Pagamento
Mercado Pago com atualização de status via webhook.
Frete
Cálculo por provedor definido, com armazenamento da opção selecionada.
Pedidos
Registro completo do pedido, itens, cliente, pagamento, frete e status operacional.
Estoque
Controle por SKU, baixa automática, movimentações manuais e histórico.
Recomendações
Relacionamento manual ou por regra simples entre produtos, categorias e combinações.
Admin
Painel Filament para operação diária do cliente.
Tracking
Meta Pixel e Google Analytics/Tag Manager se definidos no lançamento.
Comunicação
E-mails transacionais básicos conforme configuração de envio.
 
5.2 Perfis de usuário
Perfil
Descrição
Permissões principais
Visitante
Pessoa não autenticada navegando pelo site.
Visualizar páginas públicas, catálogo e produtos ativos.
Cliente varejo
Comprador cadastrado/autenticado.
Comprar, acompanhar pedidos, gerenciar endereços e dados cadastrais.
Admin operacional
Equipe da Tudo em Ágata.
Gerenciar produtos, estoque, pedidos, clientes, vendas externas, imagens, status e rastreios.
Super Admin
Responsável técnico/EKLO.
Acesso total, configurações, permissões, integrações e manutenção.
 
5.3 Tipos de produto no MVP
Tipo
Uso
Regra principal
Produto padrão
Itens com estoque múltiplo e imagem representativa.
Deve informar quando a imagem for ilustrativa.
Produto com variação/SKU
Itens com variações de tamanho, cor, peso, acabamento ou medida.
Cada variação deve possuir preço, estoque, peso e medidas próprios quando necessário.
Peça única
Item vendido individualmente, em que o cliente compra exatamente a peça fotografada.
Estoque unitário, selo visível, reserva temporária e bloqueio de compra duplicada.
Kit ou conjunto
Produto composto por mais de um item vendido como pacote.
Pode ter estoque próprio no MVP; composição detalhada pode ficar para fase futura se necessário.
 
6. Direção de produto, UX/UI e design system
Esta seção transforma a identidade observada da Tudo em Ágata em requisitos práticos de interface. O objetivo é evitar que o sistema seja funcional, porém genérico. O site deve parecer uma loja própria de pedras naturais e decoração, com percepção de sofisticação, cuidado artesanal e confiança.
6.1 Posicionamento visual desejado
● Sofisticado, mas não frio.
● Artesanal, mas não amador.
● Natural, mas com acabamento premium.
● Intuitivo, mas não parecido com marketplace genérico.
● Comercial, mas sem poluição visual.
● Inspirado no universo de ágatas, pedras naturais, decoração, presentes e peças exclusivas.
6.2 Paleta e atmosfera visual
A paleta deve ser definida com base nos materiais finais de identidade visual, mas a direção recomendada para o MVP é: marrom ágata, café, bege quente, off-white, dourado suave, terracota e verde escuro pontual. A interface deve usar fundos claros e quentes, bastante respiro, sombras suaves e detalhes discretos em dourado ou marrom.
O site deve evitar aparência muito colorida, agressiva ou promocional demais. Produtos com pedras coloridas já possuem bastante informação visual; por isso, a estrutura deve ser limpa para valorizar as fotos.
6.3 Tipografia
● Títulos: fonte serifada elegante ou fonte com personalidade editorial, desde que tenha boa leitura no mobile.
● Textos, preços, botões e formulários: fonte sans-serif limpa, legível e neutra.
● A hierarquia deve diferenciar claramente: título de página, nome do produto, preço, variação, frete, CTA e informações auxiliares.
● Não usar excesso de fontes. O ideal é trabalhar com no máximo dois estilos tipográficos principais.
6.4 Fotografia e apresentação de produto
● Priorizar fotos claras, com boa nitidez, fundo neutro ou contexto de uso real: mesa, lavabo, decoração, presente, ambiente de casa.
● Para peças únicas, a foto deve representar exatamente o item vendido.
● Para produtos com imagem ilustrativa, o site deve exibir aviso claro: imagem ilustrativa; variações naturais podem ocorrer.
● A galeria do produto deve permitir ver detalhes, escala, textura, acabamento e, quando possível, ambiente de uso.
● Evitar fotos escuras, poluídas, com excesso de texto ou com baixa nitidez.
6.5 Referências conceituais permitidas
Referência
Como usar
Como não usar
Mercado Livre / Andes
Usar como referência de clareza, confiança, hierarquia de compra, avaliações de fluxo e padrões de usabilidade.
Não copiar estética, cores ou sensação de marketplace popular.
Shopify Polaris
Usar como referência conceitual para organização de painel administrativo, consistência de componentes e clareza operacional.
Não transformar o site público em aparência de painel SaaS.
E-commerces premium de decoração
Usar como referência de respiro visual, fotografia, curadoria e composição de página.
Não criar layout difícil de comprar ou bonito demais sem clareza comercial.
Instagram da Tudo em Ágata
Usar como base para tom visual, cores, logo, materiais, estilo das peças e narrativa da marca.
Não replicar post estático dentro do site; o site precisa ser mais funcional e navegável.
 
6.6 Princípios de UX obrigatórios
● Mobile-first: todas as decisões devem priorizar compra pelo celular.
● Compra clara: botão principal sempre evidente, com preço, variação e disponibilidade próximos.
● Confiança antes do pagamento: mostrar frete, prazo, política de troca, segurança de pagamento e canais de atendimento.
● Poucos passos: o checkout deve ser direto, sem formulários desnecessários.
● Produto valorizado: fotos grandes, galeria fácil, descrições objetivas e recomendações contextuais.
● Erro compreensível: qualquer falha de frete, pagamento, estoque ou formulário deve ter mensagem humana e próxima ação clara.
6.7 Componentes visuais principais
Componente
Diretriz
Botão primário
Usar para compra, checkout e ações principais. Deve ter contraste alto e texto objetivo.
Botão secundário
Usar para continuar comprando, ver detalhes, calcular frete e ações auxiliares.
Card de produto
Imagem dominante, nome curto, preço, selo quando necessário e CTA discreto.
Selo de produto
Peça única, lançamento, destaque, imagem ilustrativa, produção própria ou esgotado.
Bloco de confiança
Envio para todo Brasil, produção própria, mais de 30 anos, pagamento seguro e atendimento pelo WhatsApp.
Breadcrumb
Usar em categoria e produto para orientar navegação.
Busca
Visível e simples, com retorno amigável quando não houver resultado.
Variações
Devem parecer selecionáveis de forma clara, com estado ativo, indisponível e erro.
Avisos
Textos curtos, sem linguagem técnica, orientando o próximo passo.
Recomendações
Blocos como combine com, peças semelhantes e mais da mesma pedra.
 
7. Jornada do cliente e fluxo operacional
7.1 Jornada do cliente varejo
1. Cliente acessa o site da Tudo em Ágata.
2. Entra pela home, categoria, busca, link de produto ou campanha de redes sociais.
3. Navega por categorias, destaques, peças únicas, decoração para casa, presentes ou busca.
4. Abre a página de produto e entende se é peça única, produto padrão ou item com variação.
5. Visualiza fotos, preço, descrição, disponibilidade, medidas, peso aproximado quando aplicável e informações de compra.
6. Seleciona produto e variação quando aplicável: tamanho, cor, peso, acabamento, medida ou opção equivalente.
7. Adiciona item ao carrinho.
8. Visualiza recomendações como combine com, peças semelhantes ou mais da mesma pedra.
9. Revisa quantidades, subtotal e disponibilidade.
10. Inicia o checkout.
11. Faz login, cria conta ou entra com Google.
12. Informa ou confirma dados pessoais e endereço de entrega.
13. Seleciona opção de frete disponível.
14. Realiza pagamento via Mercado Pago.
15. Recebe confirmação do pedido.
16. Acompanha o status na área do cliente.
7.2 Fluxo operacional da equipe
17. Pedido é criado no sistema com status de pagamento pendente.
18. Quando aplicável, estoque fica reservado temporariamente durante o fluxo de pagamento.
19. Mercado Pago envia confirmação por webhook quando o pagamento é aprovado.
20. Sistema atualiza o pedido para pago e registra a movimentação definitiva de estoque.
21. Equipe visualiza o pedido no painel administrativo.
22. Equipe emite nota fiscal manualmente fora do sistema.
23. Equipe separa e embala o pedido.
24. Equipe registra dados de envio ou rastreamento quando disponíveis.
25. Cliente acompanha o status pela área do cliente e/ou recebe comunicação conforme definido.
26. Vendas externas feitas pelo WhatsApp, Instagram ou presencialmente são registradas no admin para baixa manual de estoque.
7.3 Regra de autenticação
Regra aprovada para o MVP
O cliente precisa estar autenticado para finalizar a compra. A criação da conta deve acontecer de forma fluida no checkout, sem criar barreira desnecessária antes da escolha dos produtos. O login com Google será incluído no MVP.
 
● O visitante pode navegar pelo catálogo sem login.
● Para finalizar compra, o cliente deve fazer login, criar conta ou entrar com Google.
● CPF, telefone e endereço serão solicitados para fechamento do pedido, não como chave primária do banco.
● A identificação técnica do usuário será feita por ID interno, preservando flexibilidade e segurança.
8. Requisitos funcionais detalhados
Os requisitos funcionais descrevem o que o sistema deve permitir que usuários, clientes e administradores façam. Abaixo estão organizados por módulo.
8.1 Site público e conteúdo institucional
Código
Requisito
Descrição
Prioridade
RF-001
Home
Página inicial com posicionamento da marca, destaques de categorias, benefícios, chamadas para compra, peças únicas, recomendações e links para contato.
Essencial
RF-002
Sobre
Página institucional apresentando tradição, produção própria, qualidade, acabamento e confiança da marca.
Essencial
RF-003
Contato
Informações de WhatsApp, Instagram, e-mail e demais canais definidos.
Essencial
RF-004
Políticas
Páginas de envio, troca/devolução, privacidade e termos de uso.
Essencial
RF-005
SEO básico
URLs amigáveis, títulos, descrições e estrutura HTML adequada para indexação.
Importante
RF-006
Blocos de confiança
Exibir informações de segurança, envio, atendimento, produção própria e tradição da marca.
Essencial
RF-007
Direção visual
Aplicar identidade visual premium, natural, sofisticada e coerente com a marca.
Essencial
 
8.2 Autenticação e cadastro
Código
Requisito
Descrição
Prioridade
RF-010
Cadastro varejo
Permitir criação de conta com nome, e-mail, telefone, CPF e senha.
Essencial
RF-011
Login tradicional
Permitir login com e-mail e senha.
Essencial
RF-012
Login com Google
Permitir autenticação por conta Google, vinculando o provedor ao usuário interno.
Essencial
RF-013
Recuperar senha
Permitir recuperação de senha por e-mail.
Essencial
RF-014
Cadastro no checkout
Permitir criação/identificação da conta dentro do fluxo de checkout.
Essencial
RF-015
Dados pessoais
Permitir atualização de nome, telefone, CPF quando aplicável e e-mail conforme regra definida.
Importante
RF-016
Validações humanas
Exibir mensagens claras para CPF inválido, e-mail já usado, senha fraca ou falha no login Google.
Importante
 
8.3 Área do cliente
Código
Requisito
Descrição
Prioridade
RF-020
Meus pedidos
Listar pedidos realizados pelo cliente autenticado.
Essencial
RF-021
Detalhe do pedido
Exibir itens, valores, frete, endereço, pagamento e status operacional.
Essencial
RF-022
Endereços
Permitir cadastrar, editar e selecionar endereço principal.
Essencial
RF-023
Rastreio
Exibir código ou link de rastreio quando informado pela equipe.
Importante
RF-024
Solicitação de suporte
Disponibilizar contato para dúvidas, reclamações, trocas ou devoluções.
Importante
RF-025
Recompra/continuidade
Permitir que o cliente volte ao produto comprado quando ele ainda estiver ativo, sem prometer disponibilidade.
Desejável
 
8.4 Catálogo, produtos e variações
Código
Requisito
Descrição
Prioridade
RF-030
Categorias
Permitir organização dos produtos em categorias e subcategorias quando necessário.
Essencial
RF-031
Listagem
Exibir produtos ativos com imagem, nome, preço e chamada de compra.
Essencial
RF-032
Busca
Buscar produtos por nome, termo, palavra-chave, pedra, cor, uso ou categoria.
Essencial
RF-033
Filtros
Filtrar por categoria e atributos definidos como pedra, cor, preço, tamanho, peso, uso ou tipo.
Importante
RF-034
Produto
Página detalhada com galeria, descrição, preço, variações, estoque, selos, medidas e botão de compra.
Essencial
RF-035
Variações/SKUs
Cada produto pode ter variações configuráveis com estoque, preço, peso e medidas próprios.
Essencial
RF-036
Produto único
Suportar peças únicas com foto individual, selo próprio e estoque unitário.
Essencial
RF-037
Foto padrão
Suportar produtos simples vendidos com imagem ilustrativa e estoque múltiplo.
Essencial
RF-038
Aviso de imagem
Informar quando o cliente recebe exatamente a peça da foto ou quando a imagem é ilustrativa.
Essencial
RF-039
Selos comerciais
Permitir selos como peça única, destaque, lançamento, esgotado, imagem ilustrativa e produção própria.
Importante
 
8.5 Carrinho
Código
Requisito
Descrição
Prioridade
RF-040
Adicionar item
Adicionar produto/variação ao carrinho.
Essencial
RF-041
Editar quantidade
Alterar quantidade respeitando estoque disponível.
Essencial
RF-042
Remover item
Remover item do carrinho.
Essencial
RF-043
Totais
Calcular subtotal, frete quando disponível e total final.
Essencial
RF-044
Validação de estoque
Bloquear quantidade maior que o estoque disponível.
Essencial
RF-045
Persistência
Manter carrinho por sessão e vincular ao usuário quando autenticado.
Importante
RF-046
Carrinho vazio
Exibir mensagem amigável e atalhos para categorias ou produtos em destaque.
Importante
RF-047
Alteração de estoque
Avisar quando um item do carrinho ficar indisponível ou tiver quantidade reduzida antes do checkout.
Essencial
 
8.6 Checkout
Código
Requisito
Descrição
Prioridade
RF-050
Identificação
Exigir login/cadastro antes de concluir a compra.
Essencial
RF-051
Dados do comprador
Coletar nome, e-mail, telefone e CPF.
Essencial
RF-052
Endereço
Coletar endereço completo para entrega.
Essencial
RF-053
Frete
Calcular opções de entrega conforme provedor definido.
Essencial
RF-054
Revisão
Exibir resumo do pedido antes do pagamento.
Essencial
RF-055
Criação do pedido
Criar pedido com status pendente antes do pagamento.
Essencial
RF-056
Confirmação
Exibir mensagem de pedido recebido/pago conforme retorno do pagamento.
Essencial
RF-057
Fallback de frete
Quando frete não puder ser calculado, impedir fechamento automático e orientar contato pelo WhatsApp, salvo regra comercial diferente.
Importante
RF-058
Compra mobile
Checkout deve ser simples no celular, com campos claros e sem etapas desnecessárias.
Essencial
 
8.7 Pagamento
Código
Requisito
Descrição
Prioridade
RF-060
Mercado Pago
Integrar pagamento por Mercado Pago.
Essencial
RF-061
Pix
Permitir pagamento via Pix.
Essencial
RF-062
Cartão
Permitir pagamento via cartão de crédito.
Essencial
RF-063
Webhook
Receber notificações de pagamento aprovado, recusado ou cancelado.
Essencial
RF-064
Status
Atualizar status do pedido conforme retorno do pagamento.
Essencial
RF-065
Expiração
Tratar pedidos Pix não pagos ou pagamentos expirados.
Importante
RF-066
Auditoria de pagamento
Registrar payload ou eventos relevantes para suporte e conciliação.
Importante
RF-067
Pagamento recusado
Exibir orientação clara e permitir nova tentativa quando tecnicamente viável.
Importante
 
8.8 Frete
Código
Requisito
Descrição
Prioridade
RF-070
Cotação
Calcular frete com base em endereço, peso, medidas e provedor logístico.
Essencial
RF-071
Escolha da opção
Permitir que o cliente escolha entre opções retornadas, se houver mais de uma.
Essencial
RF-072
Registro
Salvar transportadora, prazo, valor e informações da cotação no pedido.
Essencial
RF-073
Abstração
Implementar camada de frete desacoplada para facilitar troca de provedor.
Essencial
RF-074
Fallback operacional
Definir comportamento quando o frete não puder ser calculado. Padrão: orientar contato e não fechar automaticamente.
Importante
RF-075
Peso e medidas por SKU
Permitir peso e medidas por variação, quando necessário.
Essencial
RF-076
Mensagem de prazo
Informar que prazo de entrega depende da confirmação de pagamento e operação logística.
Importante
 
8.9 Pedidos e estoque
Código
Requisito
Descrição
Prioridade
RF-080
Pedido
Registrar cliente, endereço, itens, valores, frete, pagamento e status.
Essencial
RF-081
Status
Gerenciar status como pendente, pago, em separação, enviado, concluído e cancelado.
Essencial
RF-082
Baixa automática
Baixar estoque somente após confirmação de pagamento aprovado.
Essencial
RF-083
Venda externa
Permitir registrar venda fora do site com baixa manual de estoque.
Essencial
RF-084
Movimentações
Manter histórico de entradas, saídas, ajustes, reservas e baixas automáticas.
Essencial
RF-085
Bloqueio
Impedir compra acima do estoque disponível.
Essencial
RF-086
Reserva temporária
Reservar estoque durante o pagamento por tempo limitado, essencial para peças únicas e estoque unitário.
Essencial
RF-087
Liberação de reserva
Liberar reserva em caso de pagamento expirado, cancelado ou não concluído dentro do prazo definido.
Essencial
RF-088
Snapshot do pedido
Salvar nome, preço, variação, imagem e dados principais do produto no momento da compra.
Essencial
 
8.10 Experiência de compra e recomendações
Código
Requisito
Descrição
Prioridade
RF-090
Produtos relacionados
Permitir relacionamento manual entre produtos no admin.
Importante
RF-091
Combine com
Exibir produtos que combinam com o item atual, como bandejas, lavabos, porta-copos, difusores ou peças complementares.
Importante
RF-092
Peças semelhantes
Exibir produtos da mesma categoria, pedra, cor ou faixa de preço.
Importante
RF-093
Mais da mesma pedra
Exibir produtos com a mesma pedra ou estética, quando os dados existirem.
Desejável
RF-094
Vistos recentemente
Exibir histórico local de produtos vistos pelo cliente.
Desejável
RF-095
Categorias comerciais
Permitir blocos de navegação por uso: decoração, presentes, lavabo, mesa posta, peças únicas.
Importante
 
8.11 SEO, conteúdo e administrabilidade do catálogo
Código
Requisito
Descrição
Prioridade
RF-100
Slug
Permitir URL amigável para produto, categoria e páginas.
Importante
RF-101
Título SEO
Permitir título SEO editável no admin.
Importante
RF-102
Descrição SEO
Permitir meta description editável no admin.
Importante
RF-103
Alt text
Permitir texto alternativo para imagens principais e galerias.
Importante
RF-104
Descrição curta
Permitir resumo comercial curto para cards e topo da página do produto.
Importante
RF-105
Descrição completa
Permitir descrição detalhada com composição, uso, cuidado, medidas e observações naturais.
Essencial
RF-106
Tags internas
Permitir tags para busca, organização e recomendações simples.
Desejável
 
8.12 Estados, mensagens e exceções
Código
Estado
Comportamento esperado
Prioridade
RF-110
Busca sem resultado
Sugerir categorias, produtos em destaque e contato.
Importante
RF-111
Produto esgotado
Exibir como esgotado e bloquear compra. Pode sugerir semelhantes.
Essencial
RF-112
Frete indisponível
Explicar que não foi possível calcular e orientar contato pelo WhatsApp.
Importante
RF-113
Pagamento recusado
Exibir status sem linguagem técnica e orientar nova tentativa ou contato.
Importante
RF-114
Pix expirado
Atualizar pedido e liberar reserva/estoque quando aplicável.
Importante
RF-115
Webhook atrasado
Manter pedido pendente e permitir consulta/atualização segura posterior.
Importante
RF-116
Erro de formulário
Indicar campo com erro e mensagem objetiva.
Essencial
RF-117
Falha inesperada
Exibir mensagem amigável, registrar log e evitar perda de dados críticos.
Essencial
 
8.13 Requisitos visuais por tela
Tela
Obrigatório no MVP
Home
Hero com posicionamento da marca, categorias principais, peças únicas/destaques, decoração para casa, presentes, blocos de confiança, produção própria, chamada para WhatsApp e Instagram.
Categoria
Título claro, descrição curta, filtros, ordenação simples se viável, cards de produto e estado sem resultado.
Busca
Campo visível, resultados por relevância simples e sugestões quando não houver produto.
Produto
Galeria forte, selo de peça única ou imagem ilustrativa, nome, preço, variações, estoque, frete, descrição, medidas, cuidados, botão de compra, confiança e recomendações.
Carrinho
Resumo claro, editar quantidade, remover item, subtotal, frete quando disponível, continuar comprando e ir para checkout.
Checkout
Fluxo limpo, login/cadastro/Google, dados, endereço, frete, revisão e pagamento.
Área do cliente
Pedidos, detalhes, endereços e rastreio quando disponível.
Admin
CRUDs organizados, busca, filtros, status, campos obrigatórios e visão operacional simples.
 
9. Requisitos não funcionais
Os requisitos não funcionais definem padrões de qualidade, segurança, desempenho, manutenção, usabilidade e consistência visual da plataforma.
Categoria
Requisito
Diretriz
Performance
Páginas rápidas e leves
Usar SSR com Blade, imagens otimizadas, cache quando adequado e evitar SPA desnecessária.
Mobile-first
Experiência prioritária no celular
Todas as páginas essenciais devem funcionar bem em dispositivos móveis.
Segurança
Proteção básica da aplicação
CSRF, validações, rate limiting em login, permissões por perfil e tratamento de webhooks.
LGPD
Proteção de dados pessoais
Coletar apenas dados necessários e não usar CPF como chave primária técnica.
SEO
Indexação básica
URLs amigáveis, meta tags, estrutura semântica, alt text e carregamento adequado.
Manutenibilidade
Código organizado
Separar regras de negócio, integrações, componentes reutilizáveis e camadas de domínio.
Auditoria
Histórico de mudanças críticas
Registrar movimentações de estoque, reservas, alterações sensíveis e status de pedidos.
Backups
Proteção operacional
Hospedagem deve prever backup de banco e arquivos.
Escalabilidade
Preparação para crescimento
Modelagem preparada para múltiplas listas de preço, atacado futuro e evolução do catálogo.
Design consistency
Interface consistente
Componentes devem seguir padrões de cor, espaçamento, tipografia, botões, cards e estados.
Acessibilidade básica
Leitura e navegação
Contraste adequado, textos alternativos, foco visível em formulários e botões legíveis no mobile.
 
10. Arquitetura, stack e modelagem de dados
10.1 Stack recomendada
Camada
Tecnologia/Diretriz
Backend
Laravel MVC
Autenticação base
Laravel Breeze
Login social
Laravel Socialite para Google
Frontend
Blade + Tailwind CSS
Interatividade pontual
Alpine.js e/ou Livewire quando necessário
Painel administrativo
Filament
Banco de dados
MySQL
Pagamentos
Mercado Pago
Frete
Gateway desacoplado para Melhor Envio, Frenet, Kangu, Braspress ou outro provedor definido
Hospedagem
Servidor com SSL, backups, logs e ambiente compatível com Laravel
Imagens
Upload com otimização, formatos adequados e armazenamento organizado por produto/variação
Tracking
Meta Pixel e Google Analytics/Tag Manager conforme definição do projeto
 
10.2 Princípios de arquitetura
● Evitar acoplamento direto com uma única transportadora.
● Separar produto de variação/SKU.
● Separar autenticação de dados comerciais do cliente.
● Usar ID interno como chave primária, não CPF, telefone ou e-mail.
● Registrar pedidos com snapshot de dados importantes, como nome do produto, preço no momento da compra e variação selecionada.
● Manter registro de eventos de pagamento, estoque e status para auditoria.
● Tratar peça única como caso crítico de estoque.
● Manter o código preparado para futura inclusão de regras de atacado sem reconstruir o sistema.
● Priorizar entrega sólida do MVP antes de funcionalidades avançadas.
10.3 Modelo de dados conceitual
Entidade
Função
Observações
users
Autenticação e acesso ao sistema.
ID interno, nome, e-mail, senha, verificação.
customers
Dados comerciais do comprador.
Vinculado a users; CPF e telefone ficam aqui.
social_accounts
Vínculo com provedores externos.
Google ID e dados do provedor.
customer_addresses
Endereços do cliente.
Múltiplos endereços por cliente.
categories
Organização do catálogo.
Categoria e subcategoria se necessário.
products
Produto principal.
Nome, descrição, status, categoria, destaque, tipo de produto, slug e SEO.
product_variants
SKU vendável.
Preço, estoque, peso, medidas, cor, tamanho, peso comercial.
product_images
Imagens e galerias.
Imagem principal, galeria, imagem por variação, alt text e ordem.
product_relations
Relações comerciais entre produtos.
Combine com, semelhantes e produtos complementares.
product_tags
Tags internas de produto.
Apoio a busca, organização e recomendações simples.
inventory_reservations
Reservas temporárias.
Controle de reserva durante pagamento, especialmente para peça única.
carts
Carrinho do usuário/sessão.
Pode ser vinculado à sessão e depois ao usuário.
cart_items
Itens do carrinho.
Produto/variação e quantidade.
orders
Pedido principal.
Cliente, endereço, status, totais, frete e pagamento.
order_items
Itens comprados.
Snapshot de produto, variação, preço, imagem e quantidade.
payments
Informações de pagamento.
Mercado Pago ID, status, método e payload relevante.
shipments
Informações de frete/envio.
Provedor, serviço, prazo, valor, código de rastreio.
stock_movements
Histórico de estoque.
Entradas, saídas, reservas, baixas automáticas, vendas externas e ajustes.
settings
Configurações gerais.
Dados de loja, integrações e parâmetros operacionais.
audit_logs
Auditoria técnica/operacional.
Eventos críticos, alterações sensíveis e falhas de integração.
 
10.4 Preparação para atacado futuro
Embora o atacado não faça parte do MVP, a estrutura deve prever expansão. A recomendação é evitar campos e regras rígidas que obriguem reconstrução posterior.
● Adicionar desde o início um conceito simples de tipo de cliente, mesmo que todos sejam varejo no MVP.
● Permitir evolução futura para customer_type: retail / wholesale.
● Preparar produtos/variações para futura lista de preços, mesmo que no MVP exista apenas preço varejo.
● Não criar telas de atacado agora, mas evitar nomes de tabela e código que impeçam B2B depois.
● Manter pedido mínimo e aprovação de lojistas como regras de fase 2.
11. Integrações
11.1 Mercado Pago
A integração de pagamento será realizada via Mercado Pago, com suporte a Pix e cartão de crédito. O boleto não faz parte do escopo inicial, salvo decisão posterior do cliente.
● Criar pedido no sistema antes de enviar o cliente para pagamento.
● Registrar pagamento como pendente até confirmação.
● Receber webhook do Mercado Pago para atualização de status.
● Atualizar pedido para pago somente após confirmação confiável.
● Baixar estoque após pagamento aprovado.
● Liberar reserva quando pagamento expirar, for cancelado ou recusado.
● Registrar eventos de pagamento para auditoria e suporte.
● Usar ambiente de teste antes de produção.
11.2 Frete e transportadora
O provedor de frete será definido antes da implementação do módulo logístico. Como o cliente está aberto a alternativas, a recomendação técnica é implementar uma camada de gateway de frete que permita iniciar com um provedor e trocar futuramente, se necessário.
● Opções possíveis: Melhor Envio, Frenet, Kangu, Braspress ou outro provedor validado.
● A escolha depende de viabilidade técnica, custo, cobertura, contrato, API disponível e facilidade operacional.
● Produtos precisam ter peso e medidas confiáveis antes do go-live.
● O sistema deve armazenar a opção escolhida no momento da compra.
● Caso o frete falhe, o padrão do MVP será bloquear a compra automática e orientar contato pelo WhatsApp para cotação manual, salvo decisão comercial diferente.
11.3 Tracking e marketing
● Meta Pixel com eventos básicos: visualização de produto, adicionar ao carrinho, iniciar checkout e compra.
● Google Analytics e/ou Google Tag Manager conforme definição do projeto.
● Eventos devem ser testados antes do lançamento para evitar dados incorretos.
● Eventos de compra devem ser disparados somente após confirmação adequada, evitando duplicidade.
11.4 Comunicação transacional
● E-mail de confirmação de cadastro, se aplicável.
● E-mail de pedido recebido.
● E-mail de pagamento aprovado, se configurado.
● E-mail de envio/rastreio, se a equipe informar o rastreio no painel.
● Mensagens via WhatsApp podem ser fase futura, salvo definição específica no MVP.
12. Painel administrativo
O painel administrativo será a área de operação da equipe da Tudo em Ágata. A recomendação é utilizar Filament para acelerar desenvolvimento e manter uma interface organizada para CRUDs, pedidos e estoque.
Módulo admin
Funções
Prioridade
Produtos
Cadastrar, editar, ativar/inativar, descrição, categoria, imagens, destaque, SEO, tipo de produto e selos.
Essencial
Variações/SKUs
Cadastrar preço, estoque, peso, medidas, cor, tamanho, peso comercial e status.
Essencial
Categorias
Criar e organizar categorias de catálogo.
Essencial
Recomendações
Relacionar manualmente produtos para combine com, semelhantes e complementares.
Importante
Pedidos
Listar, visualizar detalhes, alterar status operacional e registrar rastreio.
Essencial
Clientes
Visualizar compradores, dados de contato, pedidos e endereços.
Essencial
Estoque
Consultar estoque, fazer ajustes, visualizar movimentações e reservas.
Essencial
Vendas externas
Registrar venda fora do site para baixa manual de estoque.
Essencial
Configurações
Dados da loja, parâmetros de integração, canais, políticas básicas e textos padrão.
Importante
Relatórios simples
Pedidos, faturamento bruto e produtos vendidos.
Desejável
 
12.1 Perfis administrativos
● Super Admin: acesso total, inclusive configurações críticas, permissões e integrações.
● Admin operacional: acesso a produtos, estoque, pedidos, clientes, recomendações e vendas externas, sem permissões críticas de sistema.
● Cliente varejo: acesso somente à área do cliente e aos próprios pedidos.
12.2 Campos recomendados no cadastro de produto
● Nome do produto.
● Slug.
● Categoria.
● Tipo de produto: padrão, variação, peça única ou kit.
● Descrição curta.
● Descrição completa.
● Preço varejo.
● Estoque.
● Peso e medidas.
● Status: ativo, inativo, esgotado.
● Selos: peça única, imagem ilustrativa, destaque, lançamento, produção própria.
● Imagem principal e galeria.
● Alt text das imagens.
● Título SEO e descrição SEO.
● Tags internas.
● Produtos relacionados.
13. Entregáveis
Entregável
Descrição
Status no MVP
Layout responsivo
Interface mobile-first para páginas principais, seguindo direção visual aprovada.
Incluído
Design system base
Padrões de botões, cards, selos, cores, tipografia, espaçamento, estados e formulários.
Incluído
Home e páginas institucionais
Home, sobre, contato, políticas e termos.
Incluído
Catálogo varejo
Listagem, categorias, busca, filtros básicos e produto.
Incluído
Página de produto premium
Galeria, selos, variações, frete, descrição, recomendações e confiança.
Incluído
Cadastro/login
Conta do cliente, login por e-mail/senha e Google.
Incluído
Área do cliente
Pedidos, detalhes, endereços e rastreio quando disponível.
Incluído
Carrinho
Adição, alteração, remoção, persistência e validação de estoque.
Incluído
Checkout
Dados, endereço, frete, pagamento e confirmação.
Incluído
Mercado Pago
Pix/cartão e webhook de pagamento.
Incluído
Frete
Cotação com provedor definido.
Incluído com dependência
Estoque e reserva
Baixa automática, baixa manual, movimentações e reserva temporária para peças únicas.
Incluído
Painel admin
Produtos, SKUs, estoque, pedidos, clientes, recomendações e vendas externas.
Incluído
SEO operacional
Slug, título SEO, descrição SEO e alt text.
Incluído
Tracking básico
Pixel/Analytics/Tag Manager se credenciais forem fornecidas.
Incluído com dependência
Treinamento operacional
Orientação para uso do painel.
Incluído
Documentação breve
Orientações de cadastro, pedidos, estoque e operação básica.
Incluído
 
14. Fora de escopo e fase 2
Os itens abaixo não fazem parte do MVP, mas podem ser orçados e planejados em fases futuras, conforme maturidade da operação e necessidade comercial.
Item
Status
Observação
Atacado/B2B
Fase 2
Área do lojista, aprovação, preço atacado e regras comerciais.
Pedido mínimo
Fase 2
Regra de valor mínimo para atacado, se voltar a ser necessária.
Tabela de preço por cliente
Fase 2
Níveis comerciais, grupos de cliente e descontos personalizados.
Cupons avançados
Fase 2
Campanhas, regras por categoria, frete grátis condicional.
Recuperação de carrinho
Fase 2
E-mail ou WhatsApp para abandono de carrinho.
Avaliações de produto
Fase 2
Reviews, estrelas e depoimentos por produto.
Lista de desejos
Fase 2
Favoritar produtos para compra futura.
Recomendação inteligente
Fase 2
Algoritmo avançado por comportamento de usuário.
Nota fiscal automática
Fase 2
Integração fiscal/ERP.
ERP Bling/Tiny
Fase 2
Sincronização de produtos, pedidos e estoque.
Frete avançado
Fase 2
Múltiplas transportadoras, regras complexas por região ou tabela especial.
Aplicativo mobile
Fora do MVP
Não será desenvolvido aplicativo nativo.
Marketplace
Fora do MVP
Integração com Mercado Livre, Shopee ou similares não incluída.
Fotografia profissional
Fora do MVP
Produção de fotos deve ser definida separadamente.
Cadastro completo de todo catálogo
Dependência/possível extra
Volume grande de produtos pode exigir orçamento operacional separado.
 
15. Dependências do cliente
Para evitar atrasos, alguns itens precisam ser entregues, definidos ou validados pela Tudo em Ágata antes ou durante o desenvolvimento.
Dependência
Responsável
Momento ideal
Lista de categorias e organização inicial do catálogo
Cliente + EKLO
Planejamento
Identidade visual final: logos, paleta, fontes e aplicações
Cliente + EKLO
Antes do layout
Fotos de produtos ou padrão visual de fotos
Cliente/EKLO conforme acordo
Antes do cadastro final
Definição de quais produtos são peça única e quais são imagem ilustrativa
Cliente
Antes do cadastro final
Descrições mínimas de produtos
Cliente + EKLO
Durante cadastro
Pesos e medidas dos produtos/SKUs
Cliente
Antes da homologação do frete
Credenciais Mercado Pago
Cliente
Antes da integração de pagamento
Definição do provedor de frete
Cliente + EKLO
Antes do desenvolvimento do frete
Domínio e acesso DNS
Cliente
Antes da publicação
Políticas de troca, envio e privacidade
Cliente + EKLO
Antes do go-live
Dados institucionais e canais de contato
Cliente
Durante conteúdo
Validação de produtos e estoque inicial
Cliente
Antes do go-live
Responsáveis por homologação
Cliente + EKLO
Antes dos testes finais
 
Ponto crítico de dependência
Sem peso e medida dos produtos, o cálculo de frete pode ficar impreciso. Para pedras naturais, essa etapa é essencial para evitar prejuízo operacional e divergência de valores. Sem definição clara entre peça única e imagem ilustrativa, o site também pode gerar expectativa incorreta no cliente.
 
16. Cronograma sugerido
O cronograma abaixo é uma estimativa para planejamento. O prazo real depende de aprovação de layout, entrega de conteúdo, definição de frete, credenciais, volume de produtos e velocidade de homologação.
Fase
Duração estimada
Atividades
Saída esperada
1. Planejamento técnico e produto
1 semana
Sitemap, categorias, regras, arquitetura, provedor de frete, tipos de produto, checklist de dados e decisões de UX.
Escopo validado e backlog inicial.
2. UX/UI e layout
1 a 2 semanas
Home, catálogo, produto, carrinho, checkout, área do cliente, admin base e design system inicial.
Layout aprovado.
3. Fundação técnica
1 semana
Laravel, Breeze, Socialite, Filament, permissões, banco inicial e estrutura base.
Projeto técnico pronto para módulos.
4. Catálogo e admin
2 semanas
Produtos, categorias, variações, imagens, SEO, selos, recomendações, estoque e cadastro administrativo.
Catálogo funcional.
5. Cliente, carrinho e checkout
2 semanas
Login, Google, área do cliente, carrinho, endereço, validações e checkout.
Fluxo de compra estruturado.
6. Pagamento, estoque e frete
1 a 2 semanas
Mercado Pago, webhooks, reserva temporária, gateway de frete e status de pedidos.
Compra completa testável.
7. Homologação e ajustes
1 semana
Testes, correções, treinamento, validação operacional e revisão visual.
MVP pronto para lançamento.
8. Publicação
2 a 3 dias
Deploy, DNS, SSL, backups e verificação final.
Site publicado.
 
Estimativa total
Aproximadamente 8 a 12 semanas, podendo variar conforme complexidade do catálogo, frete, volume de conteúdo e velocidade de validação das peças únicas, fotos, pesos e medidas.
 
17. Critérios de aceite
O projeto deve ser considerado entregue quando os critérios abaixo forem testados e aprovados em ambiente de homologação ou produção controlada.
17.1 Critérios funcionais gerais
● Visitante consegue navegar pela home, categorias, busca e produto no desktop e no mobile.
● Cliente consegue criar conta, fazer login, recuperar senha e entrar com Google.
● Cliente consegue cadastrar endereço e visualizar área do cliente.
● Produto com variação pode ser selecionado e adicionado ao carrinho.
● Produto de peça única não permite compra acima do estoque disponível.
● Produto de peça única possui reserva temporária durante o pagamento e liberação em caso de expiração/cancelamento.
● Carrinho permite alterar quantidade, remover item e recalcular total.
● Checkout exige cliente autenticado e coleta dados obrigatórios.
● Frete calcula conforme provedor definido e salva a opção escolhida.
● Pedido é criado com status pendente antes do pagamento.
● Mercado Pago recebe pagamento de teste e retorna status via webhook.
● Pedido muda para pago após confirmação válida.
● Estoque baixa após pagamento aprovado.
● Pedido cancelado ou pagamento não concluído não baixa estoque definitivamente.
● Admin consegue cadastrar produto, variação, imagem, preço, estoque, medidas, selos e SEO.
● Admin consegue relacionar produtos em recomendações manuais.
● Admin consegue visualizar pedidos, alterar status e inserir rastreio.
● Admin consegue registrar venda externa com baixa manual de estoque.
● Movimentações de estoque ficam registradas.
● Páginas de políticas, contato e informações institucionais estão publicadas.
● Pixel/Analytics estão funcionando se fizerem parte da configuração final.
● Equipe recebeu orientação para operação básica do painel.
17.2 Critérios visuais e de UX
● Home transmite marca, tradição, produto natural, sofisticação e caminho claro para compra.
● Página de produto deixa evidente se a peça é única ou se a imagem é ilustrativa.
● Botão de compra é visível no mobile sem confusão com ações secundárias.
● Preço, variação, disponibilidade, frete e CTA estão próximos e claros.
● Busca sem resultado, carrinho vazio, produto esgotado e frete indisponível possuem mensagens amigáveis.
● Cards de produto não ficam poluídos e valorizam a fotografia.
● Tipografia, cores, espaçamentos e botões seguem padrão consistente.
● Checkout não possui distrações visuais que prejudiquem conversão.
● Layout evita aparência genérica de marketplace ou loja popular demais.
● Imagens carregam de forma otimizada e não quebram a navegação mobile.
18. Riscos, premissas e governança
18.1 Principais riscos
Risco
Impacto
Mitigação
Pesos/medidas incompletos
Frete incorreto e prejuízo operacional.
Checklist obrigatório antes do go-live.
Catálogo muito grande
Atraso no cadastro e validação.
Priorizar produtos principais e organizar importação/cadastro por lotes.
Peças únicas mal cadastradas
Venda duplicada, expectativa incorreta ou indisponibilidade.
Campo obrigatório de tipo de produto, estoque unitário e reserva temporária.
API de frete escolhida com limitações
Recalcular escopo ou trocar provedor.
Validar tecnicamente antes de codificar o módulo.
Pagamento sem webhook bem tratado
Pedido pode ficar com status incorreto.
Implementar logs e testes de pagamento.
Estoque físico divergente
Venda de produto indisponível.
Rotina de conferência e baixa manual para vendas externas.
Visual genérico
Site funciona, mas não transmite valor da marca.
Aprovar direção visual e telas principais antes de avançar implementação.
Mudança de escopo durante execução
Atraso e aumento de complexidade.
Registrar solicitações e tratar como alteração de escopo.
Conteúdo não entregue
Páginas incompletas ou publicação atrasada.
Definir responsáveis e prazos de conteúdo.
 
18.2 Premissas do projeto
● O MVP é exclusivamente varejo.
● Atacado será tratado como fase futura.
● Login com Google está incluído no MVP.
● Nota fiscal será emitida manualmente fora do sistema.
● Cliente fornecerá ou validará dados de produtos, pesos, medidas e fotos.
● A equipe da Tudo em Ágata será responsável pela operação de separação, embalagem, emissão fiscal e envio.
● Integrações dependem de credenciais, aprovação de contas e disponibilidade dos provedores.
● Alterações relevantes após aprovação do escopo devem ser avaliadas como mudança de escopo.
● Recomendações do MVP serão manuais ou por regra simples, sem algoritmo avançado.
18.3 Governança e controle de mudanças
Para preservar prazo, qualidade e previsibilidade, qualquer solicitação fora deste documento deve ser registrada, analisada e classificada como ajuste corretivo, melhoria dentro do escopo ou nova funcionalidade. Novas funcionalidades, integrações adicionais, mudanças de regra comercial e ampliação para atacado devem ser tratadas como fase futura ou orçamento separado.
18.4 Pontos que ainda dependem de definição operacional
● Qual provedor de frete será utilizado no MVP.
● Quais categorias serão usadas no lançamento.
● Qual lote inicial de produtos será cadastrado antes do go-live.
● Quem será responsável por fotos, descrições, pesos e medidas.
● Quais e-mails transacionais serão enviados no lançamento.
● Quais status de pedido serão usados na operação real.
● Como será a política final de troca, envio e privacidade.
● Qual será a identidade visual final aprovada: arquivos de logo, paleta, fontes e aplicações.
19. Apêndices técnicos e operacionais
Apêndice A - Checklist de preparação para desenvolvimento
● Definir provedor de frete.
● Criar ambiente de desenvolvimento e repositório.
● Confirmar stack final e hospedagem.
● Definir categorias iniciais.
● Definir padrão de foto de produto simples e peça única.
● Definir quais produtos são peça única, padrão, variação ou kit.
● Definir campos obrigatórios do produto.
● Definir planilha padrão para importação/cadastro de produtos, se necessário.
● Levantar pesos e medidas dos produtos prioritários.
● Obter credenciais Mercado Pago.
● Obter configuração do login com Google.
● Obter acessos de domínio/DNS.
● Definir políticas de troca, privacidade e envio.
● Definir status operacionais de pedido.
● Definir responsáveis por homologação no cliente.
● Definir data alvo de lançamento.
● Aprovar direção visual da home, categoria, produto, carrinho e checkout.
Apêndice B - Diretriz técnica sobre CPF e chaves do banco
O CPF não deve ser utilizado como chave primária do usuário. A chave técnica deve ser um ID interno, gerado pelo banco ou pela aplicação. O CPF deve ser tratado como dado do cliente, armazenado em campo próprio e usado apenas quando necessário para identificação fiscal, comercial ou operacional.
● Chave primária recomendada para users: id interno numérico ou ULID/UUID.
● CPF armazenado em customers.cpf, com validação e possível índice único conforme regra de negócio.
● E-mail usado para login tradicional, mas sem depender dele como chave técnica imutável.
● Telefone usado como dado de contato e, futuramente, pode apoiar login por código, mas não deve ser chave primária.
● Google ID armazenado em social_accounts para vincular login social ao usuário interno.
Apêndice C - Diretriz técnica sobre frete
O módulo de frete deve ser implementado por contrato/interface interna. Isso evita que toda a aplicação dependa diretamente de uma única transportadora ou hub logístico.
● Criar uma camada ShippingGateway com método de cotação padronizado.
● Implementar no MVP apenas o provedor escolhido.
● Salvar no pedido o resultado da cotação usada na compra.
● Permitir troca futura de provedor com menor impacto no restante do sistema.
● Exigir peso e medidas confiáveis por SKU antes do lançamento.
● Quando o frete não puder ser calculado, aplicar o fallback operacional definido no escopo.
Apêndice D - Diretriz técnica sobre peça única e reserva temporária
Produtos de estoque unitário exigem tratamento especial. A regra recomendada é reservar temporariamente o item quando o cliente inicia o pagamento, evitando venda duplicada. A reserva deve expirar automaticamente caso o pagamento não seja concluído dentro do prazo definido.
● Peça única deve ter estoque igual a 1 no cadastro inicial.
● Peça única deve exibir selo visível na listagem e página de produto.
● Peça única deve informar que o cliente receberá exatamente a peça fotografada.
● Ao iniciar checkout/pagamento, criar inventory_reservation vinculada ao carrinho/pedido.
● Pagamento aprovado converte reserva em baixa definitiva de estoque.
● Pagamento expirado, cancelado ou recusado libera reserva.
● Admin deve conseguir visualizar se um item está disponível, reservado, vendido ou inativo.
Apêndice E - Referências técnicas e conceituais consultadas
As referências abaixo não devem ser copiadas visualmente. Elas servem como apoio conceitual para decisões de usabilidade, administração, componentes e integração.
Referência
Uso no projeto
Mercado Pago Developers - Webhooks
Base conceitual para atualização de status de pagamento via notificação assíncrona.
Filament PHP Documentation
Referência para painel administrativo em Laravel.
Shopify Polaris
Referência de consistência, componentes e padrões de interface para administração de comércio.
Mercado Livre / Andes
Referência de escala, clareza e consistência de UX em comércio digital.
Boas práticas de páginas de produto em e-commerce
Base para exigir nome, imagens, preço, opções, disponibilidade, CTA, descrição e confiança na página de produto.
