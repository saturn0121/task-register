@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-4">
<h1 class="text-2xl font-bold mb-4">Task Register</h1>

<a href="{{ route('tasks.create') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mb-4">New Task</a>

<form method="GET" action="{{ route('tasks.index') }}" class="flex flex-col gap-2 sm:flex-row sm:items-center mb-4">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search title..." class="border rounded px-2 py-1">
    <select name="status" class="border rounded px-2 py-1">
        <option value="">All statuses</option>
        <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
        <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>Done</option>
    </select>
    <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Filter</button>
</form>

<ul class="divide-y border rounded">
    @forelse ($tasks as $task)
        <li class="flex flex-col sm:flex-row sm:justify-between sm:items-center p-3 gap-2">{{ $task->title }} — {{ $task->status }} :  <div class="flex gap-3"><a href="{{ route('tasks.edit', $task) }}" class="text-blue-600 hover:underline">Edit</a> : <a href="{{ route('tasks.delete', $task) }}" class="text-red-600 hover:underline">Delete</a></div></li>
    @empty
        <li class="flex flex-col sm:flex-row sm:justify-between sm:items-center p-3 gap-2">No tasks yet.</li>
    @endforelse
</ul>
</div>
@endsection