<?php


namespace App\Repositories;


use App\Models\Complaint;

class ComplaintRepository extends BaseRepository
{

    protected $fieldsSearchable = [
        'feedback'
    ];
    public function getFieldsSearchable()
    {
        return $this->fieldsSearchable;
    }

    public function model()
    {
        return Complaint::class;
    }
}
