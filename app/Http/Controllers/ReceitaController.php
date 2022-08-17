<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\Receita;
use App\Helpers\Paginador;
use App\Exceptions\Responser;


class ReceitaController extends Controller
{
    public function store(Request $request)
    {
        $dados = json_decode($request->getContent(), true);
        $rules = [
            'descricao' => 'required',
            'valor' => 'required|numeric',
            'data' => 'required|date_format:d/m/Y'
        ];
        $request->validate($rules);
        if ($this->receitaJaExiste($request)) {
            return Responser::error(409, "Já existe uma Receita com essa descrição para o mês informado");
        }
        $receita = Receita::create($dados);
        return $receita;
    }

    public function index()
    {
        $paginado = Receita::paginate(env('PER_PAGE', 15));
        return Paginador::paginar($paginado);
    }

    public function show(int $id)
    {
        return Receita::findOrFail($id);
    }

    public function update(int $id, Request $request)
    {
        $existente = Receita::findOrFail($id);
        $rules = [
            'descricao' => 'required',
            'valor' => 'required|numeric',
            'data' => 'required|date_format:d/m/Y'
        ];
        $request->validate($rules);
        if ($this->receitaJaExiste($request)) {
            return Responser::error(409, "Já existe uma Receita com essa descrição para o mês informado");
        }
        $existente->fill($request->all());
        $existente->save();
        return $existente;
    }

    public function destroy(Receita $receita)
    {
        $copia = clone $receita;
        $receita->delete();
        return response()->json(["message" => "Receita apagada com sucesso!", "entidade" => $copia]);
    }

    private function receitaJaExiste(Request $request)
    {
        $date = Carbon::createFromFormat("d/m/Y", $request->data);
        $noBd = Receita::whereMonth('data', $date->month)->whereYear('data', $date->year)->where('descricao', $request->descricao)->get();
        return count($noBd) > 0;
    }
}
