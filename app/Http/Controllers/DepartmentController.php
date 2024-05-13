<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Department;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class DepartmentController extends Controller
{

    public function show($id){
        $departments = Department::findOrFail($id);
        return view('admin.department.edit', ['department' => $departments]);
    }

    public function index(){
       
        $departments = Department::all();
        $user = Auth::user();
        $tableName = 'departments'; // Replace 'your_table_name' with the actual name of your table
        $permissions =  json_decode($user->role->permission, true);
        if (Schema::hasTable($tableName)) {
            $columnCount = count(Schema::getColumnListing($tableName));
        }
        return view('admin.department.index', [
            'departments' => $departments, 
            'columnCount' => $columnCount,
            'firstPrefix' => 'admin',
            'secondPrefix' => '/departments',
            'permissions' => $permissions
        ]);
    }

    public function store(Request $request){
        
        try {
            // Validate the request data
            $user = Auth::user();
            $user_id = $user->id;
            $validate = $request->validate([
                'department_name' => 'required|min:4', 
            ]);

            $department = Department::create($validate);
            $action = 'Department created';
            $details = 'New Department: ' . $department->department_name;

            ActivityLog::create([
                'user_id' => $user_id,
                'action' => $action,
                'details' => $details
            ]);

            // Redirect or return a response
            return redirect()->route('admin.departments')->with('success', 'Department created successfully');
        }catch (QueryException $e) {
            // Check if the error is due to a duplicate entry violation
            if ($e->errorInfo[1] == 1062 && strpos($e->getMessage(), 'departments_department_name_unique') !== false) {
                // Return an error response indicating duplicate entry
                return back()->with('alert', 'Department name already exists');
            } else {
                // For other types of errors, handle them accordingly
                // Log the error, return a generic error message, etc.
                return redirect()->route('admin.departments')->with('error', 'An error occurred while adding the department');
            }
        }
    }

    public function update(Request $request, Department $department)
    {

        try {

            $user = Auth::user();
            $user_id = $user->id;
                // Data has changed, proceed with the update
            $validated = $request->validate([
                'department_name' => 'required|min:4', 
            ]);
            $changesDetected = false;
            foreach ($validated as $key => $value) {
                if ($department->{$key} !== $value) {
                    $changesDetected = true;
                    break;
                }
            }
            $oldData = $department->department_name;
            if ($changesDetected){
                $department->update($validated);
                $action = 'Department updated';
                $details = 'From "' . $oldData . '" to "' . $department->department_name . '"';

                ActivityLog::create([
                    'user_id' => $user_id,
                    'action' => $action,
                    'details' => $details
                ]);
        
                return redirect()->route('admin.departments')->with('success', 'Data was successfully updated!');
            } else {
                // No changes were made, redirect back with a message
                return redirect()->back()->with('alert', 'No changes were made');
            }
            
        }catch (QueryException $e) {
            // Check if the error is due to a duplicate entry violation
            if ($e->errorInfo[1] == 1062 && strpos($e->getMessage(), 'departments_department_name_unique') !== false) {
                // Return an error response indicating duplicate entry
                return back()>with('alert', 'Department name already exists');
            } else {
                // For other types of errors, handle them accordingly
                // Log the error, return a generic error message, etc.
                return redirect()->route('admin.departments')->with('error', 'An error occurred while updating the department');
            }
        }
    }

    public function destroy(Department $department){
        $user = Auth::user();
        $user_id = $user->id;
        $department->delete();
        $action = 'Department deleted';
        $details = 'Removed ' . $department->department_name;

        ActivityLog::create([
            'user_id' => $user_id,
            'action' => $action,
            'details' => $details
        ]);
        return redirect()->route('admin.departments')->with('warning', 'Department name successfully deleted.');
    }
}
