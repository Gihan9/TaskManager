
<div class="container mt-5">
        <div class="card p-4 shadow-lg rounded">
            <h2 class="text-center">My Tasks</h2>
            <button class="btn btn-custom w-100 mb-3" data-bs-toggle="modal" data-bs-target="#addTaskModal">+ Add Task</button>
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Due Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $task)
                        <tr>
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->description }}</td>
                            <td>
                                <button class="taskStatus btn btn-sm {{ $task->status == 'Completed' ? 'btn-success' : 'btn-warning' }}" data-id="{{ $task->id }}">
                                    {{ $task->status }}
                                </button>
                            </td>
                            <td>{{ $task->due_date }}</td>
                            <td>
                                <button class="btn btn-warning editTaskBtn" data-id="{{ $task->id }}">Edit</button>
                                <button class="btn btn-danger deleteTaskBtn" data-id="{{ $task->id }}">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

<!-- Add Task Modal -->
<div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content p-3">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTaskModalLabel">Add Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addTaskForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" id="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Due Date</label>
                            <input type="date" name="due_date" id="due_date" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-custom w-100">Add Task</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


<!-- Edit Task Modal -->
<div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTaskModalLabel">Edit Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editTaskForm">
                    @csrf
                    @method('PUT') <!-- Laravel requires this for updating -->
                    <input type="hidden" id="editTaskId">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" id="editTitle" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="editDescription" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Due Date</label>
                        <input type="date" name="due_date" id="editDueDate" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success">Update Task</button>
                </form>
            </div>
        </div>
    </div>
</div>



