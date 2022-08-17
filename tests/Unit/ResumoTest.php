<?php


use App\Models\Despesa;
use App\Models\Receita;
use Illuminate\Foundation\Testing\RefreshDatabase;



uses(Tests\TestCase::class, RefreshDatabase::class);

test('Gera resumo do mês', function () {
    $despesa = $this->postJson('/api/despesas', ["data" => "23/05/2022", "descricao" => "São Luiz", "categoria" => "Alimentação", "valor" => 345.08]);
    $receita = $this->postJson('/api/receitas', ["data" => "23/05/2022", "descricao" => "Salário", "valor" => 2000]);
    $despesa->assertStatus(201);
    $receita->assertStatus(201);
    $resumo = $this->get("/api/resumo/2022/05");
    $resumo->assertStatus(200);
    $conteudo = json_decode($resumo->getContent(), true);
    $this->assertEquals(345.08, $conteudo['despesas']);
    $this->assertEquals(2000, $conteudo['receitas']);
    $this->assertEquals(1654.92, $conteudo['saldo']);
    $this->assertEquals(345.08, $conteudo['despesas_por_categoria']['Alimentação']);
});
