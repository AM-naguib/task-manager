<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class TaskController extends Controller
{

    public function index()
    {
        return response()->json(["message" => "Success", "tasks" => Task::all()], 200);
    }




    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "summary" => "nullable",
            "status" => "nullable",
            "deadline" => "nullable",
            "priority" => "nullable",
            "description" => "nullable",
            "project_id"=>"required",
            "created_by" => "required"
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {

            $task = Task::create($validator->validated());
            return response()->json(["message" => "Task created", "task" => $task], 201);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return response()->json(["message" => "Success", "task" => $task], 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "summary" => "nullable",
            "status" => "nullable",
            "deadline" => "nullable",
            "priority" => "nullable",
            "description" => "nullable",
            "project_id"=>"required",
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {

            $task->update($validator->validated());
            return response()->json(["message" => "Project Updated", "project" => $task], 201);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        try {
            $task->delete();
            return response()->json(["message" => "Task Deleted"], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }
}
