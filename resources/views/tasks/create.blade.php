@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">New Task</h1>

    <p id="createError" class="hidden text-red-600 mb-4"></p>

    <form id="createForm" class="space-y-4">
        <input type="text" name="title" placeholder="Title" class="w-full border rounded px-2 py-1">
        <textarea name="description" placeholder="Description" class="w-full border rounded px-2 py-1"></textarea>
        <select name="status" class="w-full border rounded px-2 py-1">
            <option value="open">Open</option>
            <option value="in_progress">In Progress</option>
            <option value="done">Done</option>
        </select>
        <input type="date" name="due_date" class="w-full border rounded px-2 py-1">
        <button type="submit" id="createBtn" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Create</button>
    </form>
</div>

<script>
    document.getElementById('createForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        const form = this;
        const button = document.getElementById('createBtn');
        const errorEl = document.getElementById('createError');

        errorEl.classList.add('hidden');
        errorEl.textContent = '';
        button.disabled = true;
        button.textContent = 'Creating...';

        const payload = {
            title: form.title.value,
            description: form.description.value,
            status: form.status.value,
            due_date: form.due_date.value,
        };

        try {
            const response = await fetch('/api/tasks', {
                method: 'POST',
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
                errorEl.textContent = `Create failed (status ${response.status}).`;
            }
            errorEl.classList.remove('hidden');
            button.disabled = false;
            button.textContent = 'Create';
        } catch (err) {
            errorEl.textContent = 'Network error — check your connection and try again.';
            errorEl.classList.remove('hidden');
            button.disabled = false;
            button.textContent = 'Create';
        }
    });
</script>
@endsection