{{--             <a href="{{route('dashboard')}}" class="brand-link">--}}
{{--                <img src="{{asset('public/logo.png')}}" alt="Smart Campus" class="brand-image center">--}}
{{--                <p class="brand-text text-white">Smart Campus</p>--}}
{{--            </a>--}}

<div class="sidebar-brand"
     style="background: #ffffff;border-width: 0px 2px 0px 0px;padding-bottom: 9px;border-style: solid;border-color: #F58823;">
    <a href="{{route('dashboard')}}" class="text-center">
        <img src="{{asset('public/logo.png')}}" alt="O Gas" class="nav-logo">
{{--                <h5 class="mt-3 brand-text" style="color: #ffffff;">admin</h5>--}}
    </a>
</div>
<div class="sidebar campus-sidebar">
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
            data-accordion="false">
            <li class="nav-item">
                <a href="{{route('dashboard')}}" class="nav-link {{ Request::is('dashboard')? 'active1':''}}">
                    <i class="fa-solid fa-gauge nav-icon"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('customer')}}" class="nav-link {{ Request::is('customer*')? 'active1':''}}">
                    <i class="fa-solid fa-user-group nav-icon"></i>
                    <p>Customers</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('category.index')}}" class="nav-link {{ Request::is('category*')? 'active1':''}}">
                    <i class="fa-solid fa-list nav-icon"></i>
                    <p>Category</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('products')}}" class="nav-link {{ Request::is('products*')? 'active1':''}}">
                    <i class="fas fa-gas-pump nav-icon"></i>
                    <p>Products</p>
                </a>
            </li>
        </ul>
    </nav>
</div>
