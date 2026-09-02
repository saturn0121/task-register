@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto p-4">
<h1 class="text-2xl font-bold mb-4">Delete Task</h1>

<form method="POST" action="{{ route('tasks.destroy', $task) }}" class="space-y-4">
    @csrf
    @method('DELETE')
    <input type="text" name="title" placeholder="Title" value="{{ $task->title }}" class="w-full border rounded px-2 py-1">
    <textarea name="description" placeholder="Description" class="w-full border rounded px-2 py-1">{{ $task->description }}</textarea>
    <select name="status" class="w-full border rounded px-2 py-1">
        <option value="open" @selected($task->status == 'open')>Open</option>
        <option value="in_progress" @selected($task->status == 'in_progress')>In Progress</option>
        <option value="done" @selected($task->status == 'done')>Done</option>
    </select>
    <input type="date" name="due_date" value="{{ $task->due_date }}" class="w-full border rounded px-2 py-1">
    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Delete</button>
</form>
</div>
@endsection