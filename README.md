 <p align="center">
  <img src=".images-cdn/meraki-shop-logo.png" width="250px" >
</p>
<br>

> Meraki is a Greek word that means "to do something with soul, creativity or love"


## 📝 Project Description

Meraki Shop is an e-commerce platform for collectors of action figures, superheroes, and characters from movies and series, focused on collectors, selling unique and limited pieces, allowing the purchase of one figure at a time. The mission is to offer a safe and exclusive space for enthusiasts to find and acquire collectibles. The project was developed with the goal of providing a fluid and safe shopping experience, from viewing products to managing orders.


## Stack

- [Laravel 12](https://laravel.com/)
- [Vue.js 3](https://vuejs.org/)
- [TypeScript](https://www.typescriptlang.org/)
- [PostgreSQL](https://www.postgresql.org/)
- [WorkOS](https://workos.com/)
- [CDN para imagens com Statically](https://statically.io/)

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
```

### Accessing the Application

- 🏠 Main application: http://localhost:8086
- 📖 Documentation of API: http://localhost:8086/docs/api
- 📚 Documentation of Project in Vitepress: http://localhost:5175
