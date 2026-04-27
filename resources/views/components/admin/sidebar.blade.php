<aside class="main-sidebar sidebar-dark-primary elevation-4">

<a href="#" class="brand-link">
    <span class="brand-text font-weight-bold">SCBD PORTAL</span>
</a>

<div class="sidebar">

    <div class="user-panel mt-3 pb-3 mb-3 text-white">
        Welcome back
    </div>

    @php
        $user = auth()->user();

        $operationsPermissions = ['visitor.view'];
        $adminPermissions = ['role.view', 'user.view', 'permission.view'];
    @endphp

    <nav>
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview">

            {{-- Dashboard --}}
            <li class="nav-item">
                <a href="{{ route('dashboard') }}"
                   class="nav-link {{ request()->routeIs('admin.index') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-home"></i>
                    <p>Dashboard</p>
                </a>
            </li>

          {{-- HR --}}
            @canany($operationsPermissions)
                <li class="nav-header">HUMAN RESOURCES</li>

                @can('hr.view')
                <li class="nav-item">
                    <a href="{{ route('employee.index') }}"
                       class="nav-link {{ request()->is('portal/employee*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-check"></i>
                        <p>Employee</p>
                    </a>
                </li>
                @endcan

            @endcanany

            {{-- OPERATIONS --}}
            @canany($operationsPermissions)
                <li class="nav-header">OPERATIONS</li>

                @can('visitor.view')
                <li class="nav-item">
                    <a href="{{ url('/portal/visitor') }}"
                       class="nav-link {{ request()->is('portal/visitor*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-check"></i>
                        <p>Visitor</p>
                    </a>
                </li>
                @endcan

            @endcanany

            {{-- ADMIN --}}
            @canany($adminPermissions)
                <li class="nav-header">ADMINISTRATION</li>

                @can('role.view')
                <li class="nav-item">
                    <a href="{{ url('/portal/roles') }}"
                       class="nav-link {{ request()->is('portal/roles*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-tag"></i>
                        <p>Roles</p>
                    </a>
                </li>
                @endcan

                @can('user.view')
                <li class="nav-item">
                    <a href="{{ url('/portal/users') }}"
                       class="nav-link {{ request()->is('portal/users*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Users</p>
                    </a>
                </li>

                @endcan

                @can('permission.view')
                <li class="nav-item">
                    <a href="{{ url('/portal/permissions') }}"
                       class="nav-link {{ request()->is('portal/permissions*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-lock"></i>
                        <p>Permissions</p>
                    </a>
                </li>
                @endcan
            @endcanany

        </ul>
    </nav>

</div>

</aside>
