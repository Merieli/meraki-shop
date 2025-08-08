<contexto>

# Visão Geral  

O Meraki Shop elimina a frustração de colecionadores que perdem itens raros devido a checkouts lentos, oferecendo a funcionalidade "compra com 1 clique" para aquisições rápidas. É destinado  a colecionadores de figuras de ação, entusiastas de cultura pop e fãs de edições limitadas que buscam agilidade e exclusividade. Proporciona uma experiência de compra rápida, intuitiva e confiável aumentando as chances de adquirir itens raros e exclusivos.

# Funcionalidades Principais  

- **Autenticação Segura**: permite registro e login de usuários via Google (WorkOS), exigindo cadastro de endereço de entrega e cartão de crédito. Dessa forma, garante segurança nos acessos e agiliza compras ao armazenar dados essenciais. Usuários autenticam-se via Google, e em seguida preenchem e salvam informações de entrega e pagamento no perfil.
- **Catálogo de Produtos**: exibe produtos colecionáveis de figuras de ação com fotos, preço, descrições detalhadas e o botão de compra. Dessa forma, permite que os usuários encontrem rapidamente itens de interesse. Produtos são listados em uma interface simplificada, com os produtos exibidos em grade. 
- **Compra com 1 Clique**: permite compra instantânea usando dados salvos, com confirmação imediata. Dessa forma, reduz o tempo de checkout, aumentando chances de adquirir itens raros. Usuários logados clicam no botão de compra, que processa automaticamente o pagamento e entrega.
- **Painel do Cliente**: oferece histórico de compras, gerenciamento de endereços, cartões e status de pedidos. Dessa forma, permite controle e transparência ao cliente sobre suas transações. O painel possui interface acessível e exibe e permite edição de dados e acompanhamento de pedidos.
- **Painel Administrativo**: gerencia produtos (CRUD), pedidos, usuários e exibe métricas de vendas.Permite controle eficiente da loja e análise de desempenho. Administradores acessam uma interface para adicionar/editar produtos, gerenciar pedidos e visualizar relatórios.


# Experiência do Usuário  
<!-- [Descreva a jornada e a experiência do usuário. Inclua:
- Personas de usuário
- Fluxos de uso principais
- Considerações de UI/UX] -->

## Fluxo principal do usuário

```mermaid
graph LR
    A[Visita o Meraki Shop na Home/Catálogo] --> B[Login com Google]
    B --> D{Autenticou com sucesso?}
    D -->|Não| B
    D -->|Sim| E{Conta é admin?}

    E -->|Sim| AD1[Dashboard]
    AD1 --> AD2[Ver vendas e gráficos]
    AD2 --> AD3[Gerenciar produtos]
    AD3 --> AD5[Configurações: Perfil, Aparência]

    E -->|Não| F[Explorar produtos]

    F --> K{Em estoque?}
    K -->|Não| L[Exibe erro sobre a quantidade dispinível]
    K -->|Sim| M[Comprar com 1 clique]

    M --> N{Endereço cadastrado?}
    N -->|Não| O[Cadastrar endereço]
    N -->|Sim| P{Cartão cadastrado?}
    O --> P
    P -->|Não| Q[Cadastrar cartão]
    P -->|Sim| R[Confirmar e criar pedido]
    R --> U[Ver detalhes do pedido]
    Q --> R
    U --> F
```

</contexto>
<PRD>

# Arquitetura Técnica  
<!-- [Descreva os detalhes de implementação técnica:
- Componentes do sistema
- Modelos de dados
- APIs e integrações
- Requisitos de infraestrutura
- Formato de resposta esperado] -->

## High-Level Architecture

```mermaid
graph TB
    subgraph "Frontend Layer"
        UI["`**Vue.js SPA**<br/>Components, Pages, Layouts`"]
        AUTH["`**WorkOS**<br/>Authentication`"]
        COMP_COMP["`**Typescript Composables**<br/>useProductForm, useAuth, etc.`"]
    end
    
    subgraph "Laravel Backend"
        CTRL["`**Controllers**<br/>ProductController, UserController`"]
        
        SERVICES["`**Service Layer**<br/>Business Logic - Services or Repositories`"]

        MODELS["`**Eloquent Models**<br/>Product, User, Order`"]
    end

    DB[("`**Database**<br/>PostgreSQL`")]
    
    subgraph "External Services"
        WORKOS["`**WorkOS**<br/>Authentication Provider`"]
        CDN["`**CDN Statically**<br/>Static Assets`"]
    end
    
    %% Connections
    UI --> AUTH
    UI --> COMP_COMP
    
    COMP_COMP .->|"HTTP Requests<br/>(JSON API)"| CTRL
    CTRL --> SERVICES
    SERVICES --> MODELS
    MODELS --> DB
    
    AUTH -.->|"OAuth Flow"| WORKOS
    UI -.->|"Static Assets"| CDN
    
    %% Response flow
    CTRL -.->|"JSON Response"| COMP_COMP
    
    %% Styling
    classDef frontend fill:#e1f5fe
    classDef backend fill:#f3e5f5
    classDef external fill:#fff3e0
    classDef database fill:#e8f5e8
    
    class UI,COMP,COMP_LIB,COMP_COMP,UTILS frontend
    class ROUTES,CTRL,MIDDLEWARE,SERVICES,REPOS,MODELS backend
    class WORKOS,CDN external
    class DB database
```

## Component Breakdown

- **Frontend Components**:
  - **UserInfo.vue**: Exibe informações do usuário logado com avatar, nome, email e integração com sistema de iniciais quando não há foto.
  - **NavMain.vue**: Menu principal de navegação com controle de permissões (admin/user), ícones dinâmicos e indicação de página ativa.
  - **AppearanceTabs.vue**: Controle de tema da aplicação permitindo alternar entre modo claro, escuro e automático baseado no sistema.
  - **ProductCard.vue:** Card de produto na vitrine com imagem, preço, avaliação, botão de compra e feedback de status de pedidos.
  - **TopBanner.vue:** Banner informativo que exibe status de cartão e endereço cadastrados, com botões para registro quando necessário.

- **Backend Services**:
  - **ProductService.php (Business Logic):** Gerencia a lógica de negócio para produtos, incluindo criação, validação, formatação de dados (preços em centavos), e aplicação de regras de negócio antes da persistência no banco de dados.
  - **ProductRepository.php (Data Access Layer):** Centraliza operações de acesso a dados de produtos, implementando padrão Repository para abstrair consultas complexas e manter separação entre lógica de negócio e acesso a dados.
  - **UserRepository.php (Data Access Layer):** Gerencia operações de persistência de usuários, incluindo consultas específicas para autenticação, perfis administrativos e relacionamentos com pedidos e endereços.
  - **AddressRepository.php (Data Access Layer):** Controla operações CRUD para endereços de entrega, implementando validações específicas e consultas otimizadas para relacionamentos usuário-endereço.
  - **ProductController.php (API Controllers):** API para gerenciamento de produtos com endpoints para CRUD, validação de entrada via FormRequests e retorno de dados formatados em JSON.
  - **OrderController.php, AddressController.php, CustomerCardController.php (API Controllers):**  gerencia operações CRUD, integrando pedidos, endereço e cartões de crédito.
  - **ProductFormRequest.php (Data Validation):** Centraliza regras de validação para dados de produtos, incluindo validação de preços, URLs de imagens, limites de caracteres e campos obrigatórios.

Baseado nas migrations do projeto **Meraki Shop**, aqui estão os principais modelos de dados:

- **Data Models**:
  - **User**: `id`, `name`, `email`, `workos_id`, `avatar`, `role` (admin/client) - Relacionamentos: hasMany(Orders, Addresses, CustomerCards)
  - **Product**: `id`, `name`, `price` (centavos), `cost_price`, `stock`, `thumbnail`, `images`, `short_description`, `description`, `rating`, `sku` - Relacionamentos: hasMany(OrderItems), belongsToMany(Attributes)
  - **Order**: `id`, `user_id`, `status`, `payment_method` - Relacionamentos: belongsTo(User), hasMany(OrderItems)
  - **OrderItem**: `id`, `order_id`, `product_id`, `variation_id`, `quantity`, `unit_price` - Relacionamentos: belongsTo(Order, Product, Variation)
  - **Address**: `id`, `user_id`, `label`, `recipient_name`, `street`, `number`, `neighborhood`, `complement`, `city`, `state`, `country`, `postal_code` - Relacionamentos: belongsTo(User)
  - **CustomerCard**: `id`, `user_id`, `card_token`, `card_last4`, `card_brand` - Relacionamentos: belongsTo(User)
  - **Variation**: `id`, `name`, `image_url`, `price`, `stock`, `sku`, `available` - Relacionamentos: hasMany(OrderItems), belongsToMany(Attributes)
  - **Attribute**: `id`, `name` - Relacionamentos: belongsToMany(Products, Variations)
  - **PersonalAccessToken**: `id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at` - Sistema de autenticação API (Laravel Sanctum)

## API Design

```mermaid
sequenceDiagram
    participant U as 👤 User (Admin)
    participant F as 🖥️ Frontend Vue.js
    participant A as ⚙️ Laravel API
    participant D as 🗄️ Database PostgreSQL
    
    rect rgb(240, 248, 255)
        Note over U,D: 🛍️ Product Creation Flow
        U->>F: Fill Product Form
        F->>F: Validate Form Data
        F->>+A: POST /api/products + Bearer Token
        A->>A: Validate Request Data
        A->>+D: INSERT Product
        D-->>-A: Created Product
        A-->>-F: JSON Response {status: success, data: product}
        F-->>U: Success Message + Redirect
    end
    
    rect rgb(255, 245, 245)
        Note over U,D: ❌ Error Handling
        A->>A: Validation Failed
        A-->>F: 422 Validation Errors
        F-->>U: Display Field Errors
    end
```


### Endpoints

- **POST /api/[resource]**
  - Request: `{field1: type, field2: type}`
  - Response: `{status: string, data: {...}}`
  - Errors: `400 Bad Request`, `401 Unauthorized`

## Data Flow

```mermaid
flowchart TD
    A[Input Data] --> B{Validation}
    B -->|Valid| C[Processing]
    B -->|Invalid| D[Error Response]
    C --> E[Transform]
    E --> F[Store]
    F --> G[Return Success]
```

# Roadmap de Desenvolvimento  
<!-- [Divida o processo de desenvolvimento em fases:
- Requisitos do MVP
- Melhorias futuras
- Não pense em prazos neste momento — o que importa é o escopo e detalhar exatamente o que precisa ser construído em cada fase para depois ser quebrado em tarefas] -->


## Development Phases

```mermaid
graph LR
    A[Foundation] --> B[Core Features]
    B --> C[Integration]
    C --> D[Testing]
    D --> E[Deployment]
    
    A -.- F[Database Schema<br/>API Framework<br/>Authentication]
    B -.- G[Business Logic<br/>API Endpoints<br/>Basic UI]
    C -.- H[External Services<br/>Full UI Integration<br/>Error Handling]
    D -.- I[Unit Tests<br/>Integration Tests<br/>Performance Tests]
    E -.- J[Documentation<br/>Monitoring<br/>Launch]
```


## Definition of Done
- [ ] All user stories implemented
- [ ] Test coverage > 80%
- [ ] Performance benchmarks met
- [ ] Security review passed
- [ ] Documentation complete

## Measurable Outcomes
- Metric 1: [Target value]
- Metric 2: [Target value]
- User satisfaction: [Target score]

# Cadeia Lógica de Dependências  
<!-- [Defina a ordem lógica de desenvolvimento:
- Quais funcionalidades precisam ser construídas primeiro (fundação)
- Chegar o mais rápido possível em algo utilizável/visível no front-end que funcione
- Planejar e dimensionar corretamente cada funcionalidade para que seja atômica, mas que também possa ser expandida e melhorada conforme o desenvolvimento avança] -->

## Implementation Priority
1. **Foundation**: Core infrastructure and setup
2. **MVP Features**: Minimum viable functionality
3. **Enhanced Features**: Additional capabilities
4. **Polish**: Performance, UX improvements
5. **Production Ready**: Full testing and deployment



# Riscos e Mitigações  
<!-- [Identifique riscos potenciais e como serão tratados:
- Desafios técnicos
- Definição do MVP que possa ser evoluído
- Restrições de recursos] -->


#### Devil's Advocate Analysis
```yaml
challenges:
  technical_risks:
    - risk: "Performance at scale"
      mitigation: "Implement caching layer"
    
    - risk: "Third-party API reliability"
      mitigation: "Build fallback mechanisms"
  
  business_risks:
    - risk: "User adoption"
      mitigation: "Phased rollout with feedback loops"
    
    - risk: "Scope creep"
      mitigation: "Strict MVP definition"
  
  edge_cases:
    - scenario: "No network connectivity"
      handling: "Offline mode with sync"
    
    - scenario: "Concurrent updates"
      handling: "Optimistic locking"
```


# Apêndice  
<!-- [Inclua quaisquer informações adicionais:
- Descobertas de pesquisa
- Especificações técnicas] -->

## MUST READ - Include these in your context window
- url: https://ai.pydantic.dev/agents/
  why: Core agent creation patterns
  
- url: https://ai.pydantic.dev/multi-agent-applications/
  why: Multi-agent system patterns, especially agent-as-tool
  
- url: https://developers.google.com/gmail/api/guides/sending
  why: Gmail API authentication and draft creation
  
- url: https://api-dashboard.search.brave.com/app/documentation
  why: Brave Search API REST endpoints
  
- file: examples/agent/agent.py
  why: Pattern for agent creation, tool registration, dependencies
  
- file: examples/agent/providers.py
  why: Multi-provider LLM configuration pattern
  
- file: examples/cli.py
  why: CLI structure with streaming responses and tool visibility

- url: https://github.com/googleworkspace/python-samples/blob/main/gmail/snippet/send%20mail/create_draft.py
  why: Official Gmail draft creation example

</PRD>
