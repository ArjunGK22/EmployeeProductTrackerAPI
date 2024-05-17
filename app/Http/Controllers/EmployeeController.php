<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:employees,email,NULL,id',
            'password' => 'required',
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
        Employee::create($request->all());
    
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