<?php

namespace App\Http\Controllers;

use App\Models\Visitor\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function create(){
        return view('staff.create');
    }

    public function staff()
    {
        $staffs = Staff::with('project')
                ->where('emp_status', 'Active')
                ->whereNotNull('staff_id')
                ->orderBy('staff_id', 'asc')
                ->get();
        return view('portal.staff', compact('staffs'));
    }

    public function store(Request $request)
    {
        // Validate the visitor data
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'min:3'],
            'email' => 'nullable|email|unique:staff,email',
        ]);
        Staff::create($validatedData);

        return redirect('/portal/staff/create')->with('success', 'Staff created successfully!');
    }

    public function view(){
        $AllStaff = Staff::orderBy('created_at', 'desc')->get();

        return view('staff.view', ['ShowStaff' => $AllStaff]);
    }

    public function fetchStaff(Request $request)
    {
        $query = $request->input('query', ''); // Get the search query
    
        $staff = Staff::with('project')
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
