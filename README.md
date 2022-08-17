# Controle Financeiro

API REST para cadastro de finanças do usuário com os seguintes endpoints:

* __'/api/receitas'__ - CRUD para cadastro de receitas (recebimento de valores)

* __'/api/despesas'__ - CRUD para cadastro de receitas (gastos). Pode ser incluída uma categoria

* __'api/resumo/{ano}/{mes}'__ - Traz relatório com informações sobre receitas, despesas, saldo e agrupamento de despesas em cada categoria

* __'api/auth/login'__ - realiza login a partir de e-mail e senha

* __'api/auth/register'__ - realiza registro do usuário, com email, nome e password

### Categorias aceitas:
* Alimentação
* Saúde
* Moradia
* Transporte
* Educação
* Lazer
* Imprevistos
* Outras
  

