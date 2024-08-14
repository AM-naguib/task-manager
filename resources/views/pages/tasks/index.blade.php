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
                        <p class="m-0">All Tasks</p>
                    </div>
                    <div class="card-body p-0">
                        <table id="tasksTable" class="table table-bordered ">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Priority</th>
                                    <th>Project</th>
                                    <th>Status</th>
                                    <th>Deadline</th>
                                    <th>Assigned Users</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tasks as $task)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $task->name }}</td>
                                    <td style="color: @if ($task->priority == 'High') red @elseif ($task->priority == 'Medium') #a3a300 @endif">
                                        {{ $task->priority }}</td>
                                    <td>{{ $task->project->name ?? '' }}</td>
                                    <td style="color: @if ($task->status == 'Not Started') #adadad @elseif ($task->status == 'Assigned') #f90000 @elseif ($task->status == 'Ready For Test') #fbbc00 @elseif ($task->status == 'In Progress') #1103d1 @elseif ($task->status == 'Done') #5ac100 @endif">
                                        {{ $task->status }}</td>
                                    <td>{{ \Carbon\Carbon::parse($task->deadline)->format('d-m-Y') }}</td>
                                    <td>
                                        @foreach ($task->users as $user)
                                        <span class="p-1 bg-primary rounded text-white" style="font-size: 12px">{{ $user->name }}</span>
                                        @endforeach
                                    </td>
                                    <td class="d-flex align-items-center p-4">
                                        <button type="button" onclick="fillShow({{ $task->id }})" class="btn text-primary" data-toggle="modal"
                                            data-target="#rightModal">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <a href="{{ route('tasks.edit', $task->id) }}" class="btn text-warning"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <button class="btn text-center text-danger" onclick="deleteForm({{ $task->id }})"><i
                                                class="fa-solid fa-trash"></i></button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8">No tasks available.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- <div class="table4 p-25 mb-30">

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
                                                <span class="userDatatable-title">Priority</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">Project</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">Status</span>
                                            </th>

                                            <th>
                                                <span class="userDatatable-title">Deadline</span>
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
                                                <td
                                                    style="color:
                                                @if ($task->priority == 'High') red
                                                @elseif ($task->priority == 'Medium')
                                                    #a3a300 @endif">
                                                    {{ $task->priority }}
                                                </td>
                                                <td>{{ $task->project->name ?? '' }}</td>
                                                <td
                                                    style="color:@if ($task->status == 'Not Started') #adadad @elseif ($task->status == 'Assigned') #f90000 @elseif ($task->status == 'Ready For Test') #fbbc00 @elseif ($task->status == 'In Progress') #1103d1 @elseif ($task->status == 'Done') #5ac100 @endif">
                                                    {{ $task->status }}</td>
                                                <td>{{ \Carbon\Carbon::parse($task->deadline)->format('d-m-Y') }}</td>

                                                <td>
                                                    @foreach ($task->users as $user)
                                                        <span class="p-1 bg-primary rounded text-white"
                                                            style="font-size: 12px">{{ $user->name }}</span>
                                                    @endforeach
                                                </td>

                                                <td class="d-flex align-items-center p-4 ">
                                                    <button type="button" onclick="fillShow({{ $task->id }})"
                                                        class="btn text-primary" data-toggle="modal"
                                                        data-target="#rightModal">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </button>

                                                    <a href="{{ route('tasks.edit', $task->id) }}"
                                                        class="btn text-warning"><i class="fa-solid fa-pen-to-square"></i></a>


                                                    <button class="btn text-center text-danger"
                                                        onclick="deleteForm({{ $task->id }})"><i class="fa-solid fa-trash"></i></button>

                                                @empty
                                        @endforelse



                                    </tbody>
                                </table>
                            </div>
                        </div> --}}
                    </div>
                </div>

            </div>

        </div>
    </div>





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
                                <option value="Not Started">Not Started</option>
                                <option value="Assigned">Assigned</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Ready For Test">Ready For Test</option>
                                <option value="Done">Done</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="project" class="form-label">Project</label>
                            <select name="project_id" id="project" class="form-select">
                                <option value="">Select Project</option>
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
                                            <textarea name="description" id="mail-reply-message" class="form-control-lg negoss"
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












    <style>
        .modal.right .modal-dialog {
            position: fixed;
            right: 0;
            margin: auto;
            width: 1500px;
            height: 100%;
            transform: translate3d(100%, 0, 0);
            transition: transform 0.3s ease-out;
        }

        .modal.right .modal-content {
            height: 100%;
            overflow-y: auto;
        }

        .modal.fade .modal-dialog {
            transform: translate3d(100%, 0, 0);
        }

        .modal.show .modal-dialog {
            transform: translate3d(0, 0, 0);
        }
    </style>



    <!-- Modal -->
    <div class="modal right fade" id="rightModal" tabindex="-1" role="dialog" aria-labelledby="rightModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="taskTitle">Right Side Modal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="task">
                        <div class="task-head border-bottom">
                            <div class="task-title d-flex gap-1 mb-1">
                                <p class="m-0">Task Name : </p>
                                <p class="m-0" id="taskName"></p>
                            </div>

                            <div class="task-project d-flex gap-1 mb-1">
                                <p class="m-0">Project Name : </p>
                                <p class="m-0" id="projectName">dasda</p>
                            </div>

                            <div class="task-status mb-1 gap-1  d-flex">
                                <p class="m-0">Task Status : </p>
                                <p class="m-0" id="taskStatus"></p>
                            </div>

                            <div class="task-priority mb-1 gap-1 d-flex">
                                <p class="m-0">Task Priority : </p>
                                <p class="m-0" id="taskPriority"></p>
                            </div>


                            <div class="task-assign mb-1 gap-1 d-flex">
                                <p class="m-0">Assign To : </p>
                                <p class="m-0" id="taskAssign"></p>
                            </div>
                            <div class="task-created-ay mb-1 gap-1 d-flex">
                                <p class="m-0">Created By : </p>
                                <p class="m-0" id="taskCreatedBy"></p>
                            </div>
                            <div class="task-created-at mb-1 gap-1 d-flex">
                                <p class="m-0">Created At : </p>
                                <p class="m-0" id="taskCreatedAt"></p>
                            </div>

                            <div class="task-deadline mb-1 gap-1 d-flex">
                                <p class="m-0">Deadline : </p>
                                <p class="m-0" id="taskDeadline"></p>
                            </div>



                        </div>
                        <div class="task-body ">
                            <div class="task-description">
                                <h3 class="py-3 border-bottom">Description</h3>
                                <div class="mt-3" id="taskDescription">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



@endsection



@section('js_footer')
<script src="https://cdn.datatables.net/2.1.3/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.1.3/js/dataTables.bootstrap5.min.js"></script><script>
    $(document).ready(function() {
        $('#tasksTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "pageLength": 10,    // Default number of rows per page
            "columnDefs": [
                { "orderable": false, "targets": 7 }  // Disable sorting on the 'Actions' column
            ]
        });
    });
</script>
    <script>
        // function drawerr(){
        //     $('#right_drawer').modal('show'); // For Bootstrap
        // }
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

        function formatDate(dateString) {
            const date = new Date(dateString);
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            return `${day}-${month}-${year}`;
        }

        function fillShow(id) {
            $.ajax({
                url: `{{ route('tasks.show', '') }}/${id}`,
                type: 'get',
                success: function(data) {

                    $("#taskName").text(data.task.name || '');
                    $("#taskTitle").text(data.task.name || '');
                    $("#projectName").text(data.task.project.name || '');
                    $("#taskStatus").text(data.task.status || '');
                    $("#taskPriority").text(data.task.priority || '');
                    $("#taskAssign").html(data.task.users.map(user => user.name).join(', ') || '');
                    $("#taskCreatedBy").text(data.task.created_by.name || '');
                    $("#taskCreatedAt").text(formatDate(data.task.created_at) || '');
                    $("#taskDeadline").text(formatDate(data.task.deadline) || '');
                    $("#taskDescription").html(data.task.description || ''); // Use .html() for HTML content
                }
            })
        }


        // function fillShow(id) {
        //     $.ajax({
        //         url: `{{ route('tasks.show', '') }}/${id}`,
        //         type: 'get',
        //         success: function(data) {

        //             $("#showTaskModal").modal('show');
        //             $('#nameShow').val(data.task.name || '');
        //             $('.descriptionShow').val(data.task.description || '');
        //             $('#priorityShow').val(data.task.priority || '');
        //             $('#statusShow').val(data.task.status || '');
        //             $('#projectShow').val(data.task.project_id || '');
        //             $('#deadlineShow').val(data.task.deadline || '');

        //             let userIds = data.task.user_ids || [];

        //             // // Clear previous selections

        //             // Set new selections
        //             $('#assignShow option').each(function() {
        //                 let optionValue = parseInt($(this).val());
        //                 if (userIds.includes(optionValue)) {
        //                     $(this).prop('selected', true);
        //                 }
        //             });
        //         },
        //         error: function(xhr, status, error) {
        //             console.error('Form submission error:', error, xhr.responseText);
        //         }
        //     });
        // }



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
                    $('#addForm')[0].reset();
                    $(".trumbowyg-editor").html(null);

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
                    url: "{{ route('tasks.destroy', ':id') }}".replace(':id', id),
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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
