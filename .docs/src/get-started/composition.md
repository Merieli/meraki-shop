# Composition

## 🏗️ Arquitetura da Aplicação

O projeto adota o padrão arquitetural **Model-View-Controller (MVC)** no backend com Laravel, complementado por um frontend desacoplado em Vue.js. Essa abordagem organiza o código de forma clara e eficiente.

-   **Model:** Representa a estrutura de dados e a lógica de negócio. Em Laravel, são as classes Eloquent localizadas em `app/Models/`. Elas são responsáveis por interagir com as tabelas do banco de dados. Por exemplo, o modelo `Product` gerencia os dados na tabela `products`.

-   **View:** Camada responsável pela apresentação da interface do usuário. Neste projeto, a abordagem é híbrida. O Laravel serve uma view principal (`resources/views/app.blade.php`), que atua como um contêiner para a aplicação frontend. A renderização da interface e a interatividade são totalmente gerenciadas pelo Vue.js, cujos componentes e páginas estão em `resources/js/`.

-   **Controller:** Atua como o intermediário entre o Model e a View. Localizados em `app/Http/Controllers/`, os controladores recebem as requisições HTTP (enviadas pelo frontend Vue), utilizam os Models para consultar ou manipular dados e retornam uma resposta. Em vez de retornar uma view HTML completa, eles geralmente devolvem dados em formato JSON, que são consumidos pela aplicação Vue para atualizar a interface.

Essa arquitetura, conhecida como "headless" ou API-driven, permite que o backend e o frontend sejam desenvolvidos e mantidos de forma independente, oferecendo maior flexibilidade e uma experiência de usuário mais fluida.


## Estrutura de diretórios

A estrutura do projeto segue o padrão do Laravel, com o frontend em Vue.js integrado. Abaixo está uma representação da árvore de diretórios com as responsabilidades de cada parte:

```sh
meraki-shop/
├── .docs/ # Documentação Vitepress para organizar as demandas e o projeto
├── .images-cdn/ # Imagens a serem disponibilizadas via CDN Statically
├── .prints/ # Telas do sistema desenvolvido
├── app/  # Backend: Lógica principal da aplicação (PHP)
│   ├── Http/
│   │   └── Controllers/  # Backend: Controladores que lidam com as requisições
│   ├── Models/         # Backend: Modelos Eloquent para interação com o banco
│   ├── Services/       # Backend: Lógica de negócio da aplicação
│   └── ...
├── bootstrap/ # Backend: Scripts de inicialização do framework Laravel
├── config/ # Backend: Arquivos de configuração da aplicação
├── database/ # Banco de Dados: Migrations, seeders e factories
│   ├── migrations/   # Banco de Dados: Estrutura das tabelas
│   ├── seeders/      # Banco de Dados: População inicial
│   └── factories/    # Banco de Dados: Geração de dados de teste
├── public/ # Backend: Ponto de entrada público e assets compilados
├── resources/ # Frontend: Código-fonte da interface do usuário (Vue.js, CSS)
│   ├── css/          # Frontend: Estilos globais (app.css)
│   ├── js/           # Frontend: Código principal do Vue.js
│   │   ├── components/ # Frontend: Componentes reutilizáveis
│   │   ├── pages/      # Frontend: Páginas da aplicação
│   │   ├── layouts/    # Frontend: Estruturas de layout
│   │   └── ...
│   └── views/        # Frontend: Ponto de entrada do Laravel (app.blade.php)
├── routes/ # Backend: Definição de rotas da aplicação
│   ├── api.php       # Backend: Rotas da API
│   └── web.php       # Backend: Rotas web
├── storage/ # Backend: Arquivos gerados pelo framework (cache, logs)
├── tests/ # Testes: Testes automatizados da aplicação
└── ...     # Outros diretórios de configuração do Laravel
```
