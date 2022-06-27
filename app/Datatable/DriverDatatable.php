<?php

namespace App\Datatable;

use App\Models\Driver;

class DriverDatatable
{
    public function get($input = [])
    {
        /** @var Driver $query */
        $query = Driver::query()->select('drivers.*');

        return $query;
    }
}
