<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class DepartmentController extends Controller
{

    public function show($id){
        $departments = Department::findOrFail($id);
        return view('admin.department.edit', ['department' => $departments]);
    }

    public function index(){
       
        $departments = Department::all();
        $tableName = 'departments'; // Replace 'your_table_name' with the actual name of your table

        if (Schema::hasTable($tableName)) {
            $columnCount = count(Schema::getColumnListing($tableName));
        }
        return view('admin.department.index', [
            'departments' => $departments, 
            'columnCount' => $columnCount,
            'firstPrefix' => 'admin',
            'secondPrefix' => '/department'
        ]);
    }

    public function store(Request $request){
        // Validate the request data
        $validate = $request->validate([
            'department_name' => 'required|min:4', 
        ]);

        Department::create($validate);

        // Redirect or return a response
        return redirect()->route('admin.departments')->with('message', 'Department created successfully');
    }

    public function update(Request $request, Department $department)
    {

        try {
            $validated = $request->validate([
                'department_name' => 'required|min:4', 
            ]);

            $department->update($validated);
    
            return redirect()->route('admin.departments')->with('message', 'Data was successfully updated!');
        }catch (QueryException $e) {
            // Check if the error is due to a duplicate entry violation
            if ($e->errorInfo[1] == 1062 && strpos($e->getMessage(), 'departments_department_name_unique') !== false) {
                // Return an error response indicating duplicate entry
                return redirect()->route('admin.departments')->with('message', 'Department name already exists');
            } else {
                // For other types of errors, handle them accordingly
                // Log the error, return a generic error message, etc.
                return redirect()->route('admin.departments')->with('message', 'An error occurred while updating the role');
            }
        }
    }

    public function destroy(Department $department){
        $department->delete();
        return redirect()->route('admin.departments')->with('message', 'Department name successfully deleted.');
    }
}
