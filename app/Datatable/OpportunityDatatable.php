<?php

namespace App\Datatable;

use App\Models\Opportunity;

class OpportunityDatatable
{
    public function get($input = [])
    {
        /** @var Opportunity $query */
        $query = Opportunity::query()->select('opportunities.*');

        return $query;
    }
}
