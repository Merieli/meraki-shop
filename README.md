# 🛍️ Meraki Shop

> Meraki é uma palavra grega que significa "fazer algo com alma, criatividade ou amor"

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
> - Todas que começam com `WORKOS`

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
- ⚡ Development server with Vite HMR: http://localhost:5173
- 📚 Documentation of Project in Vitepress: http://localhost:5175
- 📖 Documentation of API: http://localhost:8086/docs/api
