<?php

namespace App\Datatable;

use App\Models\Semester;

class SemesterDatatable
{
    public function get($input = [])
    {
        /** @var Semester $query */
        $query = Semester::query()->select('semesters.*');

        return $query;
    }
}
