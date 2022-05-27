<?php

namespace App\Datatable;

use App\Models\Interview;

class InterviewDatatable
{
    public function get($input = [])
    {
        /** @var Interview $query */
        $query = Interview::query()->select('interviews.*');

        return $query;
    }
}
