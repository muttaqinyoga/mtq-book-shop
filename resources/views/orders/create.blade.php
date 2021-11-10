@extends('layouts.app')
@section('title') Create New Order @endsection
@section('data-tables')
<link rel="stylesheet" href="{{ asset('css/bootstrap-select.min.css') }}">
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
                <li>
                    <a href="{{url('/books')}}">
                        <i class="fas fa-book"></i>Books</a>
                </li>
                <li class="active">
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
                    <li>
                        <a href="{{url('/books')}}">
                            <i class="fas fa-book"></i>Books</a>
                    </li>
                    <li class="active">
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
                        <h3 class="title-5 m-b-35 text-white">Order</h3>
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
                                <h3 class="text-center title-2">Create New Order</h3>
                            </div>
                            @if($failed = Session::get('failed'))
                            <div class="form-group">
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Failed</span>
                                    {{ $failed }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                            </div>
                            @endif
                            @if($errors->has('_nOrder'))
                            <div class="form-group">
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Error</span>
                                    Unknown error occured!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                            </div>
                            @endif
                            <hr>
                            <form action="{{ url('order/save') }}" id="orderForm" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="buyer" class="control-label mb-1">Buyer</label>
                                    <input id="buyer" name="buyer" type="text" class="form-control {{ $errors->has('buyer') ? ' is-invalid' : '' }}" value="{{ old('buyer') }}">
                                    @if ($errors->has('buyer'))
                                    <small class="help-block form-text text-danger">{{ $errors->first('buyer') }}</small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="address" class="control-label mb-1">Address</label>
                                    <input id="address" name="address" type="text" class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" value="{{ old('address') }}">
                                    @if ($errors->has('address'))
                                    <small class="help-block form-text text-danger">{{ $errors->first('address') }}</small>
                                    @endif
                                </div>
                                <div id="item">
                                    <div class="form-group">
                                        <label for="book">Item</label>
                                        <select name="book" id="book" class="form-control selectpicker {{ $errors->has('book') ? ' is-invalid' : '' }}" data-live-search="true">
                                            <option value="" selected>--Choose items--</option>
                                            @foreach($books as $b)
                                            <option value="{{$b->id}}">{{$b->title}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('book'))
                                        <small class="help-block form-text text-danger">{{ $errors->first('book') }}</small>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="quantity" class="control-label mb-1">Quantity</label>
                                        <input id="quantity" name="quantity" type="number" min="0" class="form-control {{ $errors->has('quantity') ? ' is-invalid' : '' }}" value="{{ old('quantity') }}">
                                        @if ($errors->has('quantity'))
                                        <small class="help-block form-text text-danger">{{ $errors->first('quantity') }}</small>
                                        @endif
                                    </div>
                                    <input type="hidden" name="_nOrder" id="_nOrder" value="1">
                                </div>
                                <div class="form-group">
                                    <button type="button" id="addNewItem" class="btn btn-sm btn-dark">add</button>
                                </div>
                                <div class="form-group">
                                    <button type="submit" id="submitOrderBtn" class="btn btn-lg btn-success btn-block">
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
<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#book').selectpicker();
        let i = 1;
        $(document).on('click', '#addNewItem', function() {
            $('#item').append(`<div class="form-group item${i}">
                                <label for="book${i}">Item</label>
                                <select name="book${i}" id="book${i}" class="form-control selectpicker {{ $errors->has('book${i}') ? ' is-invalid' : '' }}" data-live-search="true">
                                    <option value="" selected>--Choose items--</option>
                                    @foreach($books as $b)
                                    <option value="{{$b->id}}">{{$b->title}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('book${i}'))
                                <small class="help-block form-text text-danger">{{ $errors->first('book${i}') }}</small>
                                @endif
                            </div>
                            <div class="form-group item${i}">
                                <label for="quantity${i}" class="control-label mb-1">Quantity</label>
                                <input id="quantity${i}" name="quantity${i}" type="number" min="0" class="form-control {{ $errors->has('${i}') ? ' is-invalid' : '' }}" value="{{ old('${i}') }}">
                                @if ($errors->has('${i}'))
                                <small class="help-block form-text text-danger">{{ $errors->first('${i}') }}</small>
                                @endif
                            </div>
                            <div class="form-group item${i}">
                                <button item="${i}" type="button" i class="btn btn-sm btn-danger remove">remove</button>
                            </div>
                        `);
            $(`#book${i}`).selectpicker();
            i++;
            $('#_nOrder').val(i);
        });
        $(document).on('click', `.remove`, function() {
            const item = $(this).attr('item');
            $(`.item${item}`).remove();
        });
        $('#orderForm').on('submit', function() {
            $('form #submitOrderBtn').attr('disabled', true);
            $('form #submitOrderBtn').text('Create...');
        });
    });
</script>
@endsection