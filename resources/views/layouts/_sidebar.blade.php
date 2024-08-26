<nav class="page-sidebar" id="sidebar">
    <div id="sidebar-collapse">
        <ul class="side-menu metismenu">
            <li class="">
                <a href="{{ route('dashboard') }}"><i class="sidebar-item-icon ti-home"></i>
                    <span class="nav-label">Dashboard </span>
                </a>
            </li>
            @if (Auth::user()->roles == 'manager')
                <li class="heading">Manager</li>
                <li>
                    <a href="{{ route('transaction.list') }}"><i class="sidebar-item-icon ti-money"></i>
                        <span class="nav-label"> Transaction </span></a>
                </li>
            @elseif (Auth::user()->roles == 'admin')
                <li class="heading">Admin</li>
                <li>
                    <a href="{{ route('menu.list') }}"><i class="sidebar-item-icon ti-shopping-cart"></i><span class="nav-label"> Menu</span></a>
                </li>
                <li>
                    <a href="{{ route('user.list') }}"><i class="sidebar-item-icon ti-user"></i><span class="nav-label"> User</span> </a>
                </li>
                <li>
                    <a href="{{ route('seat.list') }}"><i class="sidebar-item-icon ti-tablet"></i><span class="nav-label"> Seat</span></a>
                </li>
            @elseif (Auth::user()->roles == 'cashier')
                <li class="heading">Cashier</li>
                <li>
                    <a href="{{ route('cashier') }}"><i class="sidebar-item-icon ti-money"></i>
                        <span class="nav-label"> Transaction </span></a>
                </li>
            @endif
            
        </ul>
    </div>
</nav>