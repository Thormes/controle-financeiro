<?php


use App\Models\Receita;
use Illuminate\Foundation\Testing\RefreshDatabase;



uses(Tests\TestCase::class, RefreshDatabase::class);

test('Não cria receita sem dados', function () {
    $response = $this->postJson('/api/receitas', []);
    $response->assertStatus(422);
});

test('Não cria receita sem descrição', function () {
    $response = $this->postJson('/api/receitas', ["valor"=> 345, "data" => "23/05/2022"]);
    $response->assertStatus(422);
});

test('Não cria receita sem valor', function () {
    $response = $this->postJson('/api/receitas', ["data" => "23/05/2022", "descricao" => "São Luiz"]);
    $response->assertStatus(422);
});

test('Não cria receita sem data', function () {
    $response = $this->postJson('/api/receitas', ["valor"=> 345, "descricao" => "São Luiz"]);
    $response->assertStatus(422);
});

test('Não cria receita sem data no formato válido', function () {
    $response = $this->postJson('/api/receitas', ["valor"=> 345, "data" => "05/23/2022", "descricao" => "São Luiz"]);
    $response->assertStatus(422);
});

test('Cria receita com todos os dados', function () {
    $response = $this->postJson('/api/receitas', ["valor"=> 345, "data" => "23/05/2022", "descricao" => "Aluguel"]);
    $response->assertStatus(201);
});

test('Não Cria receita mesma descrição e mesmo mês e ano', function () {
    $response = $this->postJson('/api/receitas', ["valor"=> 200, "data" => "23/05/2022", "descricao" => "Salário"]);
    $response = $this->postJson('/api/receitas', ["valor"=> 200, "data" => "13/05/2022", "descricao" => "Salário"]);
    $response->assertStatus(409);
});




