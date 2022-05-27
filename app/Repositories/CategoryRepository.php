<?php


namespace App\Repositories;


use App\Models\Category;

class CategoryRepository extends BaseRepository
{
    /**
     * @var string[]
     */
    protected $fieldSearchable = [
        'category',
    ];

    /**
     * @return array|string[]
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * @return string
     */
    public function model()
    {
        return Category::class;
    }
}
