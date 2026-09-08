@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Task Register</h1>

    <a href="{{ route('tasks.create') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mb-4">New Task</a>

    <form id="filterForm" class="flex flex-col gap-2 sm:flex-row sm:items-center mb-4">
        <input type="text" name="search" placeholder="Search title..." class="border rounded px-2 py-1">
        <select name="status" class="border rounded px-2 py-1">
            <option value="">All statuses</option>
            <option value="open">Open</option>
            <option value="in_progress">In Progress</option>
            <option value="done">Done</option>
        </select>
        <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Filter</button>
    </form>

    <p id="tasksLoading" class="text-gray-500 mb-2">Loading...</p>
    <p id="tasksError" class="hidden text-red-600 mb-2"></p>

    <ul id="taskList" class="divide-y border rounded"></ul>
</div>

<script>
    function escapeHtml(value) {
        const div = document.createElement('div');
        div.textContent = value ?? '';
        return div.innerHTML;
    }

    async function loadTasks() {
        const loadingEl = document.getElementById('tasksLoading');
        const errorEl = document.getElementById('tasksError');
        const listEl = document.getElementById('taskList');
        const search = document.querySelector('#filterForm [name="search"]').value;
        const status = document.querySelector('#filterForm [name="status"]').value;

        errorEl.classList.add('hidden');
        listEl.innerHTML = '';
        loadingEl.classList.remove('hidden');

        const params = new URLSearchParams();
        if (search) params.set('search', search);
        if (status) params.set('status', status);

        try {
            const response = await fetch(`/api/tasks?${params.toString()}`, {
                headers: { 'Accept': 'application/json' },
            });

            if (!response.ok) {
                errorEl.textContent = `Failed to load tasks (status ${response.status}).`;
                errorEl.classList.remove('hidden');
                return;
            }

            const tasks = await response.json();

            if (tasks.length === 0) {
                listEl.innerHTML = '<li class="p-3">No tasks yet.</li>';
                return;
            }

            tasks.forEach(function (task) {
                const li = document.createElement('li');
                li.className = 'flex flex-col sm:flex-row sm:justify-between sm:items-center p-3 gap-2';
                li.innerHTML =
                    escapeHtml(task.title) + ' — ' + escapeHtml(task.status) + ' : ' +
                    '<div class="flex gap-3">' +
                    '<a href="/tasks/' + task.id + '/edit" class="text-blue-600 hover:underline">Edit</a> : ' +
                    '<a href="/tasks/' + task.id + '/delete" class="text-red-600 hover:underline">Delete</a>' +
                    '</div>';
                listEl.appendChild(li);
            });
        } catch (err) {
            errorEl.textContent = 'Network error — check your connection and try again.';
            errorEl.classList.remove('hidden');
        } finally {
            loadingEl.classList.add('hidden');
        }
    }

    document.getElementById('filterForm').addEventListener('submit', function (e) {
        e.preventDefault();
        loadTasks();
    });

    loadTasks();
</script>
@endsection