<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{

    public function index()
    {
        // Retrieve roles, users, and departments from the database
        // $users = User::paginate(10);
        $users = User::with('role', 'department')->get();
        $tableName = 'users'; // Replace 'your_table_name' with the actual name of your table

        if (Schema::hasTable($tableName)) {
            $columnCount = count(Schema::getColumnListing($tableName));
        }
        // Pass roles, users, and departments to the view
        return view('user.index', [
            'users' => $users, 
            'columnCount' => $columnCount,
            'firstPrefix' => 'users',
            'secondPrefix' => ''
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
        $validated = $request->validate([
            "name" => ['required', 'min:4'],
            "email" => ['required', 'email', Rule::unique('users', 'email')],
            "password" => ['required', 'confirmed', 'min:6'],
            "department_name" => ['required', 'string', 'max:255'], // Validate department_name field
            "role_name" => ['required', 'string', 'max:255'],
        ]);


        // // Create a new user instance
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'department_id' => $validated['department_name'],
            'role_id' => $validated['role_name'],
        ]);
        
        return redirect('/users')->with('success', 'User created successfully!');
    }

    public function update(Request $request, User $user)
    {
        // dd($request->all());
        $validated = $request->validate([
            "name" => ['required', 'min:4'],
            "email" => ['required', 'email'],
            "password_confirmation" => ['required','min:6'],
            "department_name" => ['required', 'exists:departments,id'], // Validate department_name field
            "role_name" => ['required', 'exists:roles,id'],
        ]);
        
        if (!Hash::check($request->password_confirmation, $user->password)) {
            // Current password does not match
            return back()->with('error','The current password is incorrect.');
        }

        $user->name = $validated['name'];
        $user->department_id = $validated['department_name'];
        $user->role_id = $validated['role_name'];
        $user->update($validated);

        return redirect('/users')->with('success', 'User updated successfully!');
    }

    public function destroy(User $user){
        $user->delete();
        return redirect()->route('users.index')->with('warning', 'User name successfully deleted.');
    }

    // public function login()
    // {
    //     if (View::exists('user.login')) {
    //         return view('user.login');
    //     } else {
    //         return abort(404);
    //      // return \response()->view('errors.404');
    //     }
        
    // }
    // public function register()
    // {
    //     if (View::exists('user.register')) {
    //         return view('user.register');
    //     } else {
    //         return abort(404);
    //     }
    // }

    // public function process(Request $request)
    // {
    //     $validated = $request->validate([
    //         "email" => ['required', 'email'],
    //         "password" => 'required'
    //     ]);

    //     if(auth()->attempt($validated)) {
    //         $request->session()->regenerate();

    //         return redirect('/')->with('message', 'Welcome back!');
    //     }
    //     return back()->withErrors(['email' => 'Login failed'])->onlyInput('email');
    // }

    // public function logout(Request $request)
    // {
    //     auth()->logout();

    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     return redirect('/login')->with('message', 'Logout successful');
    // }

    // public function store (Request $request)
    // {
    //     $validated = $request->validate([
    //         "name" => ['required', 'min:4'],
    //         "email" => ['required', 'email', Rule::unique('users', 'email')],
    //         "password" => 'required|confirmed|min:6'
    //     ]);

    //     // you can use Hash::make or bcrypt
    //     $validated['password'] = Hash::make($validated['password']);

    //     $user = User::create($validated);

    //     auth()->login($user);
    // }
}

