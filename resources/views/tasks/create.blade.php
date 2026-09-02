@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto p-4">
<h1 class="text-2xl font-bold mb-4">New Task</h1>

<form method="POST" action="{{ route('tasks.store') }}" class="space-y-4">
    @csrf
    <input type="text" name="title" placeholder="Title" class="w-full border rounded px-2 py-1"> 
    <textarea name="description" placeholder="Description" class="w-full border rounded px-2 py-1"></textarea>
    <select name="status" class="w-full border rounded px-2 py-1">
        <option value="open">Open</option>
        <option value="in_progress">In Progress</option>
        <option value="done">Done</option>
    </select>
    <input type="date" name="due_date" class="w-full border rounded px-2 py-1">
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Create</button>
</form>
</div>
@endsection