<?php

namespace App\Imports;

use Throwable;
use App\Models\Employee;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeeImport implements ToModel, SkipsOnError
{

    public function model(array $row)
    {

        // return new Employee([
        //     'name' => $row['name'],
        //     'email' => $row['email'],
        //     'password' => $row['password'],
        //     'phone' => $row['phone'],
        //     'date_of_birth' => $row['dob'],
        //     'role' => $row['role'],

        // ]);

        return new Employee([
            'name' => $row[0],
            'email' => $row[1],
            'password' => $row[2],
            'phone' => $row[3],
            'date_of_birth' => $row[4],
            'role' => $row[5],
        ]);
    
    }

    public function onError(Throwable $e)
   {
    
   }
}
