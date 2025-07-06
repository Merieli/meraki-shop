# Coding Standards - APIs Laravel

Este documento define os padrões de codificação para desenvolvimento de APIs em Laravel. Estes padrões são fundamentais para manter a consistência, legibilidade e manutenibilidade do código.

- Laravel 12
- Starter Kit Vue

## Princípios base:

- KISS
- Object Calisthenics

## Arquitetura Geral

### Fluxo de Execução

- **Rotas**: Começam pelo `api.php`
- **Middleware**: Validações específicas (ex: wizard steps em campanhas)
- **Controllers**: Recebem parâmetros e delegam para Services
- **Services**: Contêm regras de negócio e validações
- **Repositories**: Encapsulam acesso a dados
- **Models**: Existem apenas dentro dos Repositories

### Injeção de Dependências

- Use **Facades** para injeção de dependências
- ServiceProvider faz o bind entre interfaces e classes concretas
- Três formas de instanciação: `app()->make()`, `new ClassXPTO()`, ou Facades (preferível)

## Controllers

### Responsabilidades

Os controllers devem ser responsáveis **APENAS** por:

- Receber parâmetros e passá-los para Services ou Repositories via Facades
- Implementar controle de permissões (ACL) quando necessário

### Implementação

```php
<?php

namespace App\Http\Controllers;

use App\Facades\Services\ProductService;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        return $this->getResponse()->dispatch(function () {
            $query = $this->getQueries();
            return ProductService::list($query);
        });
    }

    public function show(int $id): JsonResponse
    {
        return $this->getResponse()->dispatch(function () use ($id) {
            return ProductService::find($id);
        });
    }
}
```

### Regras

- ✅ Use tipagem forte para parâmetros e retornos
- ✅ Delegue toda lógica para Services
- ✅ Use o padrão ResponseFactory para respostas consistentes
- ❌ Nunca implemente regras de negócio no Controller
- ❌ Nunca acesse Models diretamente

## Services

### Responsabilidades

Os Services são responsáveis por:

- Validação dos dados recebidos por parâmetros
- Implementação das regras de negócio da aplicação
- Orquestração entre diferentes Repositories

### Dependências Permitidas

- ✅ Interfaces
- ✅ Outros Services
- ✅ Repositories
- ✅ Traits
- ❌ **NUNCA** Models diretamente

### Métodos Privados

**DEVEM** ter documentação completa:

```php
/**
 * Valida se o produto já existe no sistema
 *
 * @param array $data Dados do produto
 * @return bool
 */
private function isDuplicateProduct(array $data): bool
{
    // implementação
}
```

## Ferramentas de Qualidade

### Configurações Existentes

- **PHPStan**: `phpstan.neon`
- **PHP Mess Detector**: `phpmd-ruleset.xml`
- **Pint**: `pint.json`

### Scripts de Validação

Execute antes de cada commit:

```bash
./code_validations.sh
```
