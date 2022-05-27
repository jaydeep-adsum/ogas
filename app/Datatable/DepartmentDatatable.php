<?php

namespace App\Datatable;

use App\Models\Department;

class DepartmentDatatable
{
    public function get($input = [])
    {
        /** @var Department $query */
        $query = Department::query()->select('departments.*');

        return $query;
    }
}
