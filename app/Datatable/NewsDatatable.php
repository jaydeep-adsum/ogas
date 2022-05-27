<?php

namespace App\Datatable;

use App\Models\News;

class NewsDatatable
{
    public function get($input = [])
    {
        /** @var News $query */
        $query = News::query()->select('news.*');

        return $query;
    }
}
