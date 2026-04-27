<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="/admin" class="brand-link">
        <span class="brand-text font-weight-bold">Vehicle Maintenance</span>
    </a>

    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <a href="/admin" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
            </a>

            @if($user->can('view visitor report'))
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fa fa-th"></i>
                    <p>Visitor Report<i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="/admin/visitor-details" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>List view</p>
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if($user->can('view fuel'))
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fa fa-th"></i>
                    <p>Fuel<i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="/admin/fuel_list" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>List view</p>
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            <!-- Add more menu items with permission checks -->
        </ul>
    </nav>
</aside>
