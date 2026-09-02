# Documentação da API

## Endpoints da API

A API é organizada por recursos, seguindo o padrão REST. Cada recurso possui, em geral, operações de consulta, cadastro, atualização, inativação lógica (*soft delete*) e exclusão permanente.

---

# Padrão das Rotas

Todos os recursos da API seguem o mesmo padrão de endpoints.

| Método HTTP | Endpoint | Descrição |
|-------------|----------|-----------|
| **GET** | `/recurso` | Lista todos os registros ativos. |
| **GET** | `/recurso/{id}` | Retorna um registro específico. |
| **POST** | `/recurso` | Cadastra um novo registro. |
| **PUT** | `/recurso/{id}` | Atualiza um registro existente. |
| **DELETE** | `/recurso/inactive/{id}` | Realiza exclusão lógica (*active = 0*). |
| **DELETE** | `/recurso/{id}` | Remove definitivamente o registro do banco de dados. |

---

# Autenticação

A API utiliza autenticação baseada em **JWT (JSON Web Token)**.

Após realizar o login, o cliente recebe um token que deve ser enviado nas requisições protegidas através do cabeçalho HTTP.

Exemplos:

```http
Authorization: Bearer <token>
```

ou

```http
token: <token>
```

A validação é realizada pelo método `authToken()` da classe `Api`.

---

# Níveis de Permissão

A API utiliza dois níveis de acesso.

| Tipo | Descrição |
|------|-----------|
| **1** | Administrador |
| **2** | Usuário comum |

Cada endpoint verifica automaticamente a permissão necessária antes da execução da operação.

---

# Recursos Disponíveis

## Usuários

**Base URL**

```text
/users
```

### Endpoints

| Método | Endpoint | Autenticação |
|---------|----------|--------------|
| GET | `/users` | Não |
| POST | `/users/register` | Não |
| POST | `/users/login` | Não |
| PUT | `/users/update` | Usuário (Tipo 2) |
| DELETE | `/users/inactive` | Usuário (Tipo 2) |
| DELETE | `/users/delete` | Usuário (Tipo 2) |
| POST | `/users/register-admin` | Administrador (Tipo 1) |
| POST | `/users/login-admin` | Não |
| PUT | `/users/update-admin` | Administrador (Tipo 1) |

---

## Tipos de Usuário

**Base URL**

```text
/users/types
```

| Método | Endpoint | Autenticação |
|---------|----------|--------------|
| GET | `/` | Não |
| GET | `/{id}` | Não |
| POST | `/` | Administrador (Tipo 1) |
| PUT | `/{id}` | Administrador (Tipo 1) |
| DELETE | `/inactive/{id}` | Administrador (Tipo 1) |
| DELETE | `/{id}` | Administrador (Tipo 1) |

---

## Categorias

**Base URL**

```text
/categories
```

Implementa um CRUD completo.

- Leitura pública.
- Cadastro, atualização, inativação e exclusão exigem autenticação de **Usuário (Tipo 2)**.

---

## Produtos

**Base URL**

```text
/products
```

Implementa um CRUD completo.

- Leitura pública.
- Cadastro, atualização, inativação e exclusão exigem autenticação de **Usuário (Tipo 2)**.

---

## Clientes

**Base URL**

```text
/customers
```

Implementa um CRUD completo seguindo o padrão da API.

---

## Pedidos

**Base URL**

```text
/orders
```

Implementa um CRUD completo seguindo o padrão da API.

---

## Itens do Pedido

**Base URL**

```text
/orders/item
```

Implementa um CRUD completo seguindo o padrão da API.

---

## Status dos Pedidos

**Base URL**

```text
/order/status
```

Implementa um CRUD completo seguindo o padrão da API.

---

## Categorias do FAQ

**Base URL**

```text
/faqs/types
```

Implementa um CRUD completo seguindo o padrão da API.

---

## Perguntas Frequentes (FAQ)

**Base URL**

```text
/faqs
```

Implementa um CRUD completo seguindo o padrão da API.

---

# Estrutura das Respostas

Todos os endpoints retornam respostas em formato **JSON**, seguindo um padrão único.

## Exemplo de sucesso

```json
{
    "code": 200,
    "type": "success",
    "status": "success",
    "message": "Operação realizada com sucesso.",
    "data": {}
}
```

## Exemplo de erro

```json
{
    "code": 404,
    "type": "error",
    "status": "not_found",
    "message": "Recurso não encontrado."
}
```

---

# Códigos HTTP Utilizados

| Código | Significado |
|---------|-------------|
| **200** | Operação realizada com sucesso. |
| **201** | Recurso criado com sucesso. |
| **400** | Requisição inválida ou parâmetros incorretos. |
| **401** | Usuário não autenticado ou sem permissão. |
| **404** | Recurso não encontrado. |
| **500** | Erro interno do servidor. |

---

# Observações

- A API segue o padrão REST.
- Todas as respostas são retornadas em formato JSON.
- Os recursos utilizam operações CRUD padronizadas.
- A autenticação é baseada em JWT.
- Endpoints protegidos exigem o envio de um token válido no cabeçalho da requisição.