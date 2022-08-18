<!DOCTYPE html>
<html>

<head>
    <title>Descrição da API</title>
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8">

    <style>
        /* https://github.com/microsoft/vscode/blob/master/extensions/markdown-language-features/media/markdown.css */
        /*---------------------------------------------------------------------------------------------
 *  Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/

        body {
            font-family: var(--vscode-markdown-font-family, -apple-system, BlinkMacSystemFont, "Segoe WPC", "Segoe UI", "Ubuntu", "Droid Sans", sans-serif);
            font-size: var(--vscode-markdown-font-size, 14px);
            padding: 0 26px;
            line-height: var(--vscode-markdown-line-height, 22px);
            word-wrap: break-word;
        }

        #code-csp-warning {
            position: fixed;
            top: 0;
            right: 0;
            color: white;
            margin: 16px;
            text-align: center;
            font-size: 12px;
            font-family: sans-serif;
            background-color: #444444;
            cursor: pointer;
            padding: 6px;
            box-shadow: 1px 1px 1px rgba(0, 0, 0, .25);
        }

        #code-csp-warning:hover {
            text-decoration: none;
            background-color: #007acc;
            box-shadow: 2px 2px 2px rgba(0, 0, 0, .25);
        }

        body.scrollBeyondLastLine {
            margin-bottom: calc(100vh - 22px);
        }

        body.showEditorSelection .code-line {
            position: relative;
        }

        body.showEditorSelection .code-active-line:before,
        body.showEditorSelection .code-line:hover:before {
            content: "";
            display: block;
            position: absolute;
            top: 0;
            left: -12px;
            height: 100%;
        }

        body.showEditorSelection li.code-active-line:before,
        body.showEditorSelection li.code-line:hover:before {
            left: -30px;
        }

        .vscode-light.showEditorSelection .code-active-line:before {
            border-left: 3px solid rgba(0, 0, 0, 0.15);
        }

        .vscode-light.showEditorSelection .code-line:hover:before {
            border-left: 3px solid rgba(0, 0, 0, 0.40);
        }

        .vscode-light.showEditorSelection .code-line .code-line:hover:before {
            border-left: none;
        }

        .vscode-dark.showEditorSelection .code-active-line:before {
            border-left: 3px solid rgba(255, 255, 255, 0.4);
        }

        .vscode-dark.showEditorSelection .code-line:hover:before {
            border-left: 3px solid rgba(255, 255, 255, 0.60);
        }

        .vscode-dark.showEditorSelection .code-line .code-line:hover:before {
            border-left: none;
        }

        .vscode-high-contrast.showEditorSelection .code-active-line:before {
            border-left: 3px solid rgba(255, 160, 0, 0.7);
        }

        .vscode-high-contrast.showEditorSelection .code-line:hover:before {
            border-left: 3px solid rgba(255, 160, 0, 1);
        }

        .vscode-high-contrast.showEditorSelection .code-line .code-line:hover:before {
            border-left: none;
        }

        img {
            max-width: 100%;
            max-height: 100%;
        }

        a {
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        a:focus,
        input:focus,
        select:focus,
        textarea:focus {
            outline: 1px solid -webkit-focus-ring-color;
            outline-offset: -1px;
        }

        hr {
            border: 0;
            height: 2px;
            border-bottom: 2px solid;
        }

        h1 {
            padding-bottom: 0.3em;
            line-height: 1.2;
            border-bottom-width: 1px;
            border-bottom-style: solid;
        }

        h1,
        h2,
        h3 {
            font-weight: normal;
        }

        table {
            border-collapse: collapse;
        }

        table>thead>tr>th {
            text-align: left;
            border-bottom: 1px solid;
        }

        table>thead>tr>th,
        table>thead>tr>td,
        table>tbody>tr>th,
        table>tbody>tr>td {
            padding: 5px 10px;
        }

        table>tbody>tr+tr>td {
            border-top: 1px solid;
        }

        blockquote {
            margin: 0 7px 0 5px;
            padding: 0 16px 0 10px;
            border-left-width: 5px;
            border-left-style: solid;
        }

        code {
            font-family: Menlo, Monaco, Consolas, "Droid Sans Mono", "Courier New", monospace, "Droid Sans Fallback";
            font-size: 1em;
            line-height: 1.357em;
        }

        body.wordWrap pre {
            white-space: pre-wrap;
        }

        pre:not(.hljs),
        pre.hljs code>div {
            padding: 16px;
            border-radius: 3px;
            overflow: auto;
        }

        pre code {
            color: var(--vscode-editor-foreground);
            tab-size: 4;
        }

        /** Theming */

        .vscode-light pre {
            background-color: rgba(220, 220, 220, 0.4);
        }

        .vscode-dark pre {
            background-color: rgba(10, 10, 10, 0.4);
        }

        .vscode-high-contrast pre {
            background-color: rgb(0, 0, 0);
        }

        .vscode-high-contrast h1 {
            border-color: rgb(0, 0, 0);
        }

        .vscode-light table>thead>tr>th {
            border-color: rgba(0, 0, 0, 0.69);
        }

        .vscode-dark table>thead>tr>th {
            border-color: rgba(255, 255, 255, 0.69);
        }

        .vscode-light h1,
        .vscode-light hr,
        .vscode-light table>tbody>tr+tr>td {
            border-color: rgba(0, 0, 0, 0.18);
        }

        .vscode-dark h1,
        .vscode-dark hr,
        .vscode-dark table>tbody>tr+tr>td {
            border-color: rgba(255, 255, 255, 0.18);
        }
    </style>

    <style>
        /* Tomorrow Theme */
        /* http://jmblog.github.com/color-themes-for-google-code-highlightjs */
        /* Original theme - https://github.com/chriskempson/tomorrow-theme */

        /* Tomorrow Comment */
        .hljs-comment,
        .hljs-quote {
            color: #8e908c;
        }

        /* Tomorrow Red */
        .hljs-variable,
        .hljs-template-variable,
        .hljs-tag,
        .hljs-name,
        .hljs-selector-id,
        .hljs-selector-class,
        .hljs-regexp,
        .hljs-deletion {
            color: #c82829;
        }

        /* Tomorrow Orange */
        .hljs-number,
        .hljs-built_in,
        .hljs-builtin-name,
        .hljs-literal,
        .hljs-type,
        .hljs-params,
        .hljs-meta,
        .hljs-link {
            color: #f5871f;
        }

        /* Tomorrow Yellow */
        .hljs-attribute {
            color: #eab700;
        }

        /* Tomorrow Green */
        .hljs-string,
        .hljs-symbol,
        .hljs-bullet,
        .hljs-addition {
            color: #718c00;
        }

        /* Tomorrow Blue */
        .hljs-title,
        .hljs-section {
            color: #4271ae;
        }

        /* Tomorrow Purple */
        .hljs-keyword,
        .hljs-selector-tag {
            color: #8959a8;
        }

        .hljs {
            display: block;
            overflow-x: auto;
            color: #4d4d4c;
            padding: 0.5em;
        }

        .hljs-emphasis {
            font-style: italic;
        }

        .hljs-strong {
            font-weight: bold;
        }
    </style>

    <style>
        /*
 * Markdown PDF CSS
 */

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe WPC", "Segoe UI", "Ubuntu", "Droid Sans", sans-serif, "Meiryo";
            padding: 0 12px;
        }

        pre {
            background-color: #f8f8f8;
            border: 1px solid #cccccc;
            border-radius: 3px;
            overflow-x: auto;
            white-space: pre-wrap;
            overflow-wrap: break-word;
        }

        pre:not(.hljs) {
            padding: 23px;
            line-height: 19px;
        }

        blockquote {
            background: rgba(127, 127, 127, 0.1);
            border-color: rgba(0, 122, 204, 0.5);
        }

        .emoji {
            height: 1.4em;
        }

        code {
            font-size: 14px;
            line-height: 19px;
        }

        /* for inline code */
        :not(pre):not(.hljs)>code {
            color: #C9AE75;
            /* Change the old color so it seems less like an error */
            font-size: inherit;
        }

        /* Page Break : use <div class="page"/> to insert page break
-------------------------------------------------------- */
        .page {
            page-break-after: always;
        }
    </style>

    <script src="https://unpkg.com/mermaid/dist/mermaid.min.js"></script>
</head>

<body>
    <script>
        mermaid.initialize({
            startOnLoad: true,
            theme: document.body.classList.contains('vscode-dark') || document.body.classList.contains('vscode-high-contrast') ?
                'dark' :
                'default'
        });
    </script>
    <h1 id="desafio-backend-alura---4">Desafio Backend Alura - 4</h1>
    <p>API REST desenvolvida durante o Desafio da Alura utilizando <a href="https://laravel.com/docs/9.x">Laravel 9.x</a> e PHP 8.0.13.</p>
    <h2 id="rotas">Rotas</h2>
    <h3 id="autentica%C3%A7%C3%A3o">Autenticação:</h3>
    <p>Com exceção do login, e registro, todos os endpoints somente podem ser consumidos por usuários autenticados, enviando o cabeçalho de requisição <code>Authorization</code> com a informação <code>Bearer &lt;&lt;JWTToken&gt;&gt;</code>.</p>
    <p>Todas as rotas de autenticação funcionam exclusivamente com o método POST</p>
    <table>
        <thead>
            <tr>
                <th>Rota</th>
                <th>Serviço</th>
                <th>Parâmetros</th>
                <th>Resposta(s)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>/auth/login</strong></td>
                <td>Realiza o login do usuário</td>
                <td>Corpo/JSON (necessários): &quot;email&quot; (string), &quot;password&quot; (string)</td>
                <td>200 - Sucesso <br> 401 - Login mal sucedido</td>
            </tr>
            <tr>
                <td><strong>/auth/register</strong></td>
                <td>Realiza o cadastro de usuário</td>
                <td>Corpo/JSON (necessários): &quot;email&quot; (string), &quot;password&quot; (string, min. 8 caracteres), &quot;nome&quot; (string)</td>
                <td>201 - Sucesso <br> 422 - Email já cadastrado</td>
            </tr>
            <tr>
                <td><strong>/auth/refresh</strong></td>
                <td>Atualiza a validade do token do usuário (padrão 1h)</td>
                <td>Cabeçalho com o token</td>
                <td>200 - Sucesso</td>
            </tr>
            <tr>
                <td><strong>/auth/logout</strong></td>
                <td>Invalida o token</td>
                <td>Cabeçalho com o token</td>
                <td>200 - Sucesso</td>
            </tr>
            <tr>
                <td><strong>/auth/me</strong></td>
                <td>Retorna o usuário logado</td>
                <td>Cabeçalho com o token</td>
                <td>200 - Sucesso</td>
            </tr>
        </tbody>
    </table>
    <p><br><br><br><br></p>
    <h3 id="receitas">Receitas:</h3>
    <ul>
        <li><strong>/api/receitas</strong></li>
    </ul>
    <table>
        <thead>
            <tr>
                <th>Método</th>
                <th>Serviço</th>
                <th>Parâmetros</th>
                <th>Resposta(s)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>POST</strong></td>
                <td>Registro de uma receita</td>
                <td>Corpo/JSON (necessários): &quot;descricao&quot; (string), &quot;valor&quot; (float), &quot;data&quot; (string formato &quot;dd/mm/yyyy&quot;)</td>
                <td>201 - Sucesso <br> 409 - Já existente com mesma descrição, no mesmo mês <br> 422 - Ausente algum dos parâmetros</td>
            </tr>
            <tr>
                <td><strong>GET</strong></td>
                <td>Pesquisa de receitas do usuário</td>
                <td>Query (opcional): &quot;descricao&quot;, para filtrar</td>
                <td>200 - Sucesso (15 por página)</td>
            </tr>
        </tbody>
    </table>
    <p><br><br><br><br></p>
    <ul>
        <li><strong>/api/receitas/{id}</strong></li>
    </ul>
    <table>
        <thead>
            <tr>
                <th>Método</th>
                <th>Serviço</th>
                <th>Parâmetros</th>
                <th>Resposta(s)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>GET</strong></td>
                <td>Busca receita especificada</td>
                <td></td>
                <td>200 - Sucesso <br> 404 - Receita não encontrada (ou não foi registrada pelo usuário)</td>
            </tr>
            <tr>
                <td><strong>PUT</strong></td>
                <td>Atualização de uma receita</td>
                <td>Corpo/JSON (necessários): &quot;descricao&quot; (string), &quot;valor&quot; (float), &quot;data&quot; (string formato &quot;dd/mm/yyyy&quot;)</td>
                <td>200 - Sucesso <br> 409 - Já existente com mesma descrição, no mesmo mês <br> 422 - Ausente algum dos parâmetros <br> 403 - Receita pertence a outro usuário</td>
            </tr>
            <tr>
                <td><strong>DELETE</strong></td>
                <td>Apaga uma receita</td>
                <td></td>
                <td>200 - Sucesso <br> 403 - Receita pertence a outro usuário</td>
            </tr>
        </tbody>
    </table>
    <p><br><br><br><br></p>
    <ul>
        <li><strong>/api/receitas/{ano}/{mes}</strong></li>
    </ul>
    <table>
        <thead>
            <tr>
                <th>Método</th>
                <th>Serviço</th>
                <th>Parâmetros</th>
                <th>Resposta(s)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>GET</strong></td>
                <td>Busca receitas registradas pelo usuário no ano (integer) e mês (integer) informados</td>
                <td></td>
                <td>200 - Sucesso <br></td>
            </tr>
        </tbody>
    </table>
    <p><br><br><br><br></p>
    <h3 id="despesas">Despesas:</h3>
    <ul>
        <li><strong>/api/despesas</strong></li>
    </ul>
    <table>
        <thead>
            <tr>
                <th>Método</th>
                <th>Serviço</th>
                <th>Parâmetros</th>
                <th>Resposta(s)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>POST</strong></td>
                <td>Registro de uma despesa</td>
                <td>Corpo/JSON (necessários): &quot;descricao&quot; (string), &quot;valor&quot; (float), &quot;data&quot; (string formato &quot;dd/mm/yyyy&quot;)<br> Opcionais: &quot;fixa&quot; (boolean), &quot;categoria&quot;* (string)</td>
                <td>201 - Sucesso <br> 409 - Já existente com mesma descrição, no mesmo mês <br> 422 - Ausente algum dos parâmetros</td>
            </tr>
            <tr>
                <td><strong>GET</strong></td>
                <td>Pesquisa de receitas do usuário</td>
                <td>Query (opcional - filtros aceitos): <em>&quot;descricao&quot;</em>, <em>&quot;categoria&quot;</em></td>
                <td>200 - Sucesso (15 por página)</td>
            </tr>
        </tbody>
    </table>
    <p>* Categorias aceitas:</p>
    <pre><code>Alimentação
Saúde
Moradia
Transporte
Educação
Lazer
Imprevistos
Outras
</code></pre>
    <p><br><br><br><br></p>
    <ul>
        <li><strong>/api/despesas/{id}</strong></li>
    </ul>
    <table>
        <thead>
            <tr>
                <th>Método</th>
                <th>Serviço</th>
                <th>Parâmetros</th>
                <th>Resposta(s)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>GET</strong></td>
                <td>Busca despesa especificada</td>
                <td></td>
                <td>200 - Sucesso <br> 404 - Despesa não encontrada (ou não foi registrada pelo usuário)</td>
            </tr>
            <tr>
                <td><strong>PUT</strong></td>
                <td>Atualização de uma despesa</td>
                <td>Corpo/JSON (necessários): &quot;descricao&quot;, &quot;valor&quot;, &quot;data&quot; (formato &quot;dd/mm/yyyy&quot;)</td>
                <td>200 - Sucesso <br> 409 - Já existente com mesma descrição, no mesmo mês <br> 422 - Ausente algum dos parâmetros <br> 403 - Despesa pertence a outro usuário</td>
            </tr>
            <tr>
                <td><strong>DELETE</strong></td>
                <td>Apaga uma despesa</td>
                <td></td>
                <td>200 - Sucesso <br> 403 - Despesa pertence a outro usuário</td>
            </tr>
        </tbody>
    </table>
    <p><br><br><br><br></p>
    <ul>
        <li><strong>/api/despesas/{ano}/{mes}</strong></li>
    </ul>
    <table>
        <thead>
            <tr>
                <th>Método</th>
                <th>Serviço</th>
                <th>Parâmetros</th>
                <th>Resposta(s)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>GET</strong></td>
                <td>Busca despesas registradas pelo usuário no ano (integer) e mês (integer) informados</td>
                <td></td>
                <td>200 - Sucesso <br></td>
            </tr>
        </tbody>
    </table>
    <p><br><br><br><br></p>
    <h3 id="resumo">Resumo:</h3>
    <ul>
        <li><strong>/api/resumo/{ano}/{mes}</strong></li>
    </ul>
    <table>
        <thead>
            <tr>
                <th>Método</th>
                <th>Serviço</th>
                <th>Parâmetros</th>
                <th>Resposta(s)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>GET</strong></td>
                <td>Traz um resumo com o valor total das receitas e despesas do usuário no ano (integer) e mês (integer) informados, com registro de despesas agrupadas por categoria e saldo final no mês</td>
                <td></td>
                <td>200 - Sucesso <br></td>
            </tr>
        </tbody>
    </table>
    <p>Exemplo de resposta:</p>
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
    <p><br><br>
        <hr>
    </p>
    <h2 id="depend%C3%AAncias">Dependências</h2>
    <pre class="hljs"><code><div>Composer
php 8.0
Banco de Dados (padrão é mysql)
</div></code></pre>
    <p><br><br>
        <hr>
    </p>
    <h2 id="passo-a-passo-para-instala%C3%A7%C3%A3o-do-projeto">Passo a passo para instalação do projeto</h2>
    <h3 id="baixar-o-projeto">Baixar o projeto</h3>
    <pre class="hljs"><code><div>git clone https://github.com/Thormes/controle-financeiro.git
</div></code></pre>
    <h3 id="instalar-o-projeto-na-pasta-onde-baixado">Instalar o projeto (na pasta onde baixado)</h3>
    <pre class="hljs"><code><div>composer install
</div></code></pre>
    <h3 id="configurar-o-banco-de-dados">Configurar o banco de dados</h3>
    <p><a href="https://laravel.com/docs/9.x/database">Configuração de Banco de Dados Laravel</a></p>
    <br>
    <h3 id="realizar-migra%C3%A7%C3%B5es">Realizar migrações</h3>
    <pre class="hljs"><code><div>php artisan migrate
</div></code></pre>
    <h3 id="publicar-provider-para-autentica%C3%A7%C3%A3o">Publicar provider para autenticação</h3>
    <pre class="hljs"><code><div>php artisan vendor:publish --provider=&quot;Tymon\JWTAuth\Providers\LaravelServiceProvider&quot;
</div></code></pre>
    <h3 id="criar-chave-jwt">Criar chave JWT</h3>
    <pre class="hljs"><code><div>php artisan jwt:secret
</div></code></pre>
    <h3 id="inicializar-o-servidor">Inicializar o servidor</h3>
    <pre class="hljs"><code><div>php artisan serve
</div></code></pre>
    <p><br><br>
        <hr>
    </p>
    <p><a href="https://thormes-controle-financeiro.herokuapp.com/">Versão online da aplicação (heroku)</a></p>

</body>

</html>
