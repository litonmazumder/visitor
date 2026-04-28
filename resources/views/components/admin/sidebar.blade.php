<aside class="main-sidebar sidebar-dark-primary elevation-4">

<a href="#" class="brand-link">
    <span class="brand-text font-weight-bold">Operations</span>
</a>

<div class="sidebar">

    <div class="user-panel mt-3 pb-3 mb-3 text-white">
        Welcome back
    </div>

    @php
        $user = auth()->user();
        $role = $user->role ?? null;
    @endphp

    <nav>
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview">

            {{-- Dashboard --}}
            <li class="nav-item">
                <a href="{{ route('dashboard') }}"
                   class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-home"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            {{-- ================= HR ================= --}}
            @if(in_array($role, ['admin','staff']))
                <li class="nav-header">HUMAN RESOURCES</li>

                <li class="nav-item">
                    <a href="{{ route('employee.index') }}"
                       class="nav-link {{ request()->routeIs('employee.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-check"></i>
                        <p>Employee</p>
                    </a>
                </li>
            @endif


            {{-- ================= OPERATIONS ================= --}}
            @if(in_array($role, ['admin','staff']))
                <li class="nav-header">OPERATIONS</li>

                <li class="nav-item">
                    <a href="{{ route('visitor.index') }}"
                       class="nav-link {{ request()->routeIs('visitor.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-check"></i>
                        <p>Visitor</p>
                    </a>
                </li>
            @endif

        </ul>
    </nav>

</div>

</aside>