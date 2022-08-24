<?php


namespace App\Datatable;


use App\Models\Notification;

class NotificationDatatable
{
    public function get($input = [])
    {
        /** @var Notification $query */
        $query = Notification::query()->select('notifications.*');

        return $query;
    }
}
