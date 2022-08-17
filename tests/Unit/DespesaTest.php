<?php


use App\Models\Despesa;
use Illuminate\Foundation\Testing\RefreshDatabase;



uses(Tests\TestCase::class, RefreshDatabase::class);

test('Não cria despesa sem dados', function () {
    $response = $this->postJson('/api/despesas', []);
    $response->assertStatus(422);
});

test('Não cria despesa sem descrição', function () {
    $response = $this->postJson('/api/despesas', ["valor" => 345, "data" => "23/05/2022"]);
    $response->assertStatus(422);
});

test('Não cria despesa sem valor', function () {
    $response = $this->postJson('/api/despesas', ["data" => "23/05/2022", "descricao" => "São Luiz"]);
    $response->assertStatus(422);
});

test('Não cria despesa sem data', function () {
    $response = $this->postJson('/api/despesas', ["valor" => 345, "descricao" => "São Luiz"]);
    $response->assertStatus(422);
});

test('Não cria despesa sem data no formato válido', function () {
    $response = $this->postJson('/api/despesas', ["valor" => 345, "data" => "05/23/2022", "descricao" => "São Luiz"]);
    $response->assertStatus(422);
});

test('Cria despesa com todos os dados na categoria "Outras"', function () {
    $response = $this->postJson('/api/despesas', ["valor" => 345, "data" => "23/05/2022", "descricao" => "São Luiz"]);
    $response->assertStatus(201);
    $dados = json_decode($response->getContent(), true);
    $categoria = $dados['categoria']['nome'];
    $this->assertSame("Outras", $categoria);
});

test('Cria despesa com todos os dados na categoria informada', function () {
    $categoria_informada = "Alimentação";
    $response = $this->postJson('/api/despesas', ["valor" => 345, "data" => "23/05/2022", "descricao" => "São Luiz", "categoria" => $categoria_informada]);
    $response->assertStatus(201);
    $dados = json_decode($response->getContent(), true);
    $categoria = $dados['categoria']['nome'];
    $this->assertSame($categoria_informada, $categoria);
});

test('Não Cria despesa com mesma descrição e mesmo mês e ano', function () {
    $response = $this->postJson('/api/despesas', ["valor" => 200, "data" => "23/05/2022", "descricao" => "Bom Preço"]);
    $response = $this->postJson('/api/despesas', ["valor" => 200, "data" => "13/05/2022", "descricao" => "Bom Preço"]);
    $response->assertStatus(409);
});
