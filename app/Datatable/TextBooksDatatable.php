<?php

namespace App\Datatable;

use App\Models\TextBook;

class TextBooksDatatable
{
    public function get($input = [])
    {
        /** @var TextBook $query */
        $query = TextBook::query()->select('text_books.*');

        return $query;
    }
}
