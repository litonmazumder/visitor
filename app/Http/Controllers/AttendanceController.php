<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    /**
     * Show latest attendance check-in/out records (for web view)
     */
public function checkInOut(Request $request)
{
    // ✅ Filters
    $perPage = (int) $request->get('limit', 25);
    $search  = trim($request->get('search', ''));
    $start   = $request->get('start_date');
    $end     = $request->get('end_date');

    // ✅ Default to last 30 days
    if (empty($start) && empty($end)) {
        $start = now()->subDays(30)->startOfDay();
        $end   = now()->endOfDay();
    } else {
        $start = Carbon::parse($start)->startOfDay();
        $end   = Carbon::parse($end ?? $start)->endOfDay();
    }

    // ================================================================
    // ✅ MAIN QUERY (PAGINATED)
    // ================================================================
    $query = DB::connection('sqlsrv')
        ->table('CHECKINOUT as c')
        ->join('USERINFO as u', 'c.USERID', '=', 'u.USERID')
        ->select(
            'c.USERID',
            'u.NAME',
            DB::raw("FORMAT(c.CHECKTIME, 'yyyy-MM-dd HH:mm:ss') as CHECKTIME"),
            DB::raw("
                CASE c.CHECKTYPE
                    WHEN 'I' THEN 'Check-In'
                    WHEN 'O' THEN 'Check-Out'
                    ELSE 'Unknown'
                END as CHECKTYPE
            "),
            DB::raw("
                CASE c.sn
                    WHEN 'CQQC231461301' THEN 'Front Gate'
                    WHEN 'BAY5252100511' THEN 'Exit Gate'
                    WHEN 'CQQC223760305' THEN 'Progress & Bytes'
                    ELSE c.sn
                END as MACHINE_LOCATION
            ")
        )
        ->whereBetween('c.CHECKTIME', [$start, $end])
        ->orderByDesc('c.CHECKTIME');

    // 🔍 Search filter
    if ($search !== '') {
        $query->where('u.NAME', 'LIKE', "%{$search}%");
    }

    // 📌 Paginated logs
    $logs = $query->paginate($perPage)->appends($request->query());

    // ================================================================
    // ✅ 100% ACCURATE TODAY HEADCOUNT
    // ---------------------------------------------------------------
    // Counts UNIQUE USERID who have ANY Check-In today
    // Even if a person checks in 10 times — counted ONCE
    // ================================================================
    $todayStart = now()->startOfDay();
    $todayEnd   = now()->endOfDay();

    $todayCount = DB::connection('sqlsrv')
        ->table('CHECKINOUT')
        ->whereBetween('CHECKTIME', [$todayStart, $todayEnd])
        ->where('CHECKTYPE', 'I')        // Only Check-IN type
        ->distinct()
        ->count('USERID');               // Unique count

    return view('attendance.checkinout', [
        'logs'        => $logs,
        'search'      => $search,
        'start'       => $start->toDateString(),
        'end'         => $end->toDateString(),
        'perPage'     => $perPage,
        'todayCount'  => $todayCount,  // 👈 SEND TO VIEW
    ]);
}


     public function report(Request $request)
    {
        $startDate     = $request->input('start_date', now()->subDays(7)->toDateString());
        $endDate       = $request->input('end_date', now()->toDateString());
        $departmentId  = $request->input('department_id');
        $userId        = $request->input('user_id');

        // ✅ Fetch dropdown data
        $departments = DB::connection('sqlsrv')
            ->table('DEPARTMENTS')
            ->orderBy('DEPTNAME')
            ->get();

        $staffList = DB::connection('sqlsrv')
            ->table('USERINFO as u')
            ->join('DEPARTMENTS as d', 'u.DEFAULTDEPTID', '=', 'd.DEPTID')
            ->select('u.USERID', 'u.NAME', 'u.DEFAULTDEPTID', 'd.DEPTNAME')
            ->when($departmentId, fn($q) => $q->where('u.DEFAULTDEPTID', $departmentId))
            ->when($userId, fn($q) => $q->where('u.USERID', $userId))
            ->orderBy('u.NAME')
            ->get();

        // ✅ Build the full report data
        $report = $this->generateReport($startDate, $endDate, $departmentId, $userId, $staffList);

        // ✅ Human-friendly info
        $selectedDepartment = $departments->firstWhere('DEPTID', $departmentId);
        $departmentName     = $selectedDepartment->DEPTNAME ?? 'All Departments';
        $monthName          = Carbon::parse($startDate)->format('F Y');

        return view('attendance.report', compact(
            'report',
            'departments',
            'staffList',
            'startDate',
            'endDate',
            'departmentId',
            'userId',
            'departmentName',
            'monthName'
        ));
    }


    public function exportPDF(Request $request)
{
    $startDate     = $request->input('start_date', now()->subDays(7)->toDateString());
    $endDate       = $request->input('end_date', now()->toDateString());
    $departmentId  = $request->input('department_id');
    $userId        = $request->input('user_id');

    // Department Name (single)
    $departmentName = $departmentId
        ? DB::connection('sqlsrv')
            ->table('DEPARTMENTS')
            ->where('DEPTID', $departmentId)
            ->value('DEPTNAME')
        : 'All Departments';

    // Staff List
    $staffList = DB::connection('sqlsrv')
        ->table('USERINFO as u')
        ->join('DEPARTMENTS as d', 'u.DEFAULTDEPTID', '=', 'd.DEPTID')
        ->select('u.USERID', 'u.NAME', 'u.DEFAULTDEPTID', 'd.DEPTNAME')
        ->when($departmentId, fn($q) => $q->where('u.DEFAULTDEPTID', $departmentId))
        ->when($userId, fn($q) => $q->where('u.USERID', $userId))
        ->orderBy('u.NAME')
        ->get();

    // Report
    $report = $this->generateReport($startDate, $endDate, $departmentId, $userId, $staffList);
    $monthName = Carbon::parse($startDate)->format('F Y');

    // PDF
    $pdf = Pdf::loadView('attendance.report_pdf', compact(
        'report', 'startDate', 'endDate', 'departmentName', 'monthName'
    ))->setPaper('a4', 'landscape');

    // Filename
    $fileName = "attendance_report_" .
        str_replace(' ', '_', strtolower($departmentName)) . "_" .
        str_replace(' ', '_', strtolower($monthName)) . ".pdf";

    return $pdf->download($fileName);
}


private function generateReport($startDate, $endDate, $departmentId, $userId, $staffList)
{
    $attendance = $this->buildAttendanceQuery($startDate, $endDate, $departmentId, $userId)
        ->get()
        ->groupBy(['USERID', 'Date']);

    $dates = collect(CarbonPeriod::create($startDate, $endDate))
        ->map(fn($d) => $d->toDateString());

    $report = [];

    foreach ($staffList as $staff) {

        foreach ($dates as $date) {

            $carbon = Carbon::parse($date);
            $dayName = $carbon->format('l');

            // Weekend: Friday (5), Saturday (6)
            if (in_array($carbon->dayOfWeek, [5, 6])) {
                continue; // fully skip
            }

            $record = $attendance[$staff->USERID][$date][0] ?? null;
            $formattedDate = $carbon->format('d/m/y');

            // DEFAULT Values
            $clockIn = $record->ClockIn ?? null;
            $clockOut = $record->ClockOut ?? null;
            $workTime = $record->WorkTime ?? null;

            // Initialize Early/Late
            $late = null;
            $early = null;

            // 👉 Only calculate when there's a Clock-In
            if ($clockIn) {

                $checkInTime = Carbon::parse($clockIn);
                $lateCutoff  = Carbon::parse('09:30');
                $earlyLimit  = Carbon::parse('08:00');
                $officeStart = Carbon::parse('08:30');

                // Calculate Late
                if ($checkInTime->gt($lateCutoff)) {
                    $late = $checkInTime->diff($lateCutoff)->format('%H:%I');
                }

                // Calculate Early (arrived BEFORE 08:00)
                if ($checkInTime->lt($earlyLimit)) {
                    $early = $officeStart->diff($checkInTime)->format('%H:%I');
                }
            }

            // PRESENT
            if ($record) {
                $report[] = [
                    'USERID'     => $staff->USERID,
                    'NAME'       => $staff->NAME,
                    'Department' => $staff->DEPTNAME,
                    'Date'       => $formattedDate,
                    'Day'        => $dayName,
                    'ClockIn'    => $clockIn,
                    'ClockOut'   => $clockOut,
                    'WorkTime'   => $workTime,
                    'Late'       => $late,
                    'Early'      => $early,
                    'Status'     => 'Present',
                    'Weekend'    => null,
                ];
                continue;
            }

            // ABSENT
            $report[] = [
                'USERID'     => $staff->USERID,
                'NAME'       => $staff->NAME,
                'Department' => $staff->DEPTNAME,
                'Date'       => $formattedDate,
                'Day'        => $dayName,
                'ClockIn'    => null,
                'ClockOut'   => null,
                'WorkTime'   => null,
                'Late'       => null,
                'Early'      => null,
                'Status'     => 'Absent',
                'Weekend'    => null,
            ];
        }
    }

    return $report;
}



    private function buildAttendanceQuery($startDate, $endDate, $departmentId, $userId)
{
    return DB::connection('sqlsrv')
        ->table('CHECKINOUT as c')
        ->join('USERINFO as u', 'c.USERID', '=', 'u.USERID')
        ->join('DEPARTMENTS as d', 'u.DEFAULTDEPTID', '=', 'd.DEPTID')
        ->select(
            'u.USERID',
            'u.NAME',
            'd.DEPTNAME as Department',
            DB::raw("CAST(c.CHECKTIME AS date) as Date"),
            DB::raw("MIN(c.CHECKTIME) as ClockIn"),
            DB::raw("MAX(c.CHECKTIME) as ClockOut"),
            DB::raw("FORMAT(
                        DATEADD(second, DATEDIFF(second, MIN(c.CHECKTIME), MAX(c.CHECKTIME)), 0),
                        'HH:mm'
                    ) as WorkTime"),
            DB::raw("
                CASE 
                    WHEN MIN(c.CHECKTIME) > DATEADD(hour, 8, CAST(CAST(c.CHECKTIME AS date) AS datetime))
                    THEN FORMAT(
                        DATEADD(
                            minute,
                            DATEDIFF(
                                minute,
                                DATEADD(hour,8,CAST(CAST(c.CHECKTIME AS date) AS datetime)),
                                MIN(c.CHECKTIME)
                            ),
                        0),'HH:mm')
                    ELSE '' 
                END as Late
            "),
            DB::raw("
                CASE 
                    WHEN MAX(c.CHECKTIME) < DATEADD(hour, 17, CAST(CAST(c.CHECKTIME AS date) AS datetime))
                    THEN FORMAT(
                        DATEADD(
                            minute,
                            DATEDIFF(
                                minute,
                                MAX(c.CHECKTIME),
                                DATEADD(hour,17,CAST(CAST(c.CHECKTIME AS date) AS datetime))
                            ),
                        0),'HH:mm')
                    ELSE '' 
                END as Early
            ")
        )
        ->whereBetween('c.CHECKTIME', [$startDate, $endDate])
        ->when($departmentId, fn($q) => $q->where('u.DEFAULTDEPTID', $departmentId))
        ->when($userId, fn($q) => $q->where('u.USERID', $userId))

        // ✅ REQUIRED GROUP BY
        ->groupBy(
            'u.USERID',
            'u.NAME',
            'd.DEPTNAME',
            DB::raw("CAST(c.CHECKTIME AS date)")
        );
}

}
