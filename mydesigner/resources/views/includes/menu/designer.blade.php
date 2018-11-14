<ul class="nav nav-pills flex-column">
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/dashboard') }}">
            <span class="menu-icon"><i class="fas fa-tachometer-alt"></i></span>
            <span class="menu-name">Dashboard</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('user.packages.list') }}">
            <span class="menu-icon"><i class="fas fa-box"></i></span>
            <span class="menu-name">Packages</span>
        </a>
    </li>

    <li class="nav-item has-submenu">
        <a class="nav-link" data-toggle="collapse" href="#item-designs">
            <span class="menu-icon"><i class="fas fa-paint-brush"></i></span>
            <span class="menu-name">Designs</span>
        </a>
        <div id="item-designs" class="collapse">
            <ul class="nav submenu flex-column ml-3">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.designs.requests') }}">All Designs</a>
                </li>
            </ul>
        </div>
    </li>

</ul>