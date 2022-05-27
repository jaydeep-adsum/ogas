<?php

namespace App\Datatable;

use App\Models\Question;

class QuestionDatatable
{
    public function get($input = [])
    {
        /** @var Question $query */
        $query = Question::query()->select('questions.*');

        return $query;
    }
}
