@extends('layouts.app')
@section('title') Home @endsection
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
                    <li>
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
    <section class="au-breadcrumb m-t-75">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="au-breadcrumb-content">
                            <div class="au-breadcrumb-left">
                                <ul class="list-unstyled list-inline au-breadcrumb__list">
                                    <li class="list-inline-item active">
                                        <a href="#">/</a>
                                    </li>
                                    <li class="list-inline-item">Home</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END BREADCRUMB-->

    <!-- STATISTIC-->
    <section class="statistic">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 col-lg-3">
                        <div class="statistic__item">
                            <h2 class="number">105</h2>
                            <span class="desc">user</span>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="statistic__item">
                            <h2 class="number">388</h2>
                            <span class="desc">items sold</span>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="statistic__item">
                            <h2 class="number">22</h2>
                            <span class="desc">this week</span>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="statistic__item">
                            <h2 class="number">Rp 25.000,00</h2>
                            <span class="desc">total earnings</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END STATISTIC-->
    <!-- END PAGE CONTAINER-->
</div>
@endsection