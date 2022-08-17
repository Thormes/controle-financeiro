<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserControler extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $dados = $request->all();
        $rules = [
            "email" => 'required|email|unique:users,email',
            "nome" => 'required|min:3',
            "password" => 'required|min:8'
        ];
        $request->validate($rules);
        $dados['password'] = Hash::make($dados['password']);
        $user = User::create($dados);
        return $user;
    }
}
