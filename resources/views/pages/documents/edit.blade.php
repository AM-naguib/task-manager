@extends('layout.app')
@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card  my-3">
                    <div class="card-header color-dark fw-500">
                        <p>Edit Document</p>
                    </div>
                    <div class="card-body d-flex justify-content-between">
                        <div class="col-8">
                            <form action="{{ route('documents.update', $document->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="col-lg-12">
                                    <div class="bg-white mb-25 rounded-xl">
                                        <label for="mail-reply-message3" class="form-label">Description</label>
                                        <div class="reply-form pt-0">
                                            <div class="mailCompose-form-content">
                                                <div class="form-group">
                                                    <textarea name="description" id="mail-reply-message3" class="form-control-lg description"
                                                        placeholder="Type your message...">{{ $document->description }}</textarea>
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
                                            <option @selected($project->id == $document->project_id) value="{{ $project->id }}">
                                                {{ $project->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="files">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">File Description</label>
                                        <div class="file-info d-flex gap-5">
                                            <input autocomplete="off" type="text" class="form-control" id="name"
                                                name="file_description[]" value="{{ old('name') }}">
                                            <input autocomplete="off" type="file" id="file" name="files[]" class="form-control">
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
                        <div class="col-3 card p-3" id="filesss">
                            <h3 class="py-3 border-bottom">Files</h3>
                            <div id="idfiles">

                                @foreach ($document->documenFiles as $file)
                                    <div class="mb-20 py-3 border-bottom " id="fi_{{ $file->id }}">
                                        <div class="files-area d-flex justify-content-between align-items-center"
                                            id="">
                                            <div
                                                class="files-area__left d-flex align-items-center justify-content-between w-100">
                                                <div class="all-file-dive d-flex align-items-center">
                                                    <div class="files-area__img">
                                                        <img src="http://45.33.34.15:8002/assets/img/zip@2x.png"
                                                            alt="img" class="wh-42">
                                                    </div>
                                                    <div class="files-area__title">
                                                        <p class="mb-0 fs-14 fw-500 color-dark text-capitalize">
                                                            {{ $file->file_description }}
                                                        </p>
                                                        <div class="d-flex text-capitalize">
                                                            <a target="_blank"
                                                                href="{{ env('APP_URL') }}/storage/{{ $file->file_url }}"
                                                                class="fs-12 fw-500 color-primary ">download</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="deleteIcon">
                                                    <span class=" text-danger" style="cursor: pointer"
                                                        onclick="deleteFile({{ $file->id }})"><i
                                                            class="fa-solid fa-trash"></i></span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                @endforeach
                            </div>
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

        function fileHtml() {


            return ` <div class="mb-3">
                                        <label for="name" class="form-label">File Description</label>
                                        <div class="file-info d-flex gap-5">
                                            <input autocomplete="off" type="text" class="form-control" id="name" name="file_description[]"
                                                value="{{ old('name') }}">
                                            <input autocomplete="off" type="file" id="file" name="files[]" class="form-control">
                                        </div>
                                    </div>`
        }



        function deleteFile(id) {
            $.ajax({
                url: `{{ route('documents.destroyFile', '') }}/${id}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    $("#fi_" + id).remove();

                },
                error: function(data) {
                    // Handle error here, e.g., display an error message
                    console.error('Error deleting file:', data);
                }
            });
        }
    </script>
@endsection
