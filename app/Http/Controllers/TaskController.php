<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    // GET /tasks
    public function index(): JsonResponse
    {
        return response()->json(Task::all());
    }

    // GET /tasks/{id}
    public function show(int $id): JsonResponse
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Aufgabe nicht gefunden'], 404);
        }

        return response()->json($task);
    }

    // POST /tasks
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task = Task::create($validated);
        return response()->json($task, 201);
    }

    // PUT /tasks/{id}
    public function update(Request $request, int $id): JsonResponse
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Aufgabe nicht gefunden'], 404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task->update($validated);
        return response()->json($task);
    }

    // DELETE /tasks/{id}
    public function destroy(int $id): JsonResponse
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Aufgabe nicht gefunden'], 404);
        }

        $task->delete();
        return response()->json(null, 204);
    }
}
