<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\HR\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::orderBy('employee_id', 'desc')->get();
        return view('hr.employees.index', compact('employees'));
    }

    public function create(){
        return view('hr.employees.create');
    }

    public function store(Request $request)
    {
        // ✅ Validate (use DB column names!)
        $validated = $request->validate([
            'emp_name' => ['required', 'string', 'min:3'],
            'emp_email' => ['required', 'email', 'unique:employees,email'],
            'emp_designation' => ['nullable', 'string'],
            'emp_department' => ['nullable', 'string'],
            'emp_status' => ['required', 'in:Active,Inactive'],
        ]);

        // ✅ Map to DB fields
        $data = [
            'name' => ucwords(strtolower($validated['emp_name'])),
            'email' => strtolower($validated['emp_email']),
            'designation' => $validated['emp_designation'],
            'department' => $validated['emp_department'],
            'status' => $validated['emp_status'],
        ];

        // ✅ Insert
        Employee::create($data);

        return redirect()
            ->route('employee.index')
            ->with('success', 'Employee created successfully.');
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        return view('hr.employees.edit', compact('employee'));
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:employees,email,' . $id,
            'designation' => 'nullable|string',
            'department' => 'nullable|string',
            'status' => 'required|in:Active,Inactive',
        ]);

        $employee->update($validated);

        return redirect()->route('employee.index')
            ->with('success', 'Employee updated successfully.');
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return redirect()->route('employee.index')
            ->with('success', 'Employee deleted successfully.');
    }

    public function view(){
        $AllStaff = Employee::orderBy('created_at', 'desc')->get();

        return view('hr.employees.view', ['ShowStaff' => $AllStaff]);
    }

    public function fetchEmployee(Request $request)
    {
        $query = $request->input('query', ''); // Get the search query
    
        $staff = Employee::with('project')
            ->where('emp_status', 'Active') // Ensure emp_status is 'Active'
            ->when($query, function ($queryBuilder) use ($query) {
                $queryBuilder->where('emp_name', 'like', "%{$query}%")
                             ->orWhere('emp_email', 'like', "%{$query}%");
            })
            ->orderBy('staff_id', 'asc') // Order results by name in ascending order
            ->take(empty($query) ? 5 : null) // Limit to 5 records only if no query is provided
            ->get();
    
        // Return the staff data as a JSON response
        return response()->json($staff);
    }
    

}
