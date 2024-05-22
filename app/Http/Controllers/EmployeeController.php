<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreEmployeeRequest;
use Illuminate\Validation\ValidationException;

class EmployeeController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index(){
    $employee = Employee::all();

        // return dd($products);

        return response()->json($employee, 201);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function storeBulk(StoreEmployeeRequest $request)
    {
        $employeesData = $request->all();
        $employees = [];

        foreach ($employeesData as $employeeData) {
            $employees[] = [
                'name' => $employeeData['name'],
                'email' => $employeeData['email'],
                'password' => Hash::make($employeeData['password']),
                'phone' => $employeeData['phone'],
                'date_of_birth' => $employeeData['date_of_birth'],
                'role' => $employeeData['role'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        try {
            Employee::insert($employees);
        } catch (\Illuminate\Database\QueryException $e) 
            {
            if ($e->errorInfo[1] == 1062) 
               {
                $duplicates = [];
                foreach ($employeesData as $employeeData) {
                    if (Employee::where('email', $employeeData['email'])->exists()) {
                        $duplicates[] = $employeeData['email'];
                    }
                }
                throw ValidationException::withMessages([
                    'email' => 'The email(s) ' . implode(', ', $duplicates) . ' already exist.'
                ]);
            } else {
                throw $e;
            }
        }
        $employeeData['password'] = Hash::make($employeeData['password']);
        return response()->json(['message' => 'Employees inserted successfully'], 201);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:employees,email,NULL,id',
            'password' => 'required|min:8|',
            'phone' => 'required',
            'date_of_birth' => 'required',
            'role' => 'required',
        ], 
        [
            'email.unique' => 'The email address is already in use.',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }
        

        $employee = Employee::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'role' => $request->role,
        ]);
    
        return response()->json(['message' => 'Employee Created Successfully'], 404);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = Employee::find($id);

    if (!$employee) {
        return response()->json(['message' => 'Employee not found'], 404);
    }

    return $employee;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }
    
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:employees,email,'.$employee->id,
            'password' => 'required',
            'phone' => 'required',
            'date_of_birth' => 'required',
            'role' => 'required',
        ]);
    
        $employee->update($request->all());
    
        return $employee;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = Employee::find($id);

        if (!$employee) 
        {
            return response()->json(['message' => 'Employee not found'], 404);
        }
    
        $employee->delete();
    
        return response()->json(['message' => 'Employee deleted']);
    }
}