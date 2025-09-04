@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

<nav class="main-header navbar
    {{ config('adminlte.classes_topnav_nav', 'navbar-expand') }}
    {{ config('adminlte.classes_topnav', 'navbar-white navbar-light') }}">

    {{-- Navbar left links --}}
    <ul class="navbar-nav">
        {{-- Left sidebar toggler link --}}
        @include('adminlte::partials.navbar.menu-item-left-sidebar-toggler')

        {{-- Configured left links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-left'), 'item')

        {{-- Custom left links --}}
        @yield('content_top_nav_left')
    </ul>

    {{-- Navbar right links --}}
   {{-- Navbar right links --}}
<ul class="navbar-nav ml-auto order-1 order-md-3 navbar-no-expand">
    {{-- Custom right links --}}
    @yield('content_top_nav_right')

    {{-- Configured right links --}}
    @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-right'), 'item')

    {{-- Auth Links --}}
    @guest
         <li class="nav-item">
             <a href="{{ route('places.index') }}" class="nav-link">Home</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('login') }}" class="nav-link">Login</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('register') }}" class="nav-link">Register</a>
        </li>
    @endguest

    @auth
        @if(config('adminlte.usermenu_enabled'))
            @include('adminlte::partials.navbar.menu-item-dropdown-user-menu')
        @else
            @include('adminlte::partials.navbar.menu-item-logout-link')
        @endif
    @endauth

    {{-- Right sidebar toggler link --}}
    @if($layoutHelper->isRightSidebarEnabled())
        @include('adminlte::partials.navbar.menu-item-right-sidebar-toggler')
    @endif
</ul>


</nav>
