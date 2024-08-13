<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(){
        $projects = Project::get();
        return view('pages.projects.index',compact("projects"));
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
