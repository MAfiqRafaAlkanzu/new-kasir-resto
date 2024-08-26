
<ul class="nav navbar-toolbar">
    <li class="dropdown dropdown-user">
        <a class="nav-link dropdown-toggle link" data-toggle="dropdown">
            <span>{{ Auth::user()->name }}</span>
        </a>
        <div class="dropdown-menu dropdown-arrow dropdown-menu-right admin-dropdown-menu">
            <div class="dropdown-arrow"></div>
            <div class="dropdown-header">
                <div>
                    <h5 class="font-strong text-white">{{ Auth::user()->name }}</h5>
                </div>
            </div>
            <div class="admin-menu-content">
                <div class="d-flex justify-content-between mt-2">
                    <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a class="d-flex align-items-center" href="{{ route('logout') }}" onclick="event.preventDefault();this.closest('form').submit();">Logout<i class="ti-shift-right ml-2 font-20"></i></a>
                    </form>
                </div>
            </div>
        </div>
    </li>
</ul>