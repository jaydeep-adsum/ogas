<?php

namespace App\Datatable;

use App\Models\Note;

class NotesDatatable
{
    public function get($input = [])
    {
        /** @var Note $query */
        $query = Note::query()->select('notes.*');

        return $query;
    }
}
