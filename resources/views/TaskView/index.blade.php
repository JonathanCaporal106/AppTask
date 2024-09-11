<x-app-layout>
   

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Task CRUD</title>
                    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
                </head>
                <body>
                <div class="container mt-5">
                    <h2 class="mb-4">Task CRUD</h2>

                    <div>
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createTaskModal">
                            New Task
                        </button>
                    </div>

                    <!-- Mensajes de éxito y error -->
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success mt-4">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger mt-4">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <!-- Lista de tareas -->
                    <table class="table table-bordered mt-4 rounded-lg" style="border-radius: 12px; overflow: hidden;">
                        <thead class="bg-blue-500 text-white">
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Title</th>
                                <th class="text-center">Description</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Priority</th>
                                <th class="text-center">Hour</th>
                                <th class="text-center">Due Date</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($Tasks as $Task)
                            <tr class="bg-gray-300">
                                <td class="text-center">{{$Task->id}}</td>
                                <td>{{$Task->title}}</td>
                                <td>{{$Task->description}}</td>
                                <td>{{$Task->status}}</td>
                                <td class="text-center">{{$Task->priority}}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($Task->due_time)->format('g:i A') }}</td>
                                <td class="text-center">{{$Task->due_date}}</td>
                                <td class="flex justify-center">
                                    <div class="mr-3">
                                        <!-- Botón para abrir el modal con la tarea actual -->
                                        <button class="btn w-16 h-10 btn-primary btn-sm" data-toggle="modal" data-target="#editTaskModal-{{$Task->id}}">
                                            Edit
                                        </button>
                                    </div>
                            
                                        <button data-toggle="modal" data-target="#confirmDeleteModal--{{$Task->id}}"  class="btn btn-danger">Delete</button>                   
                                </td>
                            </tr>

                            
<!-- Modal Delete Task -->
<div class="modal fade" id="confirmDeleteModal--{{$Task->id}}" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Task</h5>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this task?</p>
            </div>
            <div class="modal-footer">
                <form action="{{ route('Tasks.destroy', $Task->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>


                            
                            
                            <!-- Modal de edición para cada tarea -->
                            <div class="modal fade" id="editTaskModal-{{$Task->id}}" tabindex="-1" role="dialog" aria-labelledby="editTaskModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editTaskModalLabel">Editar Tarea</h5>
                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('Tasks.update', $Task->id) }}" method="POST">
                                                @csrf           
                                                @method('PATCH')                  
                                                <input type="hidden" name="id" value="{{$Task->id}}">
                                                <div class="form-group">
                                                    <label for="edit-title-{{$Task->id}}">Title:</label>
                                                    <input type="text" class="form-control" id="edit-title-{{$Task->id}}" name="title" value="{{$Task->title}}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit-description-{{$Task->id}}">Description:</label>
                                                    <textarea class="form-control" id="edit-description-{{$Task->id}}" name="description">{{$Task->description}}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit-status-{{$Task->id}}">Status:</label>
                                                    <select class="form-control" id="edit-status-{{$Task->id}}" name="status" required>
                                                        <option value="pending" {{ $Task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                        <option value="in_progress" {{ $Task->status == 'in progress' ? 'selected' : '' }}>In Progress</option>
                                                        <option value="completed" {{ $Task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit-priority-{{$Task->id}}">Priority:</label>
                                                    <input type="number" class="form-control" id="edit-priority-{{$Task->id}}" name="priority" value="{{$Task->priority}}" required min="1" max="3">
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit-due_time-{{$Task->id}}">Due Time:</label>
                                                    <input type="time" class="form-control" id="edit-due_time-{{$Task->id}}" name="due_time" value="{{ \Carbon\Carbon::parse($Task->due_time)->format('H:i') }}">
                                                </div>                        
                                                <div class="form-group">
                                                    <label for="edit-due_date-{{$Task->id}}">Due Date:</label>
                                                    <input type="date" class="form-control" id="edit-due_date-{{$Task->id}}" name="due_date" value="{{$Task->due_date}}">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Update Task</button>
                                            </form> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                </body>
                </html>
            </div>
        </div>
    </div>

    <!-- Modal para crear nueva tarea -->
    <div class="modal fade" id="createTaskModal" tabindex="-1" role="dialog" aria-labelledby="createTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content W-300">
                <div class="modal-header">
                    <h5 class="modal-title" id="createTaskModalLabel">Crear Nueva Tarea</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('Tasks.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            <label for="title">Title:</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="status">Status:</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="pending">Pending</option>
                                <option value="in progress">In Progress</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="priority">Priority:</label>
                            <input type="number" class="form-control" id="priority" name="priority" required min="1" max="3">
                        </div>
                        <div class="form-group">
                            <label for="due_time">Due Time:</label>
                            <input type="time" class="form-control" id="due_time" name="due_time">
                        </div>                        
                        <div class="form-group">
                            <label for="due_date">Due Date:</label>
                            <input type="date" class="form-control" id="due_date" name="due_date">
                        </div>
                        <button type="submit" class="btn btn-primary">Create Task</button>
                    </form> 
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</x-app-layout>
