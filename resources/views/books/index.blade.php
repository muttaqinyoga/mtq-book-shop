@extends('layouts.app')
@section('title') Books @endsection
@section('data-tables')
<link href="{{ asset('css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" media="all">
<link href="{{ asset('css/jquery.dataTables.min.css')}}" rel="stylesheet" media="all">
@endsection
@section('content')
<!-- MENU SIDEBAR-->
<aside class="menu-sidebar2">
    <div class="logo text-center">
        <h2 class="text-white text-center">Muttaqin Shop</h2>
    </div>
    <div class="menu-sidebar2__content js-scrollbar1">
        <div class="account2">
            <div class="image img-cir img-120">
                <img src="{{asset('images/admin.jpg')}}" alt="Admin" />
            </div>
            <h4 class="name">{{Auth::user()->name}}</h4>
            <a href="#!logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign out</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
        <nav class="navbar-sidebar2">
            <ul class="list-unstyled navbar__list">
                <li>
                    <a href="{{url('/')}}">
                        <i class="fas fa-tachometer-alt"></i>Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{url('/users')}}">
                        <i class="fas fa-tags"></i>Users</a>
                </li>
                <li>
                    <a href="{{url('/categories')}}">
                        <i class="fas fa-tags"></i>Categories</a>
                </li>
                <li class="active">
                    <a href="{{url('/books')}}">
                        <i class="fas fa-book"></i>Books</a>
                </li>
                <li>
                    <a href="{{url('/orders')}}">
                        <i class="fas fa-credit-card"></i>Orders</a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
<!-- END MENU SIDEBAR-->
<!-- PAGE CONTAINER-->
<div class="page-container2">
    <!-- HEADER DESKTOP-->
    <header class="header-desktop2">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="header-wrap2">
                    <div class="logo d-block d-lg-none text-center">
                        <h2 class="text-white text-center">Muttaqin Shop</h2>
                    </div>
                    <div class="header-button2 d-block d-lg-none">
                        <div class="header-button-item mr-0 js-sidebar-btn">
                            <i class="fas fa-bars"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <aside class="menu-sidebar2 js-right-sidebar d-block d-lg-none">
        <div class="logo text-center">
            <h2 class="text-white text-center">Muttaqin Shop</h2>
        </div>
        <div class="menu-sidebar2__content js-scrollbar2">
            <div class="account2">
                <div class="image img-cir img-120">
                    <img src="{{asset('images/admin.jpg')}}" alt="Admin" />
                </div>
                <h4 class="name">{{Auth::user()->name}}</h4>
                <a href="{{url('logout')}}">Sign out</a>
            </div>
            <nav class="navbar-sidebar2">
                <ul class="list-unstyled navbar__list">
                    <li>
                        <a href="{{url('/')}}">
                            <i class="fas fa-tachometer-alt"></i>Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{url('/users')}}">
                            <i class="fas fa-tags"></i>Users</a>
                    </li>
                    <li>
                        <a href="{{url('/categories')}}">
                            <i class="fas fa-tags"></i>Categories</a>
                    </li>
                    <li class="active">
                        <a href="{{url('/books')}}">
                            <i class="fas fa-book"></i>Books</a>
                    </li>
                    <li>
                        <a href="{{url('/orders')}}">
                            <i class="fas fa-credit-card"></i>Orders</a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
    <!-- END HEADER DESKTOP-->

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
                <a class="au-btn au-btn-icon au-btn--green au-btn--small" href="{{url('/book/create')}}">
                    Add New Book
                </a>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped" id="books-table">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No.</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Cover</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTAINER-->
</div>
<!-- Delete Menu Modal -->
<div class="modal fade" id="deleteBookModal" tabindex="-1" role="dialog" aria-labelledby="deleteBookModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="deleteBookModalLabel">Delete Book</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="deleteBookContent">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form action="{{url('book/delete')}}" method="post" style="display: inline;" id="deleteBookForm">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="delete_book_id" id="delete_book_id">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Delete Menu Modal -->
<!-- Details Book -->
<div class="modal fade" id="DetailBookModal" tabindex="-1" role="dialog" aria-labelledby="DetailBookModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-light" id="DetailBookModalLabel">Book Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End Details Book -->
@endsection
@section('data-tables2')
<script src="{{ asset('js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('js/dataTables.bootstrap4.min.js')}}"></script>

<script>
    $(document).ready(function() {
        $('#books-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('books/datatables') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'author',
                    name: 'author'
                },
                {
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
        $(document).on('click', '#btnDeleteBook', function() {
            const book_id = $(this).attr('book_id');
            const book_name = $(this).attr('book_name');
            $('#delete_book_id').attr('value', book_id);
            $('#deleteBookModal #deleteBookContent').html(`<p>Are you sure want to delete <strong>${book_name}</strong> from book list?</p>`);
        });
        $(document).on('click', '#btnDetailBook', function() {
            const book_title = $(this).attr('book_title');
            const book_author = $(this).attr('book_author');
            const book_categories = $(this).attr('book_categories');
            const book_price = $(this).attr('book_price');
            const book_cover = $(this).attr('book_cover');
            const book_publisher = $(this).attr('book_publisher');
            const book_stock = $(this).attr('book_stock');
            const book_description = $(this).attr('book_description');

            $('#DetailBookModal .modal-body').html(`<form>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Title</label>
                        <div class="col-md-9">
                            <input type="text" readonly class="form-control-plaintext"  value="${book_title}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Author</label>
                        <div class="col-md-9">
                            <input type="text" readonly class="form-control-plaintext"  value="${book_author}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Categories</label>
                        <div class="col-md-9">
                            <input type="text" readonly class="form-control-plaintext"  value="${book_categories}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">price</label>
                        <div class="col-md-9">
                            <input type="text" readonly class="form-control-plaintext"  value="${formatRupiah(book_price, 'Rp')}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Publisher</label>
                        <div class="col-md-9">
                            <input type="text" readonly class="form-control-plaintext"  value="${book_publisher}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Stock</label>
                        <div class="col-md-9">
                            <input type="text" readonly class="form-control-plaintext"  value="${book_stock}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Description</label>
                        <div class="col-md-9">
                            <input type="text" readonly class="form-control-plaintext"  value="${book_description}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Cover</label>
                        <div class="col-md-9">
                            ${book_cover!='' ? `<img src="{{ asset('storage')}}/${book_cover}" width="300" />` : `` }
                        </div>
                    </div>
                </form>`)
        });
    });

    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
</script>
@endsection