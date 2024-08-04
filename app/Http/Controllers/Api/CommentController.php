<?php

namespace App\Http\Controllers\Api;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function store(Request $request)
    {

        $request["user_id"] = auth()->user()->id;

        $commentValidator = Validator::make($request->all(), [
            "task_id" => "required|exists:tasks,id",
            "comment" => "required",
            "user_id" => "required|exists:users,id"
        ]);

        if ($commentValidator->fails()) {
            return response()->json($commentValidator->errors(), 401);
        }
        try {
            $comment = Comment::create($commentValidator->validated());
            return response()->json($comment, 201);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }




    public function update(Request $request, Comment $comment){
        $user = auth()->user();
        if($user->id != $comment->user_id){
            return response()->json(["message" => "Unauthorized"], 401);
        }

        $commentValidator = Validator::make($request->all(), [
            "comment" => "required"
        ]);
        if ($commentValidator->fails()) {
            return response()->json($commentValidator->errors(), 401);
        }
        try {
            $comment->update($commentValidator->validated());
            return response()->json($comment, 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }


    public function destroy(Comment $comment){

        $user = auth()->user();
        if($user->id != $comment->user_id){
            return response()->json(["message" => "Unauthorized"], 401);
        }
        try {
            $comment->delete();
            return response()->json(["message" => "Comment Deleted"], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }
}
