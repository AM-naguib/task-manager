@extends('layout.app')
@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card  my-3">
                    <div class="card-header color-dark fw-500">
                        <p>Update Tasks</p>
                    </div>
                    <div class="card-body">
                        <div class="col-8">
                            <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="name" class="form-label">Task Name</label>
                                    <input autocomplete="off" type="text" class="form-control" id="name" name="name"
                                        value="{{ $task->name }}">
                                </div>

                                <div class="mb-3">
                                    <label for="priority" class="form-label">Task Priority</label>
                                    <select name="priority" id="priority" class="form-select">
                                        <option {{ $task->priority == 'Low' ? 'selected' : '' }} value="Low">Low</option>
                                        <option {{ $task->priority == 'Medium' ? 'selected' : '' }} value="Medium">Medium
                                        </option>
                                        <option {{ $task->priority == 'High' ? 'selected' : '' }} value="High">High
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Task Status</label>
                                    <select name="status" id="status" class="form-select">
                                        <option {{ $task->status == 'Not Started' ? 'selected' : '' }} value="Not Started">Not Started</option>
                                        <option {{ $task->status == 'Assigned' ? 'selected' : '' }} value="Assigned">Assigned</option>
                                        <option {{ $task->status == 'In Progress' ? 'selected' : '' }} value="In Progress">In Progress</option>
                                        <option {{ $task->status == 'Ready For Test' ? 'selected' : '' }} value="Ready For Test">Ready For Test</option>
                                        <option {{ $task->status == 'Done' ? 'selected' : '' }} value="Done">Done</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="project" class="form-label">Project</label>
                                    <select name="project_id" id="project" class="form-select">
                                        <option value="">Select Project</option>
                                        @foreach ($projects as $project)
                                            <option @selected($project->id == $task->project_id) value="{{ $project->id }}">
                                                {{ $project->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="assign" class="form-label">Assign To</label>
                                    <select name="users[]" id="assign" class="form-select" multiple>
                                        @foreach ($users as $user)
                                            <option @selected(in_array($user->id, $task->users->pluck('id')->toArray())) value="{{ $user->id }}">
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="deadline" class="form-label">Task Deadline</label>
                                    <input autocomplete="off" type="text" id="datepicker" name="deadline" class="form-control"
                                        placeholder="Select a date" value="{{ $task->deadline }}">
                                </div>
                                <div class="col-lg-12">
                                    <div class="bg-white mb-25 rounded-xl">
                                        <div class="reply-form pt-0">
                                            <div class="mailCompose-form-content">
                                                <div class="form-group">
                                                    <textarea name="description" id="mail-reply-message3" class="form-control-lg description"
                                                        placeholder="Type your message...">{{ $task->description }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>







@endsection



@section('js_footer')
    <script>



    </script>
@endsection
