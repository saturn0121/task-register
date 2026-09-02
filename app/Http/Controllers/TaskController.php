<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $query = Task::query();

        if (request('search')) {
            $query->where('title', 'like', '%' . request('search') . '%');
        }

        if (request('status')) {
            $query->where('status', request('status'));
        }

        $tasks = $query->get();

        return view('tasks.index', compact('tasks'));
    }
    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:open,in_progress,done',
            'due_date' => 'nullable|date',
        ]);

        Task::create($validated);

        return redirect()->route('tasks.index');
    }
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }
     public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:open,in_progress,done',
            'due_date' => 'nullable|date',
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index');
    }
    public function delete(Task $task)
    {
        return view('tasks.delete', compact('task'));
    }
     public function destroy(Task $task)
    {
        Task::destroy($task->id);

        return redirect()->route('tasks.index');
    }
}