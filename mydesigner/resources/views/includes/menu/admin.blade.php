<ul class="nav nav-pills flex-column">
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/dashboard') }}">
            <span class="menu-icon"><i class="fas fa-tachometer-alt"></i></span>
            <span class="menu-name">Dashboard</span>
        </a>
    </li>

    <li class="nav-item has-submenu">
        <a class="nav-link" data-toggle="collapse" href="#item-teams">
            <span class="menu-icon"><i class="fas fa-user-friends"></i></span>
            <span class="menu-name">Teams</span>
        </a>
        <div id="item-teams" class="collapse">
            <ul class="nav submenu flex-column ml-3">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.teams.index') }}">All Teams</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.teams.create') }}">Add New</a>
                </li>
            </ul>
        </div>
    </li>

    <li class="nav-item has-submenu">
        <a class="nav-link" data-toggle="collapse" href="#item-packages">
            <span class="menu-icon"><i class="fas fa-box"></i></span>
            <span class="menu-name">Packages</span>
        </a>
        <div id="item-packages" class="collapse">
            <ul class="nav submenu flex-column ml-3">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.packages.index') }}">All Packages</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.packages.create') }}">Add New</a>
                </li>
            </ul>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.designs.requests') }}">
            <span class="menu-icon"><i class="fas fa-paint-brush"></i></span>
            <span class="menu-name">Designs</span>
        </a>
    </li>
            
    <li class="nav-item has-submenu">
        <a class="nav-link" data-toggle="collapse" href="#item-users">
            <span class="menu-icon"><i class="fas fa-users"></i></span>
            <span class="menu-name">Users</span>
        </a>
        <div id="item-users" class="collapse">
            <ul class="nav submenu flex-column ml-3">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.users.index') }}">All Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.users.create') }}">Add New</a>
                </li>
            </ul>
        </div>
    </li>

</ul>