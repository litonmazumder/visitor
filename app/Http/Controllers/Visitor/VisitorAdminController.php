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

    public function showActiveVisitors()
    {
        return view('visitor.active');
    }

    public function fetchActiveVisitors()
    {
        // Fetch visits where is_entered = 1 and join with visitors table
        $activeVisitors = Visit::with('visitor.company', 'employee')
        ->where('is_entered', 1)
        ->orderBy('created_at', 'desc')
        ->get();
        
        // ->each(function($visit) {
        //     Log::info('Visit Data:', $visit->toArray());
        // });   
            
        return response()->json($activeVisitors);
    }

    public function exitVisitor(Request $request)
    {
        $visitId = $request->input('visit_id');

        $visit = Visit::find($visitId);

        if ($visit) {
            // Update visit fields
            $visit->is_entered = 0;
            $visit->save();
    
            // Check if the visit has an associated card
            if ($visit->card) {
                // Update is_assigned field in the related VisitorCard model
                $visit->card->is_assigned = 0;
                $visit->exit_time = now();
                $visit->save();
                $visit->card->save();
            }
    
            // Return a successful response
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    

}
