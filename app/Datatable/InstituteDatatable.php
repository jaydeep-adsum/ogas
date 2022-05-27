<?php

namespace App\Datatable;

use App\Models\Institute;

class InstituteDatatable
{
    public function get($input = [])
    {
        /** @var Institute $query */
        $query = Institute::query()->select('institutes.*');

        return $query;
    }
}
