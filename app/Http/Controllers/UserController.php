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

    public function create()
    {
        // Retrieve roles, users, and departments from the database
        $roles = Role::all();
        $departments = Department::all();

        // Pass roles, users, and departments to the view
        return view('user.register', [
            'roles' => $roles,
            'departments' => $departments,
        ]);
    }

    public function store(Request $request){
        // Validate the incoming request data
        $validated = $request->validate([
            "name" => ['required', 'min:4'],
            "email" => ['required', 'email', Rule::unique('users', 'email')],
            "password" => ['required', 'min:6'],
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
        
        return redirect('/users/register')->with('message', 'User created successfully!');
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

