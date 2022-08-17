<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
        });

        DB::table('categorias')->insert([
            ["nome" => "Alimentação"],
            ["nome" => "Saúde"],
            ["nome" => "Moradia"],
            ["nome" => "Transporte"],
            ["nome" => "Educação"],
            ["nome" => "Lazer"],
            ["nome" => "Imprevistos"],
            ["nome" => "Outras"],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categorias');
    }
};
