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
        $dados['user_id'] = $request->user()->id;
        $receita = Receita::create($dados);
        return $receita;
    }

    public function index(Request $request)
    {
        $dados = $request->all();
        if (!in_array('descricao', array_keys($dados))) {
            $result = Receita::with('user')->where('user_id', $request->user()->id)->paginate(env('PER_PAGE', 15));
            return Paginador::paginar($result);
        }
        $result = Receita::with('user')->where('descricao', 'like', "%{$dados['descricao']}%")->where('user_id', $request->user()->id);
        return Paginador::paginar($result->paginate(env('PER_PAGE', 15)));
    }

    public function show(Request $request, int $id)
    {
        return Receita::where('user_id', $request->user()->id)->findOrFail($id);
    }

    public function update(int $id, Request $request)
    {
        $existente = Receita::findOrFail($id);
        if ($existente->user->id != $request->user()->id) {
            return Responser::error(403, "Receita não pertence ao usuário!");
        }
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

    public function destroy(Request $request, Receita $receita)
    {
        if ($receita->user->id != $request->user()->id) {
            return Responser::error(403, "Despesa não pertence ao usuário!");
        }
        $copia = clone $receita;
        $receita->delete();
        return response()->json(["message" => "Receita apagada com sucesso!", "entidade" => $copia]);
    }

    private function receitaJaExiste(Request $request)
    {
        $date = Carbon::createFromFormat("d/m/Y", $request->data);
        $noBd = Receita::whereMonth('data', $date->month)->whereYear('data', $date->year)->where('descricao', $request->descricao)->where('user_id', $request->user()->id)->get();
        return count($noBd) > 0;
    }
    public function porMes(Request $request, int $ano, int $mes)
    {
        $date = Carbon::createFromFormat("d/m/Y", "01/" . $mes . "/" . $ano);
        $noBd = Receita::whereMonth('data', $date->month)->whereYear('data', $date->year)->where('user_id', $request->user()->id);
        return Paginador::paginar($noBd->paginate(env('PER_PAGE', 15)));
    }
}
