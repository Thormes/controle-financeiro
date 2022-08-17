<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Response;
use Illuminate\Pagination\LengthAwarePaginator;


class Paginador

{
    public static function paginar(LengthAwarePaginator $paginador)
    {
        $info = [
            "por_página" => $paginador->perPage(),
            "página_atual" => $paginador->currentPage(),
            "última_página" => $paginador->lastPage(),
            "do_item" => $paginador->firstItem(),
            "até_o_item" => $paginador->lastItem(),
            "total" => $paginador->total(),
            "dados" => $paginador->getCollection()
        ];
        return Response::json([$info]);
    }
}
