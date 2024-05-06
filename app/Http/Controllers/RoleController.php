<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{

    public function show($id){
        $roles = Role::findOrFail($id);
        return view('admin.role.edit', ['role' => $roles]);
    }

    public function index(){
       
        $roles = Role::all();
        $tableName = 'roles'; // Replace 'your_table_name' with the actual name of your table

        if (Schema::hasTable($tableName)) {
            $columnCount = count(Schema::getColumnListing($tableName));
        }
        return view('admin.role.index', [
            'roles' => $roles, 
            'columnCount' => $columnCount,
            'firstPrefix' => 'admin',
            'secondPrefix' => '/roles'
        ]);
    }

    public function store(Request $request){

        try {
            // Validate the request data
            $validate = $request->validate([
                'role_name' => 'required|min:4', 
                'permission' => 'required|array', // Ensure 'permission' is an array
            ]);

            // Process the submitted permissions
            $permissions = $request->input('permission');
            
            Role::create([
                'role_name' => $validate['role_name'],
                'permission' => json_encode($permissions),
            ]);

            // Redirect or return a response
            return back()->with('success', 'Role created successfully');
        }catch (QueryException $e) {
            // Check if the error is due to a duplicate entry violation
            if ($e->errorInfo[1] == 1062 && strpos($e->getMessage(), 'roles_role_name_unique') !== false) {
                // Return an error response indicating duplicate entry
                return back()->with('alert', 'Role name already exists');
            } else {
                // For other types of errors, handle them accordingly
                // Log the error, return a generic error message, etc.
                return redirect()->route('admin.roles')->with('error', 'An error occurred while adding the role');
            }
        }
    }

    public function update(Request $request, Role $role)
    {

        try {
            $validated = $request->validate([
                'role_name' => 'required|min:4', 
                'permission' => 'required|array', // Ensure 'permission' is an array
            ]);
            $permissions = $request->input('permission');
            $role->update([
                'role_name' => $validated['role_name'],
                'permission' => json_encode($permissions),
            ]);
    
            return redirect()->route('admin.roles')->with('success', 'Data was successfully updated!');
        }catch (QueryException $e) {
            // Check if the error is due to a duplicate entry violation
            if ($e->errorInfo[1] == 1062 && strpos($e->getMessage(), 'roles_role_name_unique') !== false) {
                // Return an error response indicating duplicate entry
                return back()->with('alert', 'Role name already exists');
            } else {
                // For other types of errors, handle them accordingly
                // Log the error, return a generic error message, etc.
                return redirect()->route('admin.roles')->with('error', 'An error occurred while updating the role');
            }
        }
    }

    public function destroy(Role $role){
        $role->delete();
        return redirect()->route('admin.roles')->with('warning', 'Role name successfully deleted.');
    }
}