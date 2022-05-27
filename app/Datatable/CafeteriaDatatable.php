<?php

namespace App\Datatable;

use App\Models\Cafeteria;

class CafeteriaDatatable
{
    public function get($input = [])
    {
        /** @var Cafeteria $query */
        $query = Cafeteria::query()->select('cafeterias.*');

        return $query;
    }
}
