@extends('layouts.app')
@section('title') Create Book @endsection
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
                    <li class="active">
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
                        <h3 class="title-5 m-b-35 text-white">Book</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END BREADCRUMB-->
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row mt-3 justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Create New Book</h3>
                            </div>
                            <hr>
                            <form action="{{ url('book/save') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="title" class="control-label mb-1">Book Title</label>
                                    <input id="title" name="title" type="text" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ old('title') }}">
                                    @if ($errors->has('title'))
                                    <small class="help-block form-text text-danger">{{ $errors->first('title') }}</small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="author" class="control-label mb-1">Book Author</label>
                                    <input id="author" name="author" type="text" class="form-control {{ $errors->has('author') ? ' is-invalid' : '' }}" value="{{ old('author') }}">
                                    @if ($errors->has('author'))
                                    <small class="help-block form-text text-danger">{{ $errors->first('author') }}</small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="category_id" class="control-label mb-1">Book Categories</label>
                                    <select name="category_id[]" multiple id="category_id" class="form-control">
                                    </select>
                                    @if ($errors->has('category_id'))
                                    <small class="help-block form-text text-danger">{{ $errors->first('category_id') }}</small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="image" class="control-label mb-1">Book Image</label>
                                    <input type="file" id="image" name="image" class="form-control {{ $errors->has('image') ? ' is-invalid' : '' }}">
                                    @if ($errors->has('image'))
                                    <small class="help-block form-text text-danger">{{ $errors->first('image') }}</small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="price" class="control-label mb-1">Book Price</label>
                                    <input id="price" name="price" type="number" min="0" class="form-control {{ $errors->has('price') ? ' is-invalid' : '' }}" value="{{ old('price') }}">
                                    @if ($errors->has('price'))
                                    <small class="help-block form-text text-danger">{{ $errors->first('price') }}</small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="stock" class="control-label mb-1">Book Stock</label>
                                    <input id="stock" name="stock" type="number" min="0" class="form-control {{ $errors->has('stock') ? ' is-invalid' : '' }}" value="{{ old('stock') }}">
                                    @if ($errors->has('stock'))
                                    <small class="help-block form-text text-danger">{{ $errors->first('stock') }}</small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="publisher" class="control-label mb-1">Book Publisher</label>
                                    <input id="publisher" name="publisher" type="text" class="form-control {{ $errors->has('publisher') ? ' is-invalid' : '' }}" value="{{ old('publisher') }}">
                                    @if ($errors->has('publisher'))
                                    <small class="help-block form-text text-danger">{{ $errors->first('publisher') }}</small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="description" class="control-label mb-1">Book description</label>
                                    <textarea id="description" rows="4" name="description" class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}">{{ old('description') }}</textarea>
                                    @if ($errors->has('description'))
                                    <small class="help-block form-text text-danger">{{ $errors->first('description') }}</small>
                                    @endif
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-lg btn-success btn-block">
                                        Create
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTAINER-->
</div>
@endsection
@section('data-tables2')
<link rel="stylesheet" href="{{ asset('vendor/bootstrap-select2.min.css') }}">
<script src="{{ asset('vendor/bootstrap-select2.min.js')}}"></script>

<script>
    $(document).ready(function() {
        $('#category_id').select2({
            ajax: {
                url: "{{ url('categories/ajax/search') }}",
                processResults: function(categories) {
                    return {
                        results: categories.map(function(c) {
                            return {
                                id: c.id,
                                text: c.name
                            }
                        })
                    }
                }
            }
        });
    });
</script>
@endsection