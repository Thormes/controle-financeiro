<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\Receita;
use App\Models\Despesa;
use App\Models\Categoria;

class ResumoController extends Controller
{
    public function __invoke(int $ano, int $mes)
    {
        $user = Auth::user();
        $date = Carbon::createFromFormat("d/m/Y", "01/" . $mes . "/" . $ano);
        $receitas = Receita::whereMonth('data', $date->month)->whereYear('data', $date->year)->where('user_id', $user->id)->get();
        $despesas = Despesa::whereMonth('data', $date->month)->whereYear('data', $date->year)->where('user_id', $user->id)->with('categoria')->get();
        $totalReceitas = round($receitas->reduce(fn ($total, Receita $receita) => $total + $receita->valor, 0), 2);
        $totalDespesas = round($despesas->reduce(fn ($total, Despesa $despesa) => $total + $despesa->valor, 0), 2);
        $saldoFinal = round($totalReceitas - $totalDespesas, 2);
        $retorno = [
            "receitas" => $totalReceitas,
            "despesas" => $totalDespesas,
            "saldo" => $saldoFinal,
        ];
        $retorno_categorias = [];
        $categorias = Categoria::all();
        foreach ($categorias as $categoria) {
            $despesas_categoria = $despesas->filter(fn ($despesa) => $despesa->categoria == $categoria);
            $retorno_categorias[$categoria->nome] = round($despesas_categoria->reduce(fn ($total, Despesa $despesa) => $total + $despesa->valor, 0), 2);
        }
        $retorno['despesas_por_categoria'] = $retorno_categorias;
        return $retorno;
    }
}
