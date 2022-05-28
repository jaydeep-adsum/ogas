<?php


namespace App\Repositories;


use App\Models\Product;

class ProductRepository extends BaseRepository
{
    /**
     * @var string[]
     */
    protected $fieldsSearchable = [
        'product_name',
        'refill_price',
        'new_price',
        'category_id ',
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
        return Product::class;
    }
}
