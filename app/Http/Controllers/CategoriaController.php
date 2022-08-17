<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Helpers\Paginador;
use App\Exceptions\Responser;

class CategoriaController extends Controller
{
    public function store(Request $request)
    {
        $dados = json_decode($request->getContent(), true);
        $rules = [
            'nome' => 'required',
        ];
        $request->validate($rules);
        $categoria = Categoria::create($dados);
        return $categoria;
    }

    public function index()
    {
        $paginado = Categoria::paginate(env('PER_PAGE', 15));
        return Paginador::paginar($paginado);
    }

    public function show(int $id)
    {
        return Categoria::findOrFail($id);
    }

    public function update(int $id, Request $request)
    {
        $existente = Categoria::findOrFail($id);
        $rules = [
            'nome' => 'required',
        ];
        $request->validate($rules);
        $existente->fill($request->all());
        $existente->save();
        return $existente;
    }

    public function destroy(Categoria $categoria)
    {
        $copia = clone $categoria;
        $categoria->delete();
        return response()->json(["message" => "Categoria apagada com sucesso!", "entidade" => $copia]);
    }
}
