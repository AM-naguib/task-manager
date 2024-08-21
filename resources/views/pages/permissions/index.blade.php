@extends('layout.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-main">
                    <div class="breadcrumb-action justify-content-center flex-wrap">
                        <button onclick="insertForm('add')" id="btn-add" type="button" class="btn btn-primary"
                            data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            Add Permission
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-header color-dark fw-500">
                        <p>All Permissions</p>
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

                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse ($permissions as $permission)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $permission->name }}</td>
                                                <td class="d-flex  gap-2">
                                                    <button id="btn-edit"
                                                        onclick="insertForm('edit',{{ $permission->id }})" type="button"
                                                        class="border-0 bg-transparent text-info" data-bs-toggle="modal"
                                                        data-bs-target="#staticBackdrop">
                                                        <i class="fa-solid fa-pen-to-square m-0 fs-5"></i>
                                                    </button>
                                                    <button class="border-0 bg-transparent text-center text-danger"
                                                        onclick="deleteForm({{ $permission->id }})"><i
                                                            class="fa-solid fa-trash m-0 fs-5"></i></button>
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
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Permission</h1>
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
                    url: "{{ route('permissions.show', ':id') }}".replace(':id', id),
                    success: function(response) {
                        console.log(response);

                        $('#staticBackdrop .modal-body').html(editForm(response.permission));
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            }
        }

        function editForm(data) {
            return `
        <form action="{{route('permissions.update', ':id') }}" method="POST" id="addForm">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label required">Permission Name</label>
                            <input autocomplete="off" type="text" class="form-control" required id="name" name="name" value="${data.name}">
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
           <form action="{{ route('permissions.store') }}" method="POST" id="addForm">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-labelrequired">Permission Name</label>
                            <input autocomplete="off" type="text" required class="form-control" id="name" name="name">

                        </div>
                        <div class="mb-3">
                            <label for="crud" class="form-label">CRUD Permissions ? </label>
                            <input type="checkbox" class="form-check-input" id="crud" name="crud">
                            <span style="font-size: 12px">If Checked ,Create 4 CRUD Permissions</span>
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
                    $('#addForm')[0].reset();

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
                    $('#updateForm')[0].reset();

                },
                error: function(xhr) {
                    console.error('Form update error:', xhr.responseText);
                }
            });
        });

        function deleteForm(id) {
            if (confirm("Are you sure you want to delete this Permission?")) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('permissions.destroy', ':id') }}".replace(':id', id),
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

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
