@extends('layout.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-main">
                    <div class="breadcrumb-action justify-content-center flex-wrap">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                            Add Documents
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header color-dark fw-500">
                        <p>All Documents</p>
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
                                                <span class="userDatatable-title">Project Name</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">Name</span>
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
                                                <td>{{ \Carbon\Carbon::parse($task->deadline)->format('d-m-Y') }}</td>
                                                <td>{{ $task->project->name ?? '' }}</td>
                                                <td>
                                                    @foreach ($task->users as $user)
                                                        <span class="p-1 bg-primary rounded text-white"
                                                            style="font-size: 12px">{{ $user->name }}</span>
                                                    @endforeach
                                                </td>

                                                <td class="d-flex  gap-2">
                                                    <button type="button" onclick="fillShow({{ $task->id }})"
                                                        class="btn btn-primary" data-toggle="modal"
                                                        data-target="#rightModal">
                                                        View
                                                    </button>

                                                    <a href="{{ route('tasks.edit', $task->id) }}"
                                                        class="btn btn-warning">Update Task</a>


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




@endsection



@section('js_footer')

@endsection
