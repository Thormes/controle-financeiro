<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Despesa;
use App\Models\Categoria;
use App\Helpers\Paginador;
use App\Exceptions\Responser;

class DespesaController extends Controller
{

    public function store(Request $request)
    {
        $dados = json_decode($request->getContent(), true);
        $rules = [
            'descricao' => 'required',
            'valor' => 'required|numeric',
            'data' => 'required|date_format:d/m/Y',
        ];
        $request->validate($rules);

        if (isset($request->categoria)) {
            $categoria = DB::table("categorias")->where('nome', 'like',  "%{$request->categoria}%")->get()?->first() ?? null;
            if (is_null($categoria)) {
                return Responser::error(404, "Categoria não encontrada!");
            }
        } else {
            $categoria = DB::table("categorias")->where('nome', "=", 'Outras')->get()?->first();
        }
        if ($this->DespesaJaExiste($request)) {
            return Responser::error(409, "Já existe uma Despesa com essa descrição para o mês informado");
        }
        $dados['fixa'] = $request->fixa ?? false;
        $dados['categoria_id'] = $categoria->id;
        $dados['user_id'] = $request->user()->id;
        $despesa = Despesa::create($dados);
        $categoria = $despesa->categoria;
        $user = $despesa->user;
        return $despesa;
    }

    public function index(Request $request)
    {
        $descricao = $request->get('descricao');
        $categoria = $request->get('categoria');
        $result = Despesa::with('categoria', 'user')
            ->where('user_id', $request->user()->id)
            ->when($descricao, function ($query, $descricao) {
                $query->where('descricao', 'like', "%{$descricao}%");
            })->when($categoria, function ($query, $categoria) {
                $categoria_encontrada = Categoria::where('nome', $categoria)->get();
                if (count($categoria_encontrada) > 0) {
                    $query->where('categoria_id', $categoria_encontrada->first()->id);
                }
            })
            ->paginate(env('PER_PAGE', 15));
        return Paginador::paginar($result);
    }

    public function show(Request $request, int $id)
    {
        return Despesa::where('user_id', $request->user()->id)->with('categoria', 'user')->findOrFail($id);
    }

    public function update(int $id, Request $request)
    {
        $existente = Despesa::findOrFail($id);
        if ($existente->user->id != $request->user()->id) {
            return Responser::error(403, "Despesa não pertence ao usuário!");
        }
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

    public function destroy(Request $request, Despesa $Despesa)
    {
        if ($Despesa->user->id != $request->user()->id) {
            return Responser::error(403, "Despesa não pertence ao usuário!");
        }
        $copia = clone $Despesa;
        $Despesa->delete();
        return response()->json(["message" => "Despesa apagada com sucesso!", "entidade" => $copia]);
    }

    private function DespesaJaExiste(Request $request)
    {
        $date = Carbon::createFromFormat("d/m/Y", $request->data);
        $noBd = Despesa::whereMonth('data', $date->month)->whereYear('data', $date->year)->where('descricao', $request->descricao)->where('user_id', $request->user()->id)->get();
        return count($noBd) > 0;
    }

    public function porMes(Request $request, int $ano, int $mes)
    {
        $date = Carbon::createFromFormat("d/m/Y", "01/" . $mes . "/" . $ano);
        $noBd = Despesa::whereMonth('data', $date->month)->whereYear('data', $date->year)->where('user_id', $request->user()->id)->with('categoria');
        return Paginador::paginar($noBd->paginate(env('PER_PAGE', 15)));
    }
}
