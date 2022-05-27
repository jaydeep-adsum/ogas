<?php

namespace App\Datatable;

use App\Models\Fellowship;

class FellowshipDatatable
{
    public function get($input = [])
    {
        /** @var Fellowship $query */
        $query = Fellowship::query()->select('fellowships.*');

        return $query;
    }
}
