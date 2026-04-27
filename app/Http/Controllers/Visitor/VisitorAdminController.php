<?php

namespace App\Http\Controllers\Visitor;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Visitor\Visitor;
use App\Models\Visitor\Visit;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisitorAdminController extends Controller
{
    public function show_all_visitor()
    {
        $AllVisitors = Visitor::with(['visits' => function($query) {
            $query->orderBy('entry_time', 'desc')->limit(1);
        }, 'visits.employee', 'company'])
        ->get()
        ->map(function($visitor) {
            $visitor->latest_visit = $visitor->visits->first(); // Add latest visit to the visitor instance
            return $visitor;
        })
        ->sortByDesc(function($visitor) {
            return $visitor->latest_visit ? $visitor->latest_visit->entry_time : null;
        });
        


  //  $AllVisitors = Visitor::orderBy('created_at', 'desc')->get();
      
// Step 1: Retrieve all visitors with their visits (lazy load staff later)
// $AllVisitors = Visitor::with(['visits' => function ($query) {
//     $query->orderBy('entry_time', 'desc'); // Order by entry_time to get the latest visit first
// }])
// ->get()
// ->map(function ($visitor) {
//     // Get the latest visit
//     $latestVisit = $visitor->visits->first();
    
//     // If there's a latest visit, load the staff information lazily
//     if ($latestVisit) {
//         $latestVisit->load('staff'); // Lazy load the staff relationship
//         $visitor->latest_visit = $latestVisit;
//         $visitor->staff_name = $latestVisit->staff ? $latestVisit->staff->emp_name : 'N/A';
//     } else {
//         $visitor->latest_visit = null;
//         $visitor->staff_name = 'N/A';
//     }
    
//     return $visitor;
// })
// ->sortByDesc(function ($visitor) {
//     return $visitor->latest_visit ? $visitor->latest_visit->entry_time : null;
// });

// Pass the data to the view
return view('visitor.show', ['ShowVisitors' => $AllVisitors]);

    }

    public function visitor_details($id)
    {
        $visitor = Visitor::findOrFail($id);
        // Fetch the visitor with all their visits
        $visits = $visitor->visits()
                ->latest('entry_time')
                ->get();

        return view('visitor.details', [
            'visitor' => $visitor,
            'visits' => $visits
        ]);
    }

    public function visitor_search(Request $request)
    {
        $query = Visit::query();
    
        // Check for start and end datetime inputs
        if ($request->filled('start_datetime') && $request->filled('end_datetime')) {
            $startDateTime = $request->input('start_datetime');
            $endDateTime = $request->input('end_datetime');
            $query->whereBetween('entry_time', [$startDateTime, $endDateTime]);
        }
    
        $ShowVisitors = $query->with(['visitor', 'employee'])
                              ->orderBy('entry_time', 'desc')
                              ->get();
    
        return view('visitor.search-list', compact('ShowVisitors'));
    }
    

}
