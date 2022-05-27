<?php

namespace App\Datatable;

use App\Models\Customer;

class CustomerDatatable
{
    public function get($input = [])
    {
        /** @var Customer $query */
        $query = Customer::query()->select('customers.*');

        return $query;
    }

}
