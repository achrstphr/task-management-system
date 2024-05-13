<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $user = Auth::user();
        $permissions = json_decode($user->role->permission, true);
        $tableName = 'roles'; // Replace 'your_table_name' with the actual name of your table

        if (Schema::hasTable($tableName)) {
            $columnCount = count(Schema::getColumnListing($tableName));
        }
        return view('admin.role.index', [
            'roles' => $roles, 
            'columnCount' => $columnCount,
            'firstPrefix' => 'admin',
            'secondPrefix' => '/roles',
            'permissions' => $permissions
        ]);
    }

    public function store(Request $request){

        try {
            $user = Auth::user();
            $user_id = $user->id;
            // Validate the request data
            $validate = $request->validate([
                'role_name' => 'required|min:4', 
                'permission' => 'required|array', // Ensure 'permission' is an array
            ]);

            // Process the submitted permissions
            $permissions = $request->input('permission');
            
            $role = Role::create([
                'role_name' => $validate['role_name'],
                'permission' => json_encode($permissions),
            ]);
            $action = 'Role created';
            $details = 'New Role: ' . $role->role_name . ', Permission: ' . json_decode(json_encode($role->permission));

            ActivityLog::create([
                'user_id' => $user_id,
                'action' => $action,
                'details' => $details
            ]);

            // Redirect or return a response
            return redirect()->route('admin.roles')->with('success', 'Role created successfully');
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
            $user = Auth::user();
            $user_id = $user->id;
            $validated = $request->validate([
                'role_name' => 'required|min:4', 
                'permission' => 'required|array', // Ensure 'permission' is an array
            ]);
            $permissions = $request->input('permission');

            $changesDetected = false;
            // Compare role_name
            if ($role->role_name !== $validated['role_name']) {
                $changesDetected = true;
            }

            // Compare permission (convert both to JSON for comparison)
            if (json_encode(json_decode($role->permission)) !== json_encode($validated['permission'])) {
                $changesDetected = true;
            }
            
            $oldRole = $role->role_name;
            $oldPermission = $role->permission;
            if ($changesDetected){
                $role->update([
                    'role_name' => $validated['role_name'],
                    'permission' => json_encode($permissions),
                ]);
                $removedPermission = array_diff(json_decode($oldPermission, true),json_decode($role->permission,true));
                $addedPermission = array_diff(json_decode($role->permission,true),json_decode($oldPermission, true));
                
                $action = 'Role updated';
                $details ='';
                if ($oldRole !== $role->role_name) {
                    $details .= 'From "' . $oldRole . '" to "' . $role->role_name . '"';
                }
                if ($oldPermission !== $role->permission) {
                    if (!empty($details)) {
                        $details .= ', '; // Add separator if $details is not empty
                    }
                    $detail_permission = '';
                    if ($addedPermission) {
                        $detail_permission .= 'Added Permission: ' . json_encode(array_values($addedPermission));
                    }
                    if ($removedPermission) {
                        if (!empty($detail_permission)) {
                            $detail_permission .= ', '; // Add separator if $details is not empty
                        }
                        $detail_permission .= 'Removed Permission: ' . json_encode(array_values($removedPermission));
                    }
                    // $newPermission = $removedPermission ?? $addedPermission;
                    $details .= $detail_permission;
                }
                

                ActivityLog::create([
                    'user_id' => $user_id,
                    'action' => $action,
                    'details' => $details
                ]);
        
                return redirect()->route('admin.roles')->with('success', 'Data was successfully updated!');
            } else {
                // No changes were made, redirect back with a message
                return redirect()->back()->with('alert', 'No changes were made');
            }
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
        $user = Auth::user();
        $user_id = $user->id;
        $role->delete();
        $action = 'Role deleted';
        $details = 'Removed ' . $role->role_name;

        ActivityLog::create([
            'user_id' => $user_id,
            'action' => $action,
            'details' => $details
        ]);
        return redirect()->route('admin.roles')->with('warning', 'Role name successfully deleted.');
    }
}