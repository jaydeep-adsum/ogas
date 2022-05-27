<?php

namespace App\Datatable;

use App\Models\Category;

class CategoryDatatable
{
    public function get($input = [])
    {
        /** @var Category $query */
        $query = Category::query()->select('categories.*');

        return $query;
    }
}
