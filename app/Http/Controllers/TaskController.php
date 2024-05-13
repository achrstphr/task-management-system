<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class TaskController extends Controller
{
    public function index(){
       
        $tasks = Task::all();
        $user = Auth::user();
        $permissions = json_decode($user->role->permission);
        $tableName = 'tasks'; // Replace 'your_table_name' with the actual name of your table

        if (Schema::hasTable($tableName)) {
            $columnCount = count(Schema::getColumnListing($tableName));
        }
        return view('admin.task.index', [
            'tasks' => $tasks, 
            'columnCount' => $columnCount,
            'firstPrefix' => 'admin',
            'secondPrefix' => '/tasks',
            'permissions' => $permissions
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
        $user = Auth::user();
        $user_id = $user->id;
        $validated = $request->validate([
            "task_name" => ['required', 'min:4'],
            "difficulty_level" => ['required', 'string', 'max:255'], // Validate department_name field
            "priority_level" => ['required', 'string', 'max:255'],
            "assign_to" => ['required', 'string', 'max:255'], // Validate department_name field
            "task_status" => ['required', 'string', 'max:255'],
        ]);


        // // Create a new user instance
        $task = Task::create([
            'task_name' => $validated['task_name'],
            'difficulty_level' => $validated['difficulty_level'],
            'priority_level' => $validated['priority_level'],
            'user_id' => $validated['assign_to'],
            'task_status' => $validated['task_status'],
        ]);
        $action = 'Task created';
        $details = 'New Task: ' . $task->task_name;

        ActivityLog::create([
            'user_id' => $user_id,
            'action' => $action,
            'details' => $details
        ]);

        
        return redirect('/admin/tasks')->with('success', 'Task created successfully!');
    }

    public function update(Request $request, Task $task)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $validated = $request->validate([
            "task_name" => ['required', 'min:4'],
            "difficulty_level" => ['required', 'string', 'max:255'], // Validate department_name field
            "priority_level" => ['required', 'string', 'max:255'],
            "assign_to" => ['nullable', 'string', 'max:255'], // Validate department_name field
            "task_status" => ['required', 'string', 'max:255'],
        ]);

        $changesDetected = false;
        if ($task->task_name !== $validated['task_name']) {
            $changesDetected = true; 
        } elseif ($task->difficulty_level !== $validated['difficulty_level']){
            $changesDetected = true;
        } elseif ($task->priority_level !== $validated['priority_level']){
            $changesDetected = true;
        } elseif ((int)$task->user_id !== (int)$validated['assign_to']){
            $changesDetected = true;
        } elseif ($task->task_status !== $validated['task_status']){
            $changesDetected = true;
        }
       
        $oldTask = $task->task_name;
        $oldDifficulty = $task->difficulty_level;
        $oldPriority = $task->priority_level;
        $oldUser = $task->user_id;
        $oldStatus = $task->task_status;

        if ($changesDetected){
            $task->user_id = $validated['assign_to'];
            $task->update($validated);
            $action = 'Task updated';
            $details = 'Changed ';
            if ($oldTask !== $task->task_name) {
                $details .= 'task name from ' . $oldTask . ' to ' . $task->task_name;
            }
            if ($oldDifficulty !== $task->difficulty_level) {
                if (!empty($details)) {
                    $details .= ', '; // Add separator if $details is not empty
                }
                $details .= 'difficulty from ' . $oldDifficulty . ' to ' . $task->difficulty_level;
            }
            if ($oldPriority !== $task->priority_level) {
                if (!empty($details)) {
                    $details .= ', '; // Add separator if $details is not empty
                }
                $details .= 'priority from ' . $oldPriority . ' to ' . $task->priority_level;
            }
            if ($oldUser !== $task->user_id) {
                if (!empty($details)) {
                    $details .= ', '; // Add separator if $details is not empty
                }
                $details .= 'assigned user from ' . $oldUser . ' to ' . $task->user_id;
            }
            if ($oldStatus !== $task->task_status) {
                if (!empty($details)) {
                    $details .= ', '; // Add separator if $details is not empty
                }
                $details .= 'assigned user from ' . $oldStatus . ' to ' . $task->task_status;
            }
            ActivityLog::create([
                'user_id' => $user_id,
                'action' => $action,
                'details' => $details
            ]);

        return redirect('/admin/tasks')->with('success', 'Task updated successfully!');
        } else {
            // No changes were made, redirect back with a message
            return redirect()->back()->with('alert', 'No changes were made');
        }
        
    }

    public function destroy(Task $task){    
        $user = Auth::user();
        $user_id = $user->id;
        $task->delete();
        $action = 'Task deleted';
        $details = 'Removed ' . $task->task_name;

        ActivityLog::create([
            'user_id' => $user_id,
            'action' => $action,
            'details' => $details
        ]);
        return redirect()->route('admin.tasks')->with('warning', 'Task name successfully deleted.');
    }
}
