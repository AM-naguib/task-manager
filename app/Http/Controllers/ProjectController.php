<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user->type == "admin") {
            $projects = Project::get();
        } else {
            $userId = $user->id;
            $projects = Project::whereHas('tasks', function ($query) use ($userId) {
                $query->whereHas('users', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                });
            })->get();
        }
        return view('pages.projects.index', compact("projects"));
    }

    public function projectDocument(Project $project)
    {
        $project->load('document.documenFiles');

        return response()->json([
            "message" => "Success",
            "project" => $project,
        ], 200);
    }
}
