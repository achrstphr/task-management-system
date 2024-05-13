<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class ActivityLogController extends Controller
{
    public function index()
    {
        $activityLogs = ActivityLog::orderBy('created_at', 'desc')->get();
        $user = Auth::user();
        $tableName = 'users'; // Replace 'your_table_name' with the actual name of your table
        $permissions =  json_decode($user->role->permission, true);
        if (Schema::hasTable($tableName)) {
            $columnCount = count(Schema::getColumnListing($tableName));
        }
        // Pass roles, users, and departments to the view
        return view('admin.activityLog.index', [
            'activityLogs' => $activityLogs, 
            'columnCount' => $columnCount,
            'permissions' => $permissions
        ]);
      
    }
}
