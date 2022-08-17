<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    protected $table = 'categorias';
    protected $fillable = ['nome'];
    protected $hidden = ['updated_at', 'created_at'];

    public function despesas()
    {
        return $this->hasMany(Despesa::class);
    }
}
