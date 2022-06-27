<?php

namespace App\Repositories;

use App\Models\Driver;

class DriverRepository extends BaseRepository
{
    /**
     * @var string[]
     */
    protected $fieldsSearchable = [
        'name',
        'mobile',
        'email',
        'licence_no',
        'vehicle_no',
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
        return Driver::class;
    }
}
