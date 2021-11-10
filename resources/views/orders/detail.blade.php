@extends('layouts.app')
@section('title') Detail Order @endsection
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
                        <i class="fas fa-users"></i>Users</a>
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
                    <li>
                        <a href="{{url('/')}}">
                            <i class="fas fa-tachometer-alt"></i>Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{url('/users')}}">
                            <i class="fas fa-users"></i>Users</a>
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
                        <h3 class="title-5 m-b-35 text-white">Orders</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END BREADCRUMB-->
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card mt-3">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Detail Order</h3>
                            </div>
                            <div class="card-content">
                                <form>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Invoice Number</label>
                                        <div class="col-md-9">
                                            <input type="text" readonly class="form-control-plaintext" value="{{$invoice_number}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Buyer</label>
                                        <div class="col-md-9">
                                            <input type="text" readonly class="form-control-plaintext" value="{{$customer_name}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Address</label>
                                        <div class="col-md-9">
                                            <input type="text" readonly class="form-control-plaintext" value="{{$address}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Time</label>
                                        <div class="col-md-9">
                                            <input type="text" readonly class="form-control-plaintext" value="{{$order_date}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Items</label>
                                        <div class="col-md-9">
                                            <ol>
                                                @foreach($order as $o)
                                                <li>{{$o->title}} ({{'Rp. ' . number_format($o->price, 0, ',', '.')}}) * ({{$o->quantity}}) pcs</li>
                                                @endforeach
                                            </ol>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Total</label>
                                        <div class="col-md-9">
                                            <input type="text" readonly class="form-control-plaintext" value="{{$total_price}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Status</label>
                                        <div class="col-md-9">
                                            <span class="badge 
                                            @if($status=='SUBMIT')
                                            bg-warning
                                            @elseif($status=='PROCESS')
                                            bg-info
                                            @elseif($status=='FINISH')
                                            bg-success
                                            @else
                                            bg-danger
                                            @endif
                                            {{ $status=='SUBMIT' ? 'text-dark' : 'text-light' }}">{{$status}}</span>
                                        </div>
                                </form>
                            </div>
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
<script>

</script>
@endsection