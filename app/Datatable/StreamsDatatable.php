<?php

namespace App\Datatable;

use App\Models\Stream;

class StreamsDatatable
{
    public function get($input = [])
    {
        /** @var Stream $query */
        $query = Stream::query()->select('streams.*');

        return $query;
    }
}
