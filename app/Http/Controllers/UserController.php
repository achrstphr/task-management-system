<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class UserController extends Controller
{

    public function index()
    {
        // Retrieve roles, users, and departments from the database
        // $users = User::paginate(10);
        $users = User::with('role', 'department')->get();
        $user = Auth::user();
        $tableName = 'users'; // Replace 'your_table_name' with the actual name of your table
        $permissions =  json_decode($user->role->permission, true);
        if (Schema::hasTable($tableName)) {
            $columnCount = count(Schema::getColumnListing($tableName));
        }
        // Pass roles, users, and departments to the view
        return view('user.index', [
            'users' => $users, 
            'columnCount' => $columnCount,
            'firstPrefix' => 'users',
            'secondPrefix' => '',
            'permissions' => $permissions
        ]);
      
    }

    public function show($id){
        $users = User::findOrFail($id);
        $departments = Department::all();
        $roles = Role::all();
        return view('user.edit', [
            'user' => $users,
            'departments' => $departments,
            'roles' => $roles
        ]);
    }

    public function create()
    {
        // dd('ok');
        // Retrieve roles, users, and departments from the database
        $roles = Role::all();
        $departments = Department::all();

        // Pass roles, users, and departments to the view
        return view('user.register', [
            'roles' => $roles,
            'departments' => $departments
        ]);
    }

    public function store(Request $request){
        // Validate the incoming request data
        $user_auth = Auth::user();
        $user_id = $user_auth->id;
        $validated = $request->validate([
            "name" => ['required', 'min:4'],
            "email" => ['required', 'email', Rule::unique('users', 'email')],
            "password" => ['required', 'confirmed', 'min:6'],
            "department_name" => ['required', 'string', 'max:255'], // Validate department_name field
            "role_name" => ['required', 'string', 'max:255'],
        ]);


        // // Create a new user instance
        $user = User::create([
            'name' => Str::title($validated['name']),
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'department_id' => $validated['department_name'],
            'role_id' => $validated['role_name'],
        ]);
        $action = 'user created';
        $details = 'New User: ' . $user->name;

        ActivityLog::create([
            'user_id' => $user_id,
            'action' => $action,
            'details' => $details
        ]);
        
        return redirect('/users')->with('success', 'User created successfully!');
    }

    public function update(Request $request, User $user)
    {
        $user_auth = Auth::user();
        $user_id = $user_auth->id;
        $validated = $request->validate([
            "name" => ['required', 'min:4'],
            "email" => ['required', 'email'],
            "password_confirmation" => ['required','min:6'],
            "department_name" => ['nullable', 'exists:departments,id'], // Validate department_name field
            "role_name" => ['required', 'exists:roles,id'],
        ]);
        
        if (!Hash::check($request->password_confirmation, $user->password)) {
            // Current password does not match
            return back()->with('error','The current password is incorrect.');
        }

        $changesDetected = false;
        if ($user->name !== $validated['name']) {
            $changesDetected = true; 
        } elseif ((int)$user->department_id !== (int)$validated['department_name']){
            $changesDetected = true;
        } elseif ((int)$user->role_id !== (int)$validated['role_name']){
            $changesDetected = true;
        }
       
        $oldName = $user->name;
        $oldEmail = $user->email;
        $oldDepartment = $user->department_id;
        $oldRole = $user->role_id;

        if ($changesDetected){
            $user->name = Str::title($validated['name']);
            $user->department_id = $validated['department_name'];
            $user->role_id = $validated['role_name'];
            $user->update($validated);
            $action = 'User updated';
            $details = 'Changed ';
            if ($oldName !== $user->name) {
                $details .= 'user name from ' . $oldName . ' to ' . $user->name;
            }
            if ($oldEmail !== $user->email) {
                if (!empty($details)) {
                    $details .= ', '; // Add separator if $details is not empty
                }
                $details .= 'email';
            }
            if ($oldDepartment !== $user->department_id) {
                if (!empty($details)) {
                    $details .= ', '; // Add separator if $details is not empty
                }
                $details .= 'department name from ' . $oldDepartment . ' to ' . $user->department_id;
            }
            if ($oldRole !== $user->role_id) {
                if (!empty($details)) {
                    $details .= ', '; // Add separator if $details is not empty
                }
                $details .= 'role name from ' . $oldRole . ' to ' . $user->role_id;
            }
            ActivityLog::create([
                'user_id' => $user_id,
                'action' => $action,
                'details' => $details
            ]);
            return redirect('/users')->with('success', 'User updated successfully!');
        } else {
            // No changes were made, redirect back with a message
            return redirect()->back()->with('alert', 'No changes were made');
        }

        
    }

    public function destroy(User $user){
        $user->delete();
        $user = Auth::user();
        $user_id = $user->id;
        $action = 'User deleted';
        $details = 'Removed ' . $user->name;

        ActivityLog::create([
            'user_id' => $user_id,
            'action' => $action,
            'details' => $details
        ]);
        return redirect()->route('users.index')->with('warning', 'User name successfully deleted.');
    }

    public function login()
    {
        if (View::exists('user.login')) {
            return view('user.login');
        } else {
            return abort(404);
         // return \response()->view('errors.404');
        }
        
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            "email" => ['required', 'email'],
            "password" => 'required'
        ]);

        if(auth()->attempt($validated)) {
            $user = auth()->user();
            $user_id = $user->id;
            $user_name = $user->name;
            $request->session()->regenerate();
            $intended_url = session()->pull('url.intended', route('users.index'));
            $action = 'Login';
            $details = 'Successful login';
            ActivityLog::create([
                'user_id' => $user_id,
                'action' => $action,
                'details' => $details
            ]);
            if ($intended_url === route('login')) {
                // If the intended URL is the login page, redirect to a default page
                return redirect('/users')->with('success', 'Welcome back, ' . $user_name . '!');
            }
            // Redirect the user to the intended page after successful login
            return redirect()->to($intended_url)->with('success', 'Welcome back, ' . $user_name . '!');
        }
        return back()->withErrors(['failed' => 'Login failed: The provided credentials do not match!']);
    }

    public function logout(Request $request)
    {
        $user = auth()->user();
        $user_id = $user->id;
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        $action = 'Logout';
        $details = 'Logout to the system';
        ActivityLog::create([
            'user_id' => $user_id,
            'action' => $action,
            'details' => $details
        ]);

        return redirect('/users/login')->with('success', 'Logout successful');
    }

}

