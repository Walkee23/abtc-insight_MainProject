use App\Models\User;
use Illuminate\Support\Facades\DB;

public function systemManagement()
{
    // 1. Role-based User Counts
    $healthWorkersCount = DB::table('users')->where('role', 'Healthworker')->count();
    $internsCount = DB::table('users')->where('role', 'OJT')->orWhere('role', 'Intern')->count();
    $staffCount = DB::table('users')->where('role', 'Staff')->count();

    // 2. Active Sessions / Users List
    $activeUsers = DB::table('users')
        ->select('name', 'role', 'updated_at')
        ->orderByDesc('updated_at')
        ->limit(5)
        ->get();

    // 3. System Activity Logs (Gikan sa audit/logs table o fallback)
    $systemLogs = DB::table('system_logs') 
        ->latest()
        ->limit(4)
        ->get();

    return view('admin.USM', compact(
        'healthWorkersCount', 
        'internsCount', 
        'staffCount', 
        'activeUsers',
        'systemLogs'
    ));
}