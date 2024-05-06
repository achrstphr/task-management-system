<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class TaskController extends Controller
{
    public function index(){
       
        $tasks = Task::all();
        $tableName = 'tasks'; // Replace 'your_table_name' with the actual name of your table

        if (Schema::hasTable($tableName)) {
            $columnCount = count(Schema::getColumnListing($tableName));
        }
        return view('admin.task.index', [
            'tasks' => $tasks, 
            'columnCount' => $columnCount,
            'firstPrefix' => 'admin',
            'secondPrefix' => '/tasks'
        ]);
    }

    public function create(){
        $users = User::all();
        return view('admin.task.create', [
            'users' => $users
        ]);
    }

    public function show($id){
        $tasks = Task::findOrFail($id);
        $users = User::all();
        return view('admin.task.edit', [
            'task' => $tasks,
            'users' => $users
        ]);
    }

    public function store(Request $request){
        // Validate the incoming request data
        $validated = $request->validate([
            "task_name" => ['required', 'min:4'],
            "difficulty_level" => ['required', 'string', 'max:255'], // Validate department_name field
            "priority_level" => ['required', 'string', 'max:255'],
            "assign_to" => ['required', 'string', 'max:255'], // Validate department_name field
            "task_status" => ['required', 'string', 'max:255'],
        ]);


        // // Create a new user instance
        Task::create([
            'task_name' => $validated['task_name'],
            'difficulty_level' => $validated['difficulty_level'],
            'priority_level' => $validated['priority_level'],
            'user_id' => $validated['assign_to'],
            'task_status' => $validated['task_status'],
        ]);
        
        return redirect('/admin/tasks')->with('success', 'Task created successfully!');
    }

    public function update(Request $request, Task $task)
    {
        // dd($request->all());
        $validated = $request->validate([
            "task_name" => ['required', 'min:4'],
            "difficulty_level" => ['required', 'string', 'max:255'], // Validate department_name field
            "priority_level" => ['required', 'string', 'max:255'],
            "assign_to" => ['required', 'string', 'max:255'], // Validate department_name field
            "task_status" => ['required', 'string', 'max:255'],
        ]);
        
        $task->update($validated);

        return redirect('/admin/tasks')->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task){
        $task->delete();
        return redirect()->route('admin.tasks')->with('warning', 'Task name successfully deleted.');
    }
}
