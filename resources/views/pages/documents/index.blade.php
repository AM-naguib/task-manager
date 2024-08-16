@extends('layout.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-main">
                    <div class="breadcrumb-action justify-content-center flex-wrap">
                        <a href="{{ route('documents.create') }}" class="btn btn-primary btn--raised"> Add Documents</a>


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
                                                <span class="userDatatable-title">Action</span>
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($docs as $doc)
                                            @if ($doc)
                                                <tr id="doc_{{ $doc->id }}">

                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $doc->project->name ?? 'No Project' }}</td>

                                                    <td class="d-flex align-items-center gap-3">
                                                        <button type="button" onclick="fillShow({{ $doc->id }})"
                                                            class="border-0 bg-transparent text-primary" data-toggle="modal"
                                                            data-target="#rightModal">
                                                            <i class="fa-solid fa-eye m-0 fs-5"></i>

                                                        </button>

                                                        <a href="{{ route('documents.edit', $doc->id) }}"
                                                            class="border-0 bg-transparent text-warning"><i
                                                                class="fa-solid fa-pen-to-square m-0 fs-5"></i></a>


                                                        <button class="border-0 bg-transparent text-danger"
                                                            onclick="deleteDoc({{ $doc->id }})"><i
                                                                class="fa-solid fa-trash m-0 fs-5"></i></button>

                                                    </td>

                                                </tr>
                                            @endif
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
                    <h5 class="modal-title " id="projectTitle">Document</h5>
                    <button type="button" onclick="$('#rightModal').modal('hide')" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="project">
                        <div class="project-head border-bottom">
                            <h3 class="py-2">Description</h3>
                        </div>
                        <div class="description-div" id="projectDescription">

                        </div>
                        <div class="project-body">
                            <div class="project-files">
                                <h3 class="py-3 border-bottom">Files</h3>
                                <div class="mt-3" id="projectFiles">


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="$('#rightModal').modal('hide')"
                        data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('js_footer')
    <script>
        function deleteDoc(id) {
            if (confirm("Are you sure you want to delete this document?")) {

                $.ajax({
                    url: `{{ route('documents.destroy', '') }}/${id}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        $("#doc_" + id).remove();

                    },
                    error: function(data) {
                        // Handle error here, e.g., display an error message
                        console.error('Error deleting file:', data);
                    }
                });
            }
        }


        function fillShow(id) {
            $.ajax({
                url: `{{ route('documents.show', '') }}/${id}`,
                type: 'get',
                success: function(data) {
                    $("#rightModal").modal("show");
                    $("#projectDescription").html(data.description || '');
                    $("#projectFiles").html(showFiles(data.documen_files) || '');
                }
            })
        }

        function showFiles(files) {

            let html = ``;
            files.forEach(item => {
                html += `                                    <div class="mb-20">
                                        <div class="files-area d-flex justify-content-between align-items-center" id="">
                                            <div class="files-area__left d-flex align-items-center">
                                                <div class="files-area__img">
                                                    <img src="{{ asset('file-icone.png') }}" alt="img" class="wh-42">
                                                </div>
                                                <div class="files-area__title">
                                                    <p class="mb-0 fs-14 fw-500 color-dark text-capitalize">${item.file_description}
                                                    </p>
                                                    <div class="d-flex text-capitalize">
                                                        <a target="_blank" href="storage/${item.file_url}" class="fs-12 fw-500 color-primary ">download</a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>`

            });
            return html

        }
    </script>
@endsection
