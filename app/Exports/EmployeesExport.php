<?php
namespace App\Exports;


use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class EmployeesExport implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        return Employee::select('name','email','phone','date_of_birth', 'role')->get();
    }

    public function title(): string{

        return 'Employees';
    }

    public function headings(): array
    {

        return ['Name','Email','Phone','Date Of Birth', 'Role'];
        
    }
    
}
   
