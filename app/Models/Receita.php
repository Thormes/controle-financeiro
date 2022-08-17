<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Receita extends Model
{
    use HasFactory;
    protected $table = 'receitas';
    protected $fillable = ['descricao', 'valor', 'data'];
    protected $casts = ['data' => 'date:d/m/Y', 'valor' => 'float'];
    protected $hidden = ['updated_at', 'created_at'];

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
