<?php

namespace App\Exports;

use App\Models\Driver;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DriverExport implements FromCollection, WithHeadings
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Driver::select('id','name','email','mobile','licence_no','vehicle_no')->get();
    }

    /**
     * @return string[]
     */
    public function headings() :array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Mobile',
            'Licence No',
            'Vehicle No',
        ];
    }
}
