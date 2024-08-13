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
                                                <span class="userDatatable-title">Name</span>
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($docs as $doc)
                                            <tr id="doc_{{$doc->id}}">

                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $doc->project->name  ?? "No Project"}}</td>

                                                <td class="d-flex  gap-2">
                                                    <button type="button" onclick="fillShow({{ $doc->id }})"
                                                        class="btn btn-primary" data-toggle="modal"
                                                        data-target="#rightModal">
                                                        View
                                                    </button>

                                                    <a href="{{ route('documents.edit', $doc->id) }}"
                                                        class="btn btn-warning">Update Document</a>


                                                    <button class="btn btn-danger"
                                                        onclick="deleteDoc({{ $doc->id }})">Delete</button>

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
<script>
      function deleteDoc(id) {
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
</script>
@endsection
