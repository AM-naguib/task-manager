<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use App\Events\TaskCreated;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class TaskController extends Controller
{

    public function index()
    {
        return response()->json(["message" => "Success", "tasks" => Task::all()], 200);
    }




    public function store(Request $request)
    {
        $request["created_by"]= auth()->user()->id;
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "summary" => "nullable",
            "status" => "nullable",
            "deadline" => "nullable",
            "priority" => "nullable",
            "description" => "nullable",
            "project_id" => "nullable",
            "users" => "required|array",
            "created_by" => "required"
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            $data = $validator->validated();
            unset($data["users"]);

            $task = Task::create($data);
            $task->users()->attach($request->users);
            event(new TaskCreated($task));
            return response()->json([
            "message" => "Task created",
            "task" => $task,
            "users" => $request->users
            ], 201);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $taskData = $task->load('comments',"project","users","createdBy")->toArray(); // Convert task and its comments to an array

        $taskData['user_ids'] = $task->users->pluck('id');

        return response()->json([
            "message" => "Success",
            "task" => $taskData,
        ], 200);
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
            "project_id" => "nullable",
            "users" => "required|array",
            'users.*'     => 'exists:users,id'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        try {
            $data = $validator->validated();
            unset($data["users"]);
            $task->update($data);
            $task->users()->sync($request->users);
            toastr()->success('Task edited successfully!');
            return to_route("tasks.index");
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
