<?php


namespace App\Repositories;


use App\Models\AddressBook;

class AddressBookRepository extends BaseRepository
{
    /**
     * @var string[]
     */
    protected $fieldSearchable = [
        'location',
        'latitude',
        'longitude',
        'customer_id',
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
        return AddressBook::class;
    }
}
