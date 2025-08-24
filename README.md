 <p align="center">
  <img src=".images-cdn/meraki-shop-logo.png" width="250px" >
</p>
<br>

> Meraki is a Greek word that means "to do something with soul, creativity or love"


## 📝 Project Description

Meraki Shop is an e-commerce platform for collectors of action figures, superheroes, and characters from movies and series, focused on collectors, selling unique and limited pieces, allowing the purchase of one figure at a time. The mission is to offer a safe and exclusive space for enthusiasts to find and acquire collectibles. The project was developed with the goal of providing a fluid and safe shopping experience, from viewing products to managing orders.


## Stack

- **[Laravel 12](https://laravel.com/)**
- **[Vue.js 3](https://vuejs.org/)**
- **[PostgreSQL](https://www.postgresql.org/)**

#### Frontend Tools

- **[TypeScript](https://www.typescriptlang.org/)**: Static typing for JavaScript
- **[Vee-Validate](https://vee-validate.logaretm.com/v4/)**: Form validation management
- **[Zod](https://zod.dev/)**: Schema validation and data typing
- **[Tailwind CSS](https://tailwindcss.com/)**: CSS utility library for rapid styling
- **[Lucide Vue Next](https://lucide.dev/guide/)**: Icon library
- **[Reka UI](https://reka-ui.com/)**: Interface component library
- **[VueUse](https://vueuse.org/)**: Reusable logic for Vue components
- **[ESLint](https://eslint.org/docs/latest/use/configure/rules)**: Linting for JavaScript/TypeScript
- **[Vitest](https://vitest.dev/api/vi.html)**: JavaScript testing framework
- **[Vue Test Utils](https://test-utils.vuejs.org/guide/essentials/a-crash-course.html)**: Testing utilities for Vue
- **[Ziggy JS](https://github.com/tighten/ziggy?ref=madewithlaravel.com)**: use Laravel routes in JavaScript

#### Backend Tools

- **[Laravel Sanctum](https://laravel.com/docs/12.x/sanctum)**: API authentication
- **[Laravel Pint](https://laravel.com/docs/12.x/pint)**: PHP code formatting
- **[PHPStan](https://phpstan.org/)**: Static PHP code analysis
- **[Prettier](https://prettier.io/)**: Code formatting
- **[Laravel Tinker](https://laravel.com/docs/12.x/artisan#tinker)**: Interactive REPL for Laravel
- **[Laravel Pail](https://laravel.com/docs/12.x/pail)**: Real-time log viewer
- **[Laravel Debugbar](https://github.com/barryvdh/laravel-debugbar)**: Development debugging tool
- **[Scramble](https://scramble.dedoc.co/)**: OpenAPI documentation generator

#### General Tools

- **[Inertia.js](https://inertiajs.com/)**: Integration between Laravel and Vue.js
- **[Husky](https://typicode.github.io/husky/)**: Git hooks for validations
- **[Statically](https://statically.io/)**: CDN for images
- **[WorkOS](https://workos.com/)**: User authentication and management
- **[VitePress](https://vitepress.dev/)**: Static Site Generator for project documentation
- **[Mermaid](https://github.com/mermaid-js/mermaid)**: For generating graphs and diagrams displayed in the vitepress documentation


## 📖  Installation Guide

### ✅ Prequisites

- Docker
- Docker Compose
- Git
- Account in [WorkOS](https://workos.com/)

### 🏳️ Docker Setup & Development

1. Clone the repository and enter the directory:

```sh
git clone <repository-url>
cd meraki-shop
```

2. Copy the environment file:

```sh
cp .env.example .env
```

> 💡 Prepare as keys necessárias para o projeto:
> - Todas que começam com `WORKOS`, depois os `DB_PASSWORD` e `DB_USERNAME` que deve ser o usuário da sua máquina

3. Start an interactive Docker session to set up the project:

```sh
docker compose build

docker compose up -d

docker exec -it meraki-shop-dev-php-fpm sh
```


4. Inside the Docker container, install dependencies and set up the project:

```sh
# Install PHP dependencies
cmp install

# Install Node.js dependencies
npm install

# Generate a manifest of vite
npm run build

# Generate application key
php artisan key:generate

# Run migrations
php artisan migrate
```


### 🛠️ Common Development Commands

These are the standard commands used in development:

**📦 Package Management**
```sh
# PHP Dependencies
composer install

# Node.js Dependencies
npm install

# Build the dependencies to generate manifest
npm run build
```


**🖥️ Development**
```sh
# Start Laravel development server, queue listener, log watcher and Vite
cmp dev

# Start documentation development server
npm run docs:dev
```


**🧹 Code Quality**
```sh
# Format PHP code
cmp lint:pint

# Run PHPStan analysis
cmp check

# Run all validations
cmp valid

# Format frontend code
npm run format
```


**🧪 Testing**
```sh
cmp test

# Executar todos os testes frontend
npm test

# Executar testes frontend em modo watch
npm run test:watch
```


### Accessing the Application

- 🏠 Main application: http://localhost:8086
- 📖 Documentation of API: http://localhost:8086/docs/api
- 📚 Documentation of Project in Vitepress: http://localhost:5175
