<?php

namespace App\Datatable;

use App\Models\Faq;

class FaqDatatable
{
    public function get($input = [])
    {
        /** @var Faq $query */
        $query = Faq::query()->select('faqs.*');

        return $query;
    }

}
