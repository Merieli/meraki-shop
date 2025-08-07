---
outline: deep
lastUpdated: true
---

# PRD (Product Requirements Document)

## 🎯 Visão Geral

O Meraki Shop é um ecommerce especializado em figuras de ação colecionáveis, focado em proporcionar uma experiência de compra ultra-rápida através do recurso de "compra com 1 clique". O sistema visa resolver o problema comum de colecionadores perderem itens raros devido à baixa disponibilidade e processo de checkout demorado.

### Público-alvo

- Colecionadores de figuras de ação
- Compradores frequentes que valorizam rapidez
- Usuários que priorizam garantir itens raros/limitados

### Funcionalidades Principais

- **Autenticação e Perfil**: Registro de usuário com autenticação segura via Google (WorkOS), possuindo cadastro obrigatório de endereço de entrega e cartão de crédito.
- **Catálogo de Produtos**: Listagem de produtos com informações essenciais, fotos e descrições detalhadas, filtragem por categorias.
- **Compra com 1 Clique**: Botão de compra instantânea para usuários logados, utilizando automaticamente o cartão e endereço cadastrados, com confirmação imediata.
- **Painel do Cliente**: Histórico de compras, gerenciamento de endereços e cartões, status dos pedidos.
- **Painel Administrativo**: CRUD de produtos, gestão de pedidos e usuários, visualização de métricas de vendas.

## Stack de Tecnologia

- Backend: Laravel
- Frontend: Vue.js 3 com Inertia
- Autenticação: Google OAuth via WorkOS
- Banco de Dados: PostgreSQL

## 📈 Métricas de Sucesso

- Tempo médio de resposta da API abaixo de 1500ms.
- 100% de cobertura das funcionalidades propostas.
- Zero compras realizadas sem autenticação.
- Usuários conseguem realizar compra com 1 clique sem erros.
- Feedback visual imediato nas ações do usuário (ex: compra bem-sucedida, erro de validação).

## 🚧 Restrições e Limitações

- Sem páginas individuais de produto
- Sem gestão de estoque complexa
- Sem cálculo de frete
- Sem sistema de promoções
- Pagamentos simulados apenas


## Fases de Desenvolvimento

1. Setup inicial e autenticação
2. Gestão de produtos e catálogo
3. Fluxo de compra padrão
4. Implementação de compra rápida
5. Painéis administrativos
6. Testes e otimizações

### Expansão Futura

- Sistema de notificações para itens raros
- Lista de desejos
- Sistema de reservas
- Integração com pagamentos reais
- Gestão de estoque avançada


## 📎 Anexos e Referências

- [Projeto no Figma](https://www.figma.com/design/qK1ZmNSo1sYd2o9UGNKvKF/MERAKI---Relume-Figma-Kit--v3.0---Community-?node-id=1919-1544&p=f&t=MBcrqmysAoPULprc-0)
- [Autenticação com Goole e WorkOS](https://dashboard.workos.com/environment_01JV7T3ECPE68XY5J73MD05FV4/onboarding/sso)

