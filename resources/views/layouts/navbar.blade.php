<nav class="navbar fixed-top">
    <div class="container-fluid">
        <span class="navbar-brand">{{ config('app.name') }}</span>
        <div class="ms-auto d-flex align-items-center">
            <div class="nav-options">
                <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                <a class="nav-link {{ request()->routeIs('student') ? 'active' : '' }}" href="{{ route('student') }}">Student</a>
                <a class="nav-link {{ request()->routeIs('teacher') ? 'active' : '' }}" href="{{ route('teacher') }}">Teacher</a>
                <a class="nav-link {{ request()->routeIs('admin') ? 'active' : '' }}" href="{{ route('admin') }}">Admin</a>
            </div>
            <button class="mobile-icon" id="navIcon">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>
    </div>
</nav>

<div id="sidePanel">
    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
    <a href="{{ route('student') }}" class="{{ request()->routeIs('student') ? 'active' : '' }}">Student</a>
    <a href="{{ route('teacher') }}" class="{{ request()->routeIs('teacher') ? 'active' : '' }}">Teacher</a>
    <a href="{{ route('admin') }}" class="{{ request()->routeIs('admin') ? 'active' : '' }}">Admin</a>
    <a href="{{ route('developer') }}" class="{{ request()->routeIs('developer') ? 'active' : '' }}">Developer Info</a>
</div>