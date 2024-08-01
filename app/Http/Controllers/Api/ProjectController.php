<?php

namespace App\Http\Controllers\Api;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "status" => "nullable",
            "summary" => "nullable",
            "description" => "nullable",
            "priority" => "nullable",
            "user_id" => "required"
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {

            $project = Project::create($validator->validated());
            return response()->json(["message" => "Project created", "project" => $project], 201);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return response()->json(["message" => "Success", "project" => [$project, "tasks" => $project->tasks]], 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "status" => "nullable",
            "summary" => "nullable",
            "description" => "nullable",
            "priority" => "nullable",
            "user_id" => "required"
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {

            $project->update($validator->validated());
            return response()->json(["message" => "Project Updated", "project" => $project], 201);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        try {
            $project->delete();
            return response()->json(["message" => "Project Deleted"], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }
}
