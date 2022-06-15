<?php
namespace App\Exports;

use App\Models\Customer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerExport implements FromCollection, WithHeadings
{
    /**
     * @return Collection
     */
    public function collection(): Collection
    {
        return Customer::select('id','name','mobile','address')->get();
    }

    public function headings() :array
    {
        return [
            'ID',
            'Name',
            'Mobile',
            'Address',
            'Image',
        ];
    }
}
