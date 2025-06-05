# Autenticação com Token

Este sistema gerencia a autenticação via token JWT armazenado em cookie `X-API-TOKEN`.

## Endpoints Protegidos

Os seguintes endpoints exigem autenticação e o token será enviado automaticamente:

- `/api/users`
- `/api/address`
- `/api/credit-card`
- `/api/token`

## Uso Básico

A autenticação é gerenciada automaticamente. Para endpoints protegidos, o token é enviado sem intervenção manual.

```typescript
// O token é enviado automaticamente para endpoints protegidos
await api.get('/users');

// Para endpoints não protegidos, o token não é enviado por padrão
await api.get('/products');
```

## Forçar Uso do Token

Para forçar o uso do token em endpoints não protegidos:

```typescript
// Usando apiService
await apiService.get('/products', 1, true); // useToken = true

// Usando axios diretamente
await api.get('/products', { useToken: true });
```

## Verificar Autenticação

```typescript
import { useAuth } from '@/composables/useAuth';

const { hasToken, checkAuthentication, requireAuth } = useAuth();

// Verificar se tem token
if (hasToken.value) {
  // Tem token, mas ainda precisa verificar se é válido
  const isAuthenticated = await checkAuthentication();
}

// Verificar e redirecionar se não estiver autenticado
await requireAuth();
```

## Obter Token

Para casos onde você precisa acessar o token diretamente:

```typescript
import { useAuth } from '@/composables/useAuth';
import { getApiToken } from '@/utils/cookies';
import { prepareAuthHeaders } from '@/utils/auth';

// Opção 1: Via composable
const { getToken } = useAuth();
const token = getToken();

// Opção 2: Diretamente do cookie
const token = getApiToken();

// Opção 3: Obter headers prontos para uso
const headers = prepareAuthHeaders();
// { Authorization: 'Bearer xxx...' }
```

## Logout

```typescript
import { useAuth } from '@/composables/useAuth';

const { logout } = useAuth();
logout(); // Remove o cookie e faz logout via API
``` 