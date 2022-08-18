# Desafio Backend Alura - 4

API REST desenvolvida durante o Desafio da Alura utilizando [Laravel 9.x](https://laravel.com/docs/9.x) e PHP 8.0.13.

## Rotas

### Autenticação:

Com exceção do login, e registro, todos os endpoints somente podem ser consumidos por usuários autenticados, enviando o cabeçalho de requisição ```Authorization``` com a informação ```Bearer <<JWTToken>>```.

Todas as rotas de autenticação funcionam exclusivamente com o método POST


|Rota | Serviço | Parâmetros| Resposta(s)|
|--------|--------|-----------|---------|
|__/auth/login__|Realiza o login do usuário| Corpo/JSON (necessários): "email" (string), "password" (string) | 200 - Sucesso <br> 401 - Login mal sucedido  |
|__/auth/register__|Realiza o cadastro de usuário|Corpo/JSON (necessários): "email" (string), "password" (string, min. 8 caracteres), "nome" (string) |201 - Sucesso <br> 422 - Email já cadastrado |
|__/auth/refresh__| Atualiza a validade do token do usuário (padrão 1h)| Cabeçalho com o token |200 - Sucesso |
|__/auth/logout__|Invalida o token|Cabeçalho com o token |200 - Sucesso |
|__/auth/me__|Retorna o usuário logado|Cabeçalho com o token |200 - Sucesso |

<br><br><br><br>

### Receitas:

- __/api/receitas__


|Método | Serviço | Parâmetros| Resposta(s)|
|--------|--------|-----------|---------|
|__POST__|Registro de uma receita| Corpo/JSON (necessários): "descricao" (string), "valor" (float), "data" (string formato "dd/mm/yyyy") | 201 - Sucesso <br> 409 - Já existente com mesma descrição, no mesmo mês <br> 422 - Ausente algum dos parâmetros  |
|__GET__|Pesquisa de receitas do usuário|Query (opcional): "descricao", para filtrar|200 - Sucesso (15 por página)|

<br><br><br><br>

- __/api/receitas/{id}__

|Método | Serviço | Parâmetros| Resposta(s)|
|--------|--------|-----------|---------|
|__GET__|Busca receita especificada| | 200 - Sucesso <br> 404 - Receita não encontrada (ou não foi registrada pelo usuário)  |
|__PUT__|Atualização de uma receita|Corpo/JSON (necessários): "descricao" (string), "valor" (float), "data" (string formato "dd/mm/yyyy")|200 - Sucesso <br> 409 - Já existente com mesma descrição, no mesmo mês <br> 422 - Ausente algum dos parâmetros <br> 403 - Receita pertence a outro usuário|
|__DELETE__|Apaga uma receita||200 - Sucesso <br> 403 - Receita pertence a outro usuário|

<br><br><br><br>

- __/api/receitas/{ano}/{mes}__
  
|Método | Serviço | Parâmetros| Resposta(s)|
|--------|--------|-----------|---------|
|__GET__|Busca receitas registradas pelo usuário no ano (integer) e mês (integer) informados| | 200 - Sucesso <br> |


<br><br><br><br>

### Despesas:

- __/api/despesas__


|Método | Serviço | Parâmetros| Resposta(s)|
|--------|--------|-----------|---------|
|__POST__|Registro de uma despesa| Corpo/JSON (necessários): "descricao" (string), "valor" (float), "data" (string formato "dd/mm/yyyy")<br> Opcionais: "fixa" (boolean), "categoria"* (string) | 201 - Sucesso <br> 409 - Já existente com mesma descrição, no mesmo mês <br> 422 - Ausente algum dos parâmetros  |
|__GET__|Pesquisa de receitas do usuário|Query (opcional - filtros aceitos): _"descricao"_, _"categoria"_|200 - Sucesso (15 por página)|

\* Categorias aceitas:
    
    Alimentação
    Saúde
    Moradia
    Transporte
    Educação
    Lazer
    Imprevistos
    Outras



<br><br><br><br>

- __/api/despesas/{id}__

|Método | Serviço | Parâmetros| Resposta(s)|
|--------|--------|-----------|---------|
|__GET__|Busca despesa especificada| | 200 - Sucesso <br> 404 - Despesa não encontrada (ou não foi registrada pelo usuário)  |
|__PUT__|Atualização de uma despesa|Corpo/JSON (necessários): "descricao", "valor", "data" (formato "dd/mm/yyyy")|200 - Sucesso <br> 409 - Já existente com mesma descrição, no mesmo mês <br> 422 - Ausente algum dos parâmetros <br> 403 - Despesa pertence a outro usuário|
|__DELETE__|Apaga uma despesa||200 - Sucesso <br> 403 - Despesa pertence a outro usuário|

<br><br><br><br>

- __/api/despesas/{ano}/{mes}__
  
|Método | Serviço | Parâmetros| Resposta(s)|
|--------|--------|-----------|---------|
|__GET__|Busca despesas registradas pelo usuário no ano (integer) e mês (integer) informados| | 200 - Sucesso <br> |


<br><br><br><br>


### Resumo:
- __/api/resumo/{ano}/{mes}__


|Método | Serviço | Parâmetros| Resposta(s)|
|--------|--------|-----------|---------|
|__GET__|Traz um resumo com o valor total das receitas e despesas do usuário no ano (integer) e mês (integer) informados, com registro de despesas agrupadas por categoria e saldo final no mês| | 200 - Sucesso <br> |

Exemplo de resposta: 
<pre>
{
    "receitas": 2000,
    "despesas": 823.84,
    "saldo": 1176.16,
    "despesas_por_categoria": {
        "Alimentação": 315.05,
        "Saúde": 293.74,
        "Moradia": 0,
        "Transporte": 215.05,
        "Educação": 0,
        "Lazer": 0,
        "Imprevistos": 0,
        "Outras": 0
    }
}
</pre>

<br><br><hr>

## Dependências
```
Composer
php 8.0
Banco de Dados (padrão é mysql)
```

<br><br><hr>

## Passo a passo para instalação do projeto

### Baixar o projeto
```
git clone https://github.com/Thormes/controle-financeiro.git
```

### Instalar o projeto (na pasta onde baixado)
```
composer install
```

### Configurar o banco de dados

[Configuração de Banco de Dados Laravel](https://laravel.com/docs/9.x/database)

<br>

### Realizar migrações
```
php artisan migrate
```

### Publicar provider para autenticação
```
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
```

### Criar chave JWT
```
php artisan jwt:secret
```

### Inicializar o servidor

```
php artisan serve
```

<br><br><hr>

[Versão online da aplicação (heroku)](https://thormes-controle-financeiro.herokuapp.com/)
