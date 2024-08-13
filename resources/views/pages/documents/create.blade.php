@extends('layout.app')
@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card  my-3">
                    <div class="card-header color-dark fw-500">
                        <p>Add Document</p>
                    </div>
                    <div class="card-body">
                        <div class="col-8">
                            <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="col-lg-12">
                                    <div class="bg-white mb-25 rounded-xl">
                                        <label for="mail-reply-message3" class="form-label">Description</label>
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
                                <div class="mb-3">
                                    <label for="Project" class="form-label">Project (Optional)</label>
                                    <select name="project_id" id="Project" class="form-select">
                                        <option value="">Select Project</option>
                                        @foreach ($projects as $project)
                                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="files">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">File Description</label>
                                        <div class="file-info d-flex gap-5">
                                            <input type="text" class="form-control" id="name" name="file_description[]"
                                                value="{{ old('name') }}">
                                            <input type="file" id="file" name="files[]" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="add-file my-1">
                                    <button type="button" onclick="addFile()" class="btn btn-primary">Add File</button>
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
        function addFile() {
            $('#files').append(fileHtml());


        }

        function fileHtml(){


            return ` <div class="mb-3">
                                        <label for="name" class="form-label">File Description</label>
                                        <div class="file-info d-flex gap-5">
                                            <input type="text" class="form-control" id="name" name="file_description[]"
                                                value="{{ old('name') }}">
                                            <input type="file" id="file" name="files[]" class="form-control">
                                        </div>
                                    </div>`
        }
    </script>
@endsection
