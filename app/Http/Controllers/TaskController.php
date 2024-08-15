<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use App\Events\StatusUpdate;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(){
        $user = auth()->user();
        if($user->type == "admin"){
            $tasks = Task::all();
        }else{
            $tasks = $user->tasks;
        }

        $projects = Project::get();
        $users = User::get();
        return view("pages.tasks.index",compact("tasks","projects","users"));
    }


    public function edit(Task $task){
        $projects = Project::get();
        $users = User::get();

        return view("pages.tasks.edit",compact("task","projects","users"));
    }

    public function updateStatus(Request $request, Task $task){
            $task->status = $request->status;
            $task->save();
            if($task->status == "Ready For Test"){
                event(new StatusUpdate($task));
            }
            return response()->json(["message" => "Status Updated"], 200);
    }
}
