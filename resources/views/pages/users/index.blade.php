@extends('layout.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-main">
                    <div class="breadcrumb-action justify-content-center flex-wrap">
                        <button onclick="insertForm('add')" id="btn-add" type="button" class="btn btn-primary"
                            data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            Add User
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-header color-dark fw-500">
                        <p>All Users</p>
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
                                                <span class="userDatatable-title">Username</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">Role</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">Action</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse ($users as $user)
                                            <tr>

                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $user->username }}</td>
                                                <td>
                                                    @forelse ($user->roles as $roles)
                                                        <span
                                                            class="p-1 bg-primary rounded text-white">{{ $roles->name }}</span>
                                                    @empty
                                                    @endforelse

                                                </td>

                                                <td class="d-flex  align-items-center gap-3">
                                                    <button id="btn-edit" onclick="insertForm('edit',{{ $user->id }})"
                                                        type="button" class="border-0 bg-transparent text-info" data-bs-toggle="modal"
                                                        data-bs-target="#staticBackdrop">
                                                        <i
                                                    class="fa-solid fa-pen-to-square m-0 fs-5"></i>
                                                    </button>
                                                    <button class="border-0 bg-transparent text-danger"
                                                        onclick="deleteForm({{ $user->id }})"><i
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


    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">User</h1>
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
                    url: "{{ route('users.show', ':id') }}".replace(':id', id),
                    success: function(response) {
                        console.log(response);

                        $('#staticBackdrop .modal-body').html(editForm(response));
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            }
        }

        function editForm(data) {
            let userRoles = data.roles


            return `
        <form action="{{ route('users.update', ':id') }}" method="POST" id="updateForm">
            @csrf
            @method('put')
               <div class="mb-3">
                            <label for="name" class="form-label required">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="${data.user.name}" required autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label required">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="${data.user.username}" required autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label required">email</label>
                            <input type="text" class="form-control" id="email" name="email" value="${data.user.email}" required autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label required">Password</label>
                            <input type="password" class="form-control" id="password" name="password" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="roles" class="form-label required">Roles</label>
                            <select name="roles[]" multiple id="roles" class="form-select" required>
                                @foreach ($roless as $role)
                        <option value="{{ $role->id }}" ${userRoles.includes('{{ $role->name }}') ? 'selected' : ''}>
                            {{ $role->name }}
                        </option>                                @endforeach
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
        </form>
    `.replace(':id', data.user.id);
        }

        function addForm() {
            return `
                                <form action="{{ route('users.store') }}" method="POST" id="addForm">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label required">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label required">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label required">email</label>
                            <input type="text" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label required">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="roles" class="form-label required">Roles</label>
                            <select name="roles[]" multiple id="roles" class="form-select" required>
                                @foreach ($roless as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
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
            if (confirm("Are you sure you want to delete this project?")) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('users.destroy', ':id') }}".replace(':id', id),
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
