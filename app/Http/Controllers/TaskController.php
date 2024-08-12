<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(){
        $tasks = Task::get();
        $projects = Project::get();
        $users = User::get();
        return view("pages.tasks.index",compact("tasks","projects","users"));
    }
}
