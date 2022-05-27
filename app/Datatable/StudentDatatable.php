<?php

namespace App\Datatable;

use App\Models\Student;

class StudentDatatable
{
    public function get($input = [])
    {
        /** @var Student $query */
        $query = Student::query()->select('students.*');

        return $query;
    }

}
