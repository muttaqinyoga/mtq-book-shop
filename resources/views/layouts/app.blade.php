@php $arr = explode('/', url()->current()); @endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muttaqin Shop | @yield('title')</title>

    <!-- Bootstrap CSS-->
    <link href="{{ asset('vendor/bootstrap-4.1/bootstrap.min.css') }}" rel="stylesheet" media="all">
    <!-- Fontfaces CSS-->
    <link href="{{asset('css/font-face.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/font-awesome-5/css/fontawesome-all.min.css')}}" rel="stylesheet" media="all">
    <!-- Vendor CSS-->
    <link href="{{ asset('vendor/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="{{ asset('css/theme.css')}}" rel="stylesheet" media="all">
    @yield('data-tables')
</head>

<body>
    <div class="page-wrapper">
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
                        <li @if(url()->current() == 'http://127.0.0.1:8000' ) class="active" @endif>
                            <a href="{{url('/')}}">
                                <i class="fas fa-tachometer-alt"></i>Dashboard
                            </a>
                        </li>
                        <li @if(in_array('users', $arr) ) class="active" @endif>
                            <a href="{{url('/users')}}">
                                <i class="fas fa-users"></i>Users/Customers</a>
                        </li>
                        <li @if(in_array('categories', $arr)) class="active" @endif>
                            <a href="{{url('/categories')}}">
                                <i class="fas fa-tags"></i>Categories</a>
                        </li>
                        <li @if(in_array('books', $arr)) class="active" @endif>
                            <a href="{{url('/books')}}">
                                <i class="fas fa-book"></i>Books</a>
                        </li>
                        <li @if(in_array('orders', $arr)) class="active" @endif>
                            <a href="{{url('/orders')}}">
                                <i class="fas fa-credit-card"></i>Orders</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->
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
                            <li @if(url()->current() == 'http://127.0.0.1:8000' ) class="active" @endif>
                                <a href="{{url('/')}}">
                                    <i class="fas fa-tachometer-alt"></i>Dashboard
                                </a>
                            </li>
                            <li @if(in_array('users', $arr) ) class="active" @endif>
                                <a href="{{url('/users')}}">
                                    <i class="fas fa-users"></i>Users/Customers</a>
                            </li>
                            <li @if(in_array('categories', $arr)) class="active" @endif>
                                <a href="{{url('/categories')}}">
                                    <i class="fas fa-tags"></i>Categories</a>
                            </li>
                            <li @if(in_array('books', $arr)) class="active" @endif>
                                <a href="{{url('/books')}}">
                                    <i class="fas fa-book"></i>Books</a>
                            </li>
                            <li @if(in_array('orders', $arr)) class="active" @endif>
                                <a href="{{url('/orders')}}">
                                    <i class="fas fa-credit-card"></i>Orders</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </aside>
            <!-- END HEADER DESKTOP-->
            @yield('content')
        </div>
    </div>

    <!-- Jquery JS-->
    <script src="{{ asset('vendor/jquery-3.2.1.min.js') }}"></script>
    <!-- Bootstrap JS-->
    <script src="{{ asset('vendor/bootstrap-4.1/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>
    <!-- Vendor JS       -->
    <script src="{{ asset('vendor/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    </script>

    <!-- Main JS-->
    <script src="{{ asset('js/main.js') }}"></script>
    @yield('data-tables2')
</body>

</html>