<?php
namespace App\Http\Controllers\Visitor;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Mail\Visitor\StaffNotification;
use App\Mail\Visitor\VisitorNotification;
use App\Models\Visitor\Visitor;
use App\Models\Visitor\Visit;
use App\Models\Visitor\VisitorCard;
use App\Models\Visitor\VisitorCompany;
use App\Models\HR\Employee;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class VisitorController extends Controller
{

    public function register()
    {
        $title = 'Visitor Registration';
        $visitorCards = VisitorCard::where('is_assigned', 0)->get();
        $visitorCompany = VisitorCompany::all();         
    
        // Pass the data to the view
        return view('visitor.register', [
            'visitorCards' => $visitorCards,
            'visitorCompany' => $visitorCompany,
            'title' => $title
        ]);
    }

    public function search()
    {
        $title = 'Visitor Search';
        return view('visitor.search', compact('title'));
    }

    public function result(Request $request)
    {
        $title = 'Visitor Result';
        $searchTerm = $request->input('visitorMobile');
        $visitor = Visitor::where('mobile', $searchTerm)->first();
    
        if (!$visitor) {
            // Redirect back with an error message
            return redirect()->back()->withErrors(['visitorMobile' => 'No visitor found with this mobile number.']);
        }
    
        $visitorCards = VisitorCard::where('is_assigned', 0)->get();
        $visitorCompany = VisitorCompany::all();  
    
        // Pass the data to the view
        return view('visitor.result', [
            'visitor' => $visitor,
            'visitorCards' => $visitorCards,
            'visitorCompany' => $visitorCompany,
            'title' => $title
        ]);
    }
    

    public function store(Request $request)
    {
        // Validate the visitor data
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'min:3'],
            'mobile' => ['required', 'regex:/^\d{11}$/', 'unique:visitor_details,mobile'],
            'email' => 'nullable|email|unique:visitor_details,email',
            'company' => ['required', 'string'],
        ]);
    
        // Validate the visit data
        $visitData = $this->validateVisitData($request);
        
        // This is without compare string
        $companyName = strtoupper($validatedData['company']);

        // Check if the company already exists
        $company = VisitorCompany::where('name', $companyName)->first();
        
        if (!$company) {
            // If company doesn't exist, create a new one
            $company = VisitorCompany::create(['name' => $companyName]);
        }
        
        // Set the visitor company ID
        $validatedData['visitor_company_id'] = $company->id;
        

        $validatedData['name'] = ucwords(strtolower($validatedData['name']));
        // Create the visitor
        $visitor = Visitor::create($validatedData);
        
        $visitorCard = VisitorCard::where('card_no', $visitData['cardno'])->first();

        if ($visitorCard && $visitorCard->is_assigned == 1) {
            return redirect()->back()->withErrors(['cardno' => 'The card is already assigned and cannot be used.']);
        } else {
            // Assign the card
            $visitorCard->is_assigned = 1;
            $visitorCard->save(); // This saves the updated record to the database
        }
        
        // Create the visit detail
        $visit = Visit::create([
            'visitor_id' => $visitor->id,
            'purpose' => $visitData['purpose'],
            'staff_id' => $visitData['employee_id'],
            'cardno' => $visitData['cardno'],
            'accompanied' => $visitData['accompanied'],
            'entry_time' => now(),
        ]);

        // Send email to staff (compulsory)
        Mail::to($visit->employee->email)->queue(new StaffNotification($visit, $visitor));

        // Send email to visitor if email is provided
        if (!empty($validatedData['email'])) {
            Mail::to($validatedData['email'])->queue(new VisitorNotification($visitor));
        }
        return redirect('/visitor/register')->with('success', 'Visitor registered and visit recorded successfully.');
    }
    
    public function recordVisit(Request $request)
    {
        // Validate the visitor ID and visit data
        $validatedData = $request->validate([
            'visitor_id' => ['required', 'exists:visitor_details,id'],
            'company' => ['required', 'string'],
            'purpose' => ['required', 'string'],
            'employee_id' => ['required', 'string'],
            'cardno' => ['required', 'string'],
            'accompanied' => ['nullable', 'string'],
        ]);

        $existingVisit = Visit::where('visitor_id', $validatedData['visitor_id'])
        ->where('is_entered', 1)
        ->first();

        if ($existingVisit) {
        // Return with an error message if the visitor has already entered
        return redirect()->back()->withErrors(['error' => 'The visitor has already entered!']);
        }

        $visitorCard = VisitorCard::where('card_no', $validatedData['cardno'])->first();

        if ($visitorCard && $visitorCard->is_assigned == 1) {
            return redirect()->back()->withErrors(['cardno' => 'The card is already assigned and cannot be used.']);
        } else {
            // Assign the card
            $visitorCard->is_assigned = 1;
            $visitorCard->save(); // This saves the updated record to the database
        }        

        $visitor = Visitor::find($validatedData['visitor_id']);

        // Convert the company name to uppercase
        $companyName = strtoupper($validatedData['company']);

        // Check if the company already exists
        $company = VisitorCompany::where('name', $companyName)->first();

        if ($company) {
            // If the company exists, update the name (if necessary)
            $company->name = $companyName;
            $company->save();
        } else {
            // If the company does not exist, create a new one with the uppercase name
            $company = VisitorCompany::create(['name' => $companyName]);
        }

       // Update the visitor's company_id
       $visitor->update(['visitor_company_id' => $company->id]);

       $visit = Visit::create([
            'visitor_id' => $validatedData['visitor_id'],
            'purpose' => $validatedData['purpose'],
            'staff_id' => $validatedData['employee_id'],
            'cardno' => $validatedData['cardno'],
            'accompanied' => $validatedData['accompanied'],
            'entry_time' => now(),
        ]);

        Mail::to($visit->employee->email)->queue(new StaffNotification($visit, $visitor));

        return redirect('/visitor/register')->with('success', 'Visit recorded successfully.');
    }
    
    private function validateVisitData(Request $request)
    {
        return $request->validate([
            'purpose' => ['required', 'string'],
            'employee_id' => ['required', 'string'],
            'cardno' => ['required', 'string'],
            'accompanied' => ['nullable', 'string'],
        ]);
    }


    public function fetchStaffSuggestions(Request $request)
    {
        $searchTerm = $request->input('searchTerm');
        $staff = Employee::where('name', 'LIKE', "%{$searchTerm}%")
               ->Where('status', 'Active')
              ->get(['employee_id', 'name']);
    
        return response()->json($staff);
    }
    
}
