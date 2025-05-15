---
outline: deep
lastUpdated: true
---

# 📄 PRD (Product Requirements Document)  <Badge type="warning" text="em andamento" />

- **Autor:** Meriéli  
- **Data:** 2025-05-13


## 🎯 Visão Geral

Este projeto consiste na criação de um MVP de ecommerce simplificado, com funcionalidades básicas para cadastro de produtos, realização de compras e consulta de vendas. O objetivo é validar o modelo de negócio e testar a usabilidade da funcionalidade de compra rápida (1 clique) com usuários autenticados. O painel administrativo permitirá o gerenciamento básico de produtos, vendas e usuários.


## 📌 Objetivos

- Permitir a venda de produtos online com experiência simples e eficiente.
- Validar a funcionalidade de compra rápida via cartão de crédito cadastrado.
- Disponibilizar painel administrativo mínimo para manutenção do catálogo e vendas.
- Garantir que apenas usuários logados possam realizar compras.


## 📚 Glossário

| Termo               | Definição                                                      |
| :------------------ | :------------------------------------------------------------- |
| Compra 1 Clique     | Compra instantânea sem passar pelo carrinho, com cartão salvo. |
| MVP                 | Produto Mínimo Viável                                          |
| Laravel Starter Kit | Pacote oficial do Laravel com autenticação e Vue integrado     |


## 📑 Requisitos Funcionais

| ID     | Requisito                                                                   | Prioridade |
| :----- | :-------------------------------------------------------------------------- | :--------- |
| RF-001 | Usuário pode criar uma conta                                                | Alta       |
| RF-002 | Usuário pode fazer login/logout                                             | Alta       |
| RF-003 | Usuário autenticado pode visualizar catálogo de produtos                    | Alta       |
| RF-004 | Usuário autenticado pode realizar compra padrão via checkout                | Alta       |
| RF-005 | Usuário autenticado pode realizar compra com 1 clique se tiver cartão salvo | Alta       |
| RF-006 | Usuário pode consultar suas compras realizadas                              | Alta       |
| RF-007 | Admin pode cadastrar/editar produtos via painel                             | Alta       |
| RF-008 | Admin pode visualizar vendas realizadas                                     | Alta       |
| RF-009 | Admin pode listar e gerenciar usuários                                      | Média      |


## 📑 Requisitos Não-Funcionais

| ID      | Requisito                                                               | Prioridade |
| :------ | :---------------------------------------------------------------------- | :--------- |
| RNF-001 | API deve responder em menos de 500ms                                    | Alta       |
| RNF-002 | Aplicação deve estar disponível 99,9% do tempo                          | Alta       |
| RNF-003 | Sistema responsivo (mobile first)                                       | Alta       |
| RNF-004 | Autenticação segura com Laravel Sanctum                                 | Alta       |
| RNF-005 | Compra 1 clique deve simular integração com API de pagamentos (sandbox) | Média      |
| RNF-006 | Deploy containerizado via Docker                                        | Média      |


## 🚧 Restrições de Tecnologia

- Backend deve ser em **Laravel 11**.
- Frontend deve utilizar **Vue 3 com Laravel Starter Kit**.
- Integração simulada de pagamento (sandbox ou API mockada).
- Sem páginas individuais de produto (apenas listagem geral).
- Sem controle de estoque, frete ou promoções.


## ⚠️ Riscos e Dependências

| Risco/Dependência                            | Impacto | Mitigação                                 |
| :------------------------------------------- | :------ | :---------------------------------------- |
| Instabilidade na API simulada de pagamentos  | Média   | Definir fallback de erro e testes offline |
| Demora no provisionamento de ambiente Docker | Baixa   | Definir ambientação no início do projeto  |


## 📈 Métricas de Sucesso

- Tempo médio de resposta da API abaixo de 500ms.
- 100% de cobertura das funcionalidades propostas.
- Zero compras realizadas sem autenticação.
- Usuários conseguem realizar compra com 1 clique sem erros.


## 🗺️ Roadmap (Macro)

| Data       | Entrega                                     |
| :--------- | :------------------------------------------ |
| 2025-05-13 | Aprovação do PRD                            |
| 2025-05-14 | Início da implementação                     |
| 2025-06-02 | Catálogo, Cadastro/Login                    |
| 2025-06-22 | Compra padrão e compra com 1 clique         |
| 2025-07-12 | Consulta de compras e Painel Administrativo |
| 2025-08-01 | Testes, ajustes finais e deploy             |


## 📎 Anexos e Referências

- [Link para o TDD relacionado](#)
- [Wireframes no Figma](#)
- [Referência do Laravel Starter Kit](https://laravel.com/docs/starter-kits)
