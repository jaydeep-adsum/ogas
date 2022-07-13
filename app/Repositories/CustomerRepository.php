<?php

namespace App\Repositories;

use App\Models\Customer;

class CustomerRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
        'mobile',
        'address',
        'payment_customer_id',
    ];

    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    public function model()
    {
        return Customer::class;
    }
}
