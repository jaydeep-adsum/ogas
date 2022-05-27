<?php

namespace App\Datatable;

use App\Models\Event;

class EventsDatatable
{
    public function get($input = [])
    {
        /** @var Event $query */
        $query = Event::query()->select('events.*');

        return $query;
    }

}
