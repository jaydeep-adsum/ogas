<?php


namespace App\Datatable;


use App\Models\Product;

class ProductDatatable
{
    public function get($input = [])
    {
        /** @var Product $query */
        $query = Product::query()->select('products.*');

        return $query;
    }
}
