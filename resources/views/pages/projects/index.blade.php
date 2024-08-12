@extends('layout.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-main">
                    <div class="breadcrumb-action justify-content-center flex-wrap">
                        <button onclick="insertForm('add')" id="btn-add" type="button" class="btn btn-primary"
                            data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            Add Porject
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-header color-dark fw-500">
                        <p>All Projects</p>
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
                                                <span class="userDatatable-title">Created By</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">Action</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse ($projects as $project)
                                            <tr>

                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $project->name }}</td>
                                                <td>{{ $project->status }}</td>
                                                <td>{{ $project->priority }}</td>
                                                <td>{{ $project->deadline }}</td>
                                                <td>{{ $project->createdBy->name }}</td>

                                                <td class="d-flex  gap-2">
                                                    <button id="btn-edit" onclick="insertForm('edit',{{ $project->id }})"
                                                        type="button" class="btn btn-info" data-bs-toggle="modal"
                                                        data-bs-target="#staticBackdrop">
                                                        Edit
                                                    </button>
                                                    <button class="btn btn-danger"
                                                        onclick="deleteForm({{ $project->id }})">Delete</button>
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


    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Project</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                </div>

            </div>
        </div>
    </div>
@endsection



@section('js_footer')
    <script>
        function insertForm(type, id = null) {
            if (type === 'add') {
                $('#staticBackdrop .modal-body').html(addForm());
            } else if (type === 'edit' && id != null) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('projects.show', ':id') }}".replace(':id', id),
                    success: function(response) {
                        $('#staticBackdrop .modal-body').html(editForm(response.project));
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            }
        }

        function editForm(data) {
            return `
        <form action="{{ route('projects.update', ':id') }}" method="POST" id="updateForm">
            @csrf
            @method('put')
            <div class="mb-3">
                <label for="name" class="form-label">Project Name</label>
                <input type="text" class="form-control" id="name" name="name" value="${data.name}">
            </div>
            <div class="mb-3">
                <label for="summary" class="form-label">Project Summary</label>
                <textarea name="summary" id="summary" class="form-control">${data.summary}</textarea>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Project Description</label>
                <textarea name="description" class="form-control" id="description">${data.description}</textarea>
            </div>
            <div class="mb-3">
                <label for="priority" class="form-label">Project Priority</label>
                <select name="priority" id="priority" class="form-select">
                    <option value="Low" ${data.priority === 'Low' ? 'selected' : ''}>Low</option>
                    <option value="Medium" ${data.priority === 'Medium' ? 'selected' : ''}>Medium</option>
                    <option value="High" ${data.priority === 'High' ? 'selected' : ''}>High</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Project Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="On Hold" ${data.status === 'On Hold' ? 'selected' : ''}>On Hold</option>
                    <option value="In Progress" ${data.status === 'In Progress' ? 'selected' : ''}>In Progress</option>
                    <option value="Completed" ${data.status === 'Completed' ? 'selected' : ''}>Completed</option>
                    <option value="Cancelled" ${data.status === 'Cancelled' ? 'selected' : ''}>Cancelled</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="deadline" class="form-label">Project Deadline</label>
                <input type="text" id="datepicker" class="form-control" placeholder="Select a date" name="deadline" value="${data.deadline}">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    `.replace(':id', data.id);
        }

        function addForm() {
            return `
            <form action="{{ route('projects.store') }}" method="POST" id="addForm">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Project Name</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
                <div class="mb-3">
                    <label for="summary" class="form-label">Project Summary</label>
                    <textarea name="summary" id="summary" class="form-control"></textarea>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Project Description</label>
                    <textarea name="description" class="form-control" id="description"></textarea>
                </div>
                <div class="mb-3">
                    <label for="priority" class="form-label">Project Priority</label>
                    <select name="priority" id="priority" class="form-select">
                        <option value="Low">Low</option>
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
                    </select>
                </div>
                 <div class="mb-3">
                <label for="status" class="form-label">Project Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="On Hold" ${data.status === 'On Hold' ? 'selected' : ''}>On Hold</option>
                    <option value="In Progress" ${data.status === 'In Progress' ? 'selected' : ''}>In Progress</option>
                    <option value="Completed" ${data.status === 'Completed' ? 'selected' : ''}>Completed</option>
                    <option value="Cancelled" ${data.status === 'Cancelled' ? 'selected' : ''}>Cancelled</option>
                </select>
                </div>
                <div class="mb-3">
                    <label for="deadline" class="form-label">Project Deadline</label>
                    <input type="text" id="datepicker" name="deadline" class="form-control" placeholder="Select a date">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        `;
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
                    $('#staticBackdrop').modal('hide');
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
                    console.log('Form updated successfully:', response);
                    $('#staticBackdrop').modal('hide');
                    $("table").load(location.href + " table ");

                },
                error: function(xhr) {
                    console.error('Form update error:', xhr.responseText);
                }
            });
        });

        function deleteForm(id) {
            if (confirm("Are you sure you want to delete this project?")) {
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
    </script>
@endsection
