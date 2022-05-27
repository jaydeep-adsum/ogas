<?php

namespace App\Datatable;

use App\Models\Year;

class YearDatatable
{
    public function get($input = [])
    {
        /** @var Year $query */
        $query = Year::query()->select('years.*');

        return $query;
    }
}
