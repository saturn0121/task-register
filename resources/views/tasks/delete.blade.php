@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Delete Task</h1>

    <div class="space-y-2 mb-4">
        <p><span class="font-semibold">Title:</span> {{ $task->title }}</p>
        <p><span class="font-semibold">Description:</span> {{ $task->description }}</p>
        <p><span class="font-semibold">Status:</span> {{ $task->status }}</p>
        <p><span class="font-semibold">Due date:</span> {{ $task->due_date }}</p>
    </div>

    <p id="deleteError" class="hidden text-red-600 mb-2"></p>

    <button id="confirmDeleteBtn" data-task-id="{{ $task->id }}"
            class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
        Delete
    </button>
</div>

<script>
    document.getElementById('confirmDeleteBtn').addEventListener('click', async function () {
        const button = this;
        const taskId = button.dataset.taskId;
        const errorEl = document.getElementById('deleteError');

        errorEl.classList.add('hidden');
        button.disabled = true;
        button.textContent = 'Deleting...';

        try {
            const response = await fetch(`/api/tasks/${taskId}`, {
                method: 'DELETE',
            });

            if (response.ok) {
                window.location.href = '/tasks';
                return;
            }

            errorEl.textContent = `Delete failed (status ${response.status}).`;
            errorEl.classList.remove('hidden');
            button.disabled = false;
            button.textContent = 'Delete';
        } catch (err) {
            errorEl.textContent = 'Network error — check your connection and try again.';
            errorEl.classList.remove('hidden');
            button.disabled = false;
            button.textContent = 'Delete';
        }
    });
</script>
@endsection