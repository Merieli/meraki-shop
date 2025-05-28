# Coding Standards - APIs Laravel Tray

Este documento define os padrões de codificação para desenvolvimento de APIs em Laravel utilizados na Tray. Estes padrões são fundamentais para manter a consistência, legibilidade e manutenibilidade do código.

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

### Implementação

```php
<?php

namespace App\Services;

use App\Contracts\Services\ProductServiceInterface;
use App\Facades\Repositories\ProductRepository;
use App\Exceptions\ClientException;
use Illuminate\Support\Facades\Validator;

class ProductService implements ProductServiceInterface
{
    public function create(array $data): ProductEntity
    {
        $this->validateProductData($data);

        if ($this->isDuplicateProduct($data)) {
            throw new ClientException('Produto já existe');
        }

        return ProductRepository::create($data);
    }

    private function validateProductData(array $data): void
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
```

## Interfaces

### Obrigatoriedade

- **Todos** os métodos públicos de Services e Repositories **DEVEM** ter uma interface
- Classes sempre devem depender de interfaces, nunca de classes concretas

### Implementação

```php
<?php

namespace App\Contracts\Services;

use App\Entities\ProductEntity;

interface ProductServiceInterface
{
    /**
     * Cria um novo produto
     *
     * @param array $data Dados do produto
     * @return ProductEntity
     * @throws \App\Exceptions\ClientException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(array $data): ProductEntity;
}
```

### Regras

- ✅ Documente completamente na interface
- ✅ Declare todas as exceptions que podem ser lançadas
- ✅ Use tipagem forte

## Facades

### Propósito

- Simplificar injeção de dependências
- Facilitar criação de mocks para testes
- Representar métodos de uma interface

### Implementação

```php
<?php

namespace App\Facades\Services;

use App\Contracts\Services\ProductServiceInterface;
use Illuminate\Support\Facades\Facade;

class ProductService extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ProductServiceInterface::class;
    }
}
```

### Service Provider Binding

```php
<?php

namespace App\Providers;

use App\Contracts\Services\ProductServiceInterface;
use App\Services\ProductService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            ProductServiceInterface::class,
            ProductService::class
        );
    }
}
```

## Repositories

### Responsabilidades

- Encapsular acesso a dados (APIs externas, banco de dados)
- Conter **todas** as chamadas necessárias para reutilização
- Isolar Models do resto da aplicação

### Implementação

```php
<?php

namespace App\Repositories;

use App\Contracts\Repositories\ProductRepositoryInterface;
use App\Models\Product;
use App\Entities\ProductEntity;

class ProductRepository implements ProductRepositoryInterface
{
    public function find(int $id): ?ProductEntity
    {
        $model = Product::find($id);

        return $model ? new ProductEntity($model->toArray()) : null;
    }

    public function create(array $data): ProductEntity
    {
        $model = Product::create($data);

        return new ProductEntity($model->toArray());
    }
}
```

### Regras

- ✅ Use Entities para retorno, não Models
- ✅ Implemente interface correspondente
- ✅ Encapsule toda lógica de acesso a dados
- ❌ Models **só existem** dentro do Repository

## DocBlocks

### Métodos Públicos com Interface

- Documentação completa fica **apenas na interface**
- Classe concreta usa `{@inheritDoc}`

```php
// Interface
interface ProductServiceInterface
{
    /**
     * Cria um novo produto
     *
     * @param array $data Dados do produto
     * @return ProductEntity
     * @throws ClientException
     */
    public function create(array $data): ProductEntity;
}

// Classe concreta
class ProductService implements ProductServiceInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(array $data): ProductEntity
    {
        // implementação
    }
}
```

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

## Validações e Exceptions

### Validações de Request

Use o **validador nativo do Laravel** (retorna 422):

```php
public function store(Request $request): JsonResponse
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users'
    ]);

    if ($validator->fails()) {
        throw new ValidationException($validator);
    }

    // continua processamento
}
```

### Try/Catch para Monitoramento

```php
try {
    // lógica principal
} catch (Exception $e) {
    // Valida pelo status code para salvar apenas erros relevantes no NewRelic
    if ($this->shouldReportToNewRelic($e)) {
        report($e);
    }

    throw $e;
}
```

## Padrões de Código

### Agrupamento de Variáveis

Agrupe variáveis relacionadas e alinhe o sinal de igualdade:

```php
// ✅ Correto
$productName  = $data['name'];
$productPrice = $data['price'];
$productStock = $data['stock'];

// ❌ Incorreto
$productName = $data['name'];
$productPrice = $data['price'];
$productStock = $data['stock'];
```

### Imports (PSR-12)

Aninhe importações semelhantes:

```php
// ✅ Correto
use App\Http\Controllers\{
    ProductController,
    CategoryController,
    BrandController
};

use App\Services\{
    ProductService,
    CategoryService
};

// ❌ Incorreto
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
```

### Constantes

Use constantes para strings que se repetem:

```php
class ProductService
{
    private const STATUS_ACTIVE   = 'active';
    private const STATUS_INACTIVE = 'inactive';

    public function activate(int $id): void
    {
        $this->updateStatus($id, self::STATUS_ACTIVE);
    }
}
```

## Middleware

### Validações Específicas

Use middleware para validações específicas do contexto:

```php
// Para campanhas - validação de wizard steps
Route::group(['middleware' => ['wizard.steps']], function () {
    Route::post('/campaign', [CampaignController::class, 'store']);
});
```

## Ferramentas de Qualidade

### Configurações Existentes

- **PHPStan**: `phpstan.neon`
- **PHP Mess Detector**: `phpmd-ruleset.xml`
- **Pint**: `pint.json`
- **GrumPHP**: `grumphp.yml`

### Scripts de Validação

Execute antes de cada commit:

```bash
./code_validations.sh
```
