<?php


namespace App\Repositories;


use App\Models\Notification;

class NotificationRepository extends BaseRepository
{
    /**
     * @var string[]
     */
    protected $fieldsSearchable = [
        'title',
        'description',
    ];

    /**
     * @return array|string[]
     */
    public function getFieldsSearchable()
    {
       return $this->fieldsSearchable;
    }

    /**
     * @return string
     */
    public function model()
    {
        return Notification::class;
    }
}
