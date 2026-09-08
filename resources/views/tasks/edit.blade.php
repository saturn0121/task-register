@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Edit Task</h1>

    <p id="editError" class="hidden text-red-600 mb-4"></p>

    <form id="editForm" data-task-id="{{ $task->id }}" class="space-y-4">
        <input type="text" name="title" placeholder="Title" value="{{ $task->title }}" class="w-full border rounded px-2 py-1">
        <textarea name="description" placeholder="Description" class="w-full border rounded px-2 py-1">{{ $task->description }}</textarea>
        <select name="status" class="w-full border rounded px-2 py-1">
            <option value="open" @selected($task->status == 'open')>Open</option>
            <option value="in_progress" @selected($task->status == 'in_progress')>In Progress</option>
            <option value="done" @selected($task->status == 'done')>Done</option>
        </select>
        <input type="date" name="due_date" value="{{ $task->due_date }}" class="w-full border rounded px-2 py-1">
        <button type="submit" id="saveBtn" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
    </form>
</div>

<script>
    document.getElementById('editForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        const form = this;
        const taskId = form.dataset.taskId;
        const button = document.getElementById('saveBtn');
        const errorEl = document.getElementById('editError');

        errorEl.classList.add('hidden');
        errorEl.textContent = '';
        button.disabled = true;
        button.textContent = 'Saving...';

        const payload = {
            title: form.title.value,
            description: form.description.value,
            status: form.status.value,
            due_date: form.due_date.value,
        };

        try {
            const response = await fetch(`/api/tasks/${taskId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(payload),
            });

            if (response.ok) {
                window.location.href = '/tasks';
                return;
            }

            if (response.status === 422) {
                const data = await response.json();
                const messages = Object.values(data.errors).flat();
                errorEl.textContent = messages.join(' ');
            } else {
                errorEl.textContent = `Update failed (status ${response.status}).`;
            }
            errorEl.classList.remove('hidden');
            button.disabled = false;
            button.textContent = 'Update';
        } catch (err) {
            errorEl.textContent = 'Network error — check your connection and try again.';
            errorEl.classList.remove('hidden');
            button.disabled = false;
            button.textContent = 'Update';
        }
    });
</script>
@endsection