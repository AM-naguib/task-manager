@extends('layout.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-main">
                    <div class="breadcrumb-action justify-content-center flex-wrap">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                            Add Task
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header color-dark fw-500">
                        <p>All Tasks</p>
                    </div>
                    <div class="card-body p-0">
                        <div class="table4 p-25 mb-30">

                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr class="userDatatable-header">
                                            <th>
                                                <span class="userDatatable-title">#</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">Name</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">Status</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">Priority</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">Deadline</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">Project</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">Assigned To</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">Action</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse ($tasks as $task)
                                            <tr>

                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $task->name }}</td>
                                                <td>{{ $task->status }}</td>
                                                <td>{{ $task->priority }}</td>
                                                <td>{{ $task->deadline }}</td>
                                                <td>{{ $task->project->name ?? '' }}</td>
                                                <td>
                                                    @foreach ($task->users as $user)
                                                        <span class="p-1 bg-primary rounded text-white"
                                                            style="font-size: 12px">{{ $user->name }}</span>
                                                    @endforeach
                                                </td>

                                                <td class="d-flex  gap-2">
                                                    <button class="btn btn-primary"  onclick="fillShow({{ $task->id }})">View</button>
                                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                        onclick="fillUpdateForm({{ $task->id }})">
                                                        Update Task
                                                    </button>

                                                    <button class="btn btn-danger"
                                                        onclick="deleteForm({{ $task->id }})">Delete</button>

                                                @empty
                                        @endforelse



                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>


    <!-- Button trigger modal -->


    <!-- Add Task Modal -->
    <div class="modal fade" id="addTaskModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="addTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addTaskModalLabel">Add Project</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('tasks.store') }}" method="POST" id="addForm">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Task Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="priority" class="form-label">Task Priority</label>
                            <select name="priority" id="priority" class="form-select">
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Task Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="On Hold">On Hold</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="project" class="form-label">Project</label>
                            <select name="project_id" id="project" class="form-select">
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="assign" class="form-label">Assign To</label>
                            <select name="users[]" id="assign" class="form-select" multiple>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="deadline" class="form-label">Task Deadline</label>
                            <input type="text" id="datepicker" name="deadline" class="form-control"
                                placeholder="Select a date">
                        </div>
                        <div class="col-lg-12">
                            <div class="bg-white mb-25 rounded-xl">
                                <div class="reply-form pt-0">
                                    <div class="mailCompose-form-content">
                                        <div class="form-group">
                                            <textarea name="description" id="mail-reply-message2" class="form-control-lg" placeholder="Type your message..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Task Modal -->
    <div class="modal fade" id="updateTaskModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="updateTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="updateTaskModalLabel">Update Project</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="updateForm">
                        @csrf
                        @method('put')
                        <div class="mb-3">
                            <label for="name" class="form-label">Task Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>

                        <div class="mb-3">
                            <label for="priority" class="form-label">Task Priority</label>
                            <select name="priority" id="priority" class="form-select">
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Task Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="On Hold">On Hold</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="project" class="form-label">Project</label>
                            <select name="project_id" id="project" class="form-select">
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="assign" class="form-label">Assign To</label>
                            <select name="users[]" id="assign" class="form-select" multiple>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="deadline" class="form-label">Task Deadline</label>
                            <input type="text" id="datepicker" name="deadline" class="form-control"
                                placeholder="Select a date">
                        </div>
                        <div class="col-lg-12">
                            <div class="bg-white mb-25 rounded-xl">
                                <div class="reply-form pt-0">
                                    <div class="mailCompose-form-content">
                                        <div class="form-group">
                                            <textarea name="description" id="mail-reply-message3" class="form-control-lg description"
                                                placeholder="Type your message..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{-- <div class="col-lg-12">
        <div class="bg-white mb-25 rounded-xl">
            <div class="reply-form pt-0">
                <form action="#">
                    <div class="mailCompose-form-content">
                        <div class="form-group">
                            <textarea name="message" id="mail-reply-message2" class="form-control-lg" placeholder="Type your message..."></textarea>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}








    <div class="modal fade" id="showTaskModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="showTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="showTaskModalLabel">show Project</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                    <div class="mb-3">
                        <label for="name" class="form-label">Task Name</label>
                        <input type="text" class="form-control" id="nameShow"  readonly >
                    </div>

                    <div class="mb-3">
                        <label for="priority" class="form-label">Task Priority</label>
                        <select   id="priorityShow" class="form-select">
                            <option value="Low">Low</option>
                            <option value="Medium">Medium</option>
                            <option value="High">High</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Task Status</label>
                        <select   id="statusShow" class="form-select">
                            <option value="On Hold">On Hold</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Completed">Completed</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="project" class="form-label">Project</label>
                        <select   id="projectShow" class="form-select">
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="assign" class="form-label">Assign To</label>
                        <select   id="assignShow" class="form-select" multiple>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="deadline" class="form-label">Task Deadline</label>
                        <input type="text"   id="deadlineShow" class="form-control"
                            placeholder="Select a date">
                    </div>
                    <div class="col-lg-12">
                        <div class="bg-white mb-25 rounded-xl">
                            <div class="reply-form pt-0">
                                <div class="mailCompose-form-content">
                                    <div class="form-group">
                                        <textarea   id="mail-reply-message3" class="form-control-lg descriptionShow"
                                            placeholder="Type your message..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                     </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection



@section('js_footer')
    <script>
        function fillUpdateForm(id) {
            $.ajax({
                url: `{{ route('tasks.show', '') }}/${id}`,
                type: 'get',
                success: function(data) {
                    console.log('Form submitted successfully:', data);

                    $("#updateTaskModal").modal('show');
                    $('#updateForm').attr('action', `{{ route('tasks.update', '') }}/${id}`);
                    $('#updateTaskModal #name').val(data.task.name || '');
                    $('#updateTaskModal .description').val(data.task.description || '');
                    $('#updateTaskModal #priority').val(data.task.priority || '');
                    $('#updateTaskModal #status').val(data.task.status || '');
                    $('#updateTaskModal #project').val(data.task.project_id || '');
                    $('#updateTaskModal #datepicker').val(data.task.deadline || '');

                    let userIds = data.task.user_ids || [];

                    // Clear previous selections
                    $('#updateTaskModal #assign option').prop('selected', false);

                    // Set new selections
                    $('#updateTaskModal #assign option').each(function() {
                        let optionValue = parseInt($(this).val());
                        if (userIds.includes(optionValue)) {
                            $(this).prop('selected', true);
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Form submission error:', error, xhr.responseText);
                }
            });
        }


        function fillShow(id) {
            $.ajax({
                url: `{{ route('tasks.show', '') }}/${id}`,
                type: 'get',
                success: function(data) {

                    $("#showTaskModal").modal('show');
                     $('#nameShow').val(data.task.name || '');
                    $('.descriptionShow').val(data.task.description || '');
                    $('#priorityShow').val(data.task.priority || '');
                    $('#statusShow').val(data.task.status || '');
                    $('#projectShow').val(data.task.project_id || '');
                    $('#deadlineShow').val(data.task.deadline || '');

                     let userIds = data.task.user_ids || [];

                    // // Clear previous selections

                    // Set new selections
                    $('#assignShow option').each(function() {
                        let optionValue = parseInt($(this).val());
                        if (userIds.includes(optionValue)) {
                            $(this).prop('selected', true);
                        }
                     });
                },
                error: function(xhr, status, error) {
                    console.error('Form submission error:', error, xhr.responseText);
                }
            });
        }



        $(document).on('submit', '#addForm', function(event) {
            event.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                    console.log('Form submitted successfully:', response);
                    $('#addTaskModal').modal('hide');
                    $("table").load(location.href + " table ");
                },
                error: function(xhr) {
                    console.error('Form submission error:', xhr.responseText);
                }
            });
        });

        $(document).on('submit', '#updateForm', function(event) {
            event.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                     $('#staticBackdrop').modal('hide');
                     $("table").load(location.href + " table ");
                     $("#updateTaskModal").modal('hide');

                },
                error: function(xhr) {
                    console.error('Form update error:', xhr.responseText);
                }
            });
        });

        function deleteForm(id) {
            if (confirm("Are you sure you want to delete this Task?")) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('projects.destroy', ':id') }}".replace(':id', id),
                    success: function(response) {
                        $("table").load(location.href + " table ");
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                })
            }
        }

        jQuery(document).ready(function($) {
            $("#datepicker").datepicker();
        });
    </script>
@endsection
