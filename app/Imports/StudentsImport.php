<?php

namespace App\Imports;

use App\Mail\loginMail;
use App\Models\Student;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class StudentsImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            $input = [];
            if ($row['sl_no'] != '') {
                $strRand = Str::random(8);
                $input = [
                    'first_name' => (explode(' ', $row['student_name_first_name_last_name']))[0],
                    'father_name' => $row['father_name'],
                    'last_name' => (explode(' ', $row['student_name_first_name_last_name']))[1],
                    'email' => $row['email_id'],
                    'institute_name' => $row['previous_college_school'],
                    'department' => $row['stream_department'],
                    'semester' => $row['semester'],
                    'dob' => Date::excelToDateTimeObject($row['birth_date'])->format('Y-m-d'),
                    'gender' => $row['gender'],
                    'student_id' => $row['student_id'],
                    'year' => $row['entry_year'],
                    'mobile_no' => $row['contact_number'],
                    'emergency_contact' => $row['emergency_contact'],
                    'address' => $row['address'],
                    'city' => $row['city'],
                    'state' => $row['state'],
                ];
                $input['password'] = Hash::make($strRand);
                $student = Student::create($input);
                if ($student) {
                    $details = [
                        'username' => $input['email'],
                        'password' => $strRand,
                    ];
                    \Mail::to($input['email'])->send(new loginMail($details));
                }
            }
        }
    }
}
