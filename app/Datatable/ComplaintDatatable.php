<?php

namespace App\Datatable;

use App\Models\Complaint;

class ComplaintDatatable
{
    public function get($input = [])
    {
        /** @var Complaint $query */
        $query = Complaint::query()->select('complaints.*');

        return $query;
    }
}
