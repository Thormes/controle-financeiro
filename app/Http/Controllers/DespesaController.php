<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\Despesa;
use App\Helpers\Paginador;
use App\Exceptions\Responser;
use App\Models\Categoria;

class DespesaController extends Controller
{
    public function store(Request $request)
    {
        $dados = json_decode($request->getContent(), true);
        $rules = [
            'descricao' => 'required',
            'valor' => 'required|numeric',
            'data' => 'required|date_format:d/m/Y',
            'categoria' => 'required|numeric'
        ];
        $request->validate($rules);
        $categoria = Categoria::findOrFail($request->categoria);
        if ($this->DespesaJaExiste($request)) {
            return Responser::error(409, "Já existe uma Despesa com essa descrição para o mês informado");
        }
        $dados['fixa'] = $request->fixa ?? false;
        $dados['categoria_id'] = $categoria->id;
        $despesa = Despesa::create($dados);
        $categoria = $despesa->categoria;
        return $despesa;
    }

    public function index()
    {
        $paginado = Despesa::with('categoria')->paginate(env('PER_PAGE', 15));
        return Paginador::paginar($paginado);
    }

    public function show(int $id)
    {
        return Despesa::with('categoria')->findOrFail($id);
    }

    public function update(int $id, Request $request)
    {
        $existente = Despesa::findOrFail($id);
        $rules = [
            'descricao' => 'required',
            'valor' => 'required|numeric',
            'data' => 'required|date_format:d/m/Y'
        ];
        $request->validate($rules);
        if ($this->DespesaJaExiste($request)) {
            return Responser::error(409, "Já existe uma Despesa com essa descrição para o mês informado");
        }
        $dados = $request->all();
        $dados['categoria_id'] = $request->categoria ?? $existente->categoria->id;
        $existente->fill($dados);
        $existente->save();
        return $existente;
    }

    public function destroy(Despesa $Despesa)
    {
        $copia = clone $Despesa;
        $Despesa->delete();
        return response()->json(["message" => "Despesa apagada com sucesso!", "entidade" => $copia]);
    }

    private function DespesaJaExiste(Request $request)
    {
        $date = Carbon::createFromFormat("d/m/Y", $request->data);
        $noBd = Despesa::whereMonth('data', $date->month)->whereYear('data', $date->year)->where('descricao', $request->descricao)->get();
        return count($noBd) > 0;
    }
}
