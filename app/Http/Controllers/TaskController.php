<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = auth()->user()->tasks()->paginate(10);
        return view('tasks.index', compact('tasks'));
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required|min:10',
            'due_date' => 'required|date|after:today',
        ]);
        $task = auth()->user()->tasks()->create($request->all());
        return response()->json(['task' => $task], 201);
    }

        public function edit(Task $task)
        {
            return response()->json(['task' => $task]);
        }
    

    public function update(Request $request, Task $task)
    {
        if (auth()->id() !== $task->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required|min:10',
            'due_date' => 'required|date|after:today',
        ]);

        $task->update($validated);

        return response()->json(['task' => $task]);
    }

    public function destroy(Task $task): JsonResponse
    {
        if (auth()->id() !== $task->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $task->delete();
        return response()->json(['message' => 'Task deleted successfully']);
    }

    public function toggleStatus(Request $request, Task $task)
    {
        if (auth()->id() !== $task->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'status' => 'required|in:Pending,Completed',
        ]);

        $task->update(['status' => $validated['status']]);

        return response()->json([
            'message' => 'Task status updated successfully',
            'status' => $task->status
        ]);
    }



}
