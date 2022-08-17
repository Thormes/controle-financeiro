<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\User;

class Despesa extends Model
{
    use HasFactory;
    protected $table = 'despesas';
    protected $fillable = ['descricao', 'valor', 'data', 'fixa', 'categoria_id', 'user_id'];
    protected $casts = ['fixa' => 'boolean', 'data' => 'date:d/m/Y'];
    protected $hidden = ['id', 'updated_at', 'created_at', 'categoria_id', 'user_id'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setDataAttribute($value)
    {
        $this->attributes['data'] = (Carbon::createFromFormat("d/m/Y", $value))->format("Y-m-d");
    }

    public function setValorAttribute($value)
    {
        $this->attributes['valor'] = $value * 100;
    }

    protected function valor(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100
        );
    }
}
