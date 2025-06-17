## 📝 Descrição do Projeto

Meraki Shop é uma plataforma de e-commerce especializada para colecionadores de action figures raras e itens únicos. Nossa missão é oferecer um espaço seguro e exclusivo para que entusiastas possam encontrar e adquirir colecionáveis autenticados. O projeto foi desenvolvido com o objetivo de proporcionar uma experiência de compra fluida e segura, desde a visualização dos produtos até o gerenciamento de pedidos. Por ser um e-commerce com foco no mercado americano, toda a interface da aplicação está em inglês.

## ✨ Funcionalidades

-   **Design Responsivo:** Interface adaptada para uma ótima experiência em desktops e dispositivos móveis.
-   **Tema Dark/Light:** Alterne entre os modos de visualização claro e escuro para maior conforto visual.

- **Visualização de Produtos:** Navegue por um catálogo de colecionáveis raros.
- **Autenticação de Usuário:** Sistema de login e registro para uma experiência personalizada.
- **Gerenciamento de Conta:** Usuários podem cadastrar e gerenciar seus endereços e cartões de crédito.
- **Histórico de Pedidos:** Acompanhe todos os seus pedidos na página "My Orders"

Para administradores:
- **Registro de Produtos:** Gerencie a criação de novos produtos para loja



## 🖼️ Telas da Aplicação

Abaixo estão algumas telas que demonstram o fluxo da aplicação.

*Nota: Substitua os caminhos abaixo pelas imagens correspondentes da sua aplicação.*

### Página de Produtos
![Página de Produtos](./.images-cdn/products-page.png "Página de Produtos")

### Meus Pedidos
![Meus Pedidos](./.images-cdn/my-orders-page.png "Página de Meus Pedidos")

## 🚀 Como Utilizar

1.  **Navegue pelos Produtos:** Na página inicial, você pode ver a lista de produtos disponíveis.
2.  **Faça Login ou Cadastre-se:** Para comprar, você precisa ter uma conta. Crie uma ou faça o login com uma conta Google.
3.  **Adicione seus Dados:** Antes da primeira compra, cadastre um endereço de entrega e um cartão de crédito através dos botões no topo da página.
4.  **Realize a Compra:** Com os dados cadastrados, basta clicar em "Buy with click" em um produto para finalizar o pedido.
5.  **Acompanhe seus Pedidos:** Na seção "My Orders", você pode visualizar o status e os detalhes de todas as suas compras.
6.  

## Estrutura de diretórios

A estrutura do projeto segue o padrão do Laravel, com o frontend em Vue.js integrado. Abaixo está uma representação da árvore de diretórios com as responsabilidades de cada parte:

```sh
meraki-shop/
├── app/  # Backend: Lógica principal da aplicação (PHP)
│   ├── Http/
│   │   └── Controllers/  # Backend: Controladores que lidam com as requisições
│   ├── Models/         # Backend: Modelos Eloquent para interação com o banco
│   ├── Services/       # Backend: Lógica de negócio da aplicação
│   └── ...
├── database/ # Banco de Dados: Migrations, seeders e factories
│   ├── migrations/   # Banco de Dados: Estrutura das tabelas
│   ├── seeders/      # Banco de Dados: População inicial
│   └── factories/    # Banco de Dados: Geração de dados de teste
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
└── ...     # Outros diretórios de configuração do Laravel
```


