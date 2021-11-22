@extends('layouts.app')
@section('title') Categories @endsection
@section('data-tables')
<link href="{{ asset('css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" media="all">
<link href="{{ asset('css/jquery.dataTables.min.css')}}" rel="stylesheet" media="all">
@endsection
@section('content')
<!-- BREADCRUMB-->
<section class="au-breadcrumb m-t-75 bg-dark">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="title-5 m-b-35 text-white">Categories</h3>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END BREADCRUMB-->
<div class="section__content section__content--p30">
    <div class="container-fluid">
        @if($message = Session::get('message'))
        <div class="row mt-3">
            <div class="sufee-alert alert with-close alert-info alert-dismissible fade show">
                <span class="badge badge-pill badge-success">Success</span>
                {{ $message }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        </div>
        @endif
        <div class="row mt-3 mb-3">
            <a class="au-btn au-btn-icon au-btn--green au-btn--small" href="{{url('/categories/create')}}">
                Add Category
            </a>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped" id="categories-table">
                        <thead class="thead-dark">
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Delete Menu Modal -->
<div class="modal fade" id="deleteCategoryModal" tabindex="-1" role="dialog" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="deleteCategoryModalLabel">Delete Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="deleteCategoryContent">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form method="post" style="display: inline;" id="deleteCategoryForm">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Delete Menu Modal -->
@endsection
@section('data-tables2')
<script src="{{ asset('js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('js/dataTables.bootstrap4.min.js')}}"></script>

<script>
    $(document).ready(function() {
        $('#categories-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('categories/datatables') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                }, {
                    data: 'name',
                    name: 'name'
                }, {
                    data: 'image',
                    name: 'image',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    searchable: false,
                    orderable: false
                }
            ]
        });
        $(document).on('click', '#btnDeleteCategory', function() {
            const category_id = $(this).attr('category_id');
            const category_name = $(this).attr('category_name');
            const url = `{{ url('categories/delete') }}/${category_id}`;
            $('#deleteCategoryModal #deleteCategoryContent').html(`<p>Are you sure want to delete <strong>${category_name}</strong> from category list?</p>`);
            $('#deleteCategoryForm').attr('action', url);
        });
    });
</script>
@endsection