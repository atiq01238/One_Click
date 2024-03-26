<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}" role="button">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">
            @if(auth()->check())
                @foreach(auth()->user()->roles as $role)
                    <span class="badge badge-primary">{{ $role->name }}</span>
                @endforeach
            @endif
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ url('/') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <!-- Nav Item - User Management -->
    {{-- @if(auth()->check() && auth()->user()->hasRole('Super-Admin')) --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse"
            data-target="#collapseEmployeesUserManagement" aria-expanded="false"
            aria-controls="collapseEmployeesUserManagement">
            <i class="fas fa-fw fa-cog"></i>
            <span>User Management</span>
        </a>
        <div id="collapseEmployeesUserManagement" class="collapse" aria-labelledby="headingEmployeesUserManagement"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header"></h6>
                <a class="collapse-item" href="{{ url('users') }}">Users</a>
                <a class="collapse-item" href="{{ url('admins') }}">Admins</a>
            </div>
        </div>
    </li>
    {{-- @endif --}}

    <!-- Nav Item - Permissions and Access Control -->
    {{-- @if(auth()->check() && (auth()->user()->hasRole('Super-Admin') )) --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePermissions"
            aria-expanded="false" aria-controls="collapsePermissions">
            <i class="fas fa-fw fa-cog"></i>
            <span>Permissions and Access Control</span>
        </a>
        <div id="collapsePermissions" class="collapse" aria-labelledby="headingPermissions"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header"></h6>
                <a class="collapse-item" href="{{ url('roles') }}">Roles</a>
                <a class="collapse-item" href="{{ url('permissions') }}">Permissions</a>
            </div>
        </div>
    </li>
    {{-- @endif --}}
    <!-- Nav Item - Project Manager -->
    {{-- @if(auth()->check() && (auth()->user()->hasRole('Super-Admin') || auth()->user()->hasRole('Project-Manager') )) --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProjectManagement"
            aria-expanded="false" aria-controls="collapseProjectManagement">
            <i class="fas fa-fw fa-cog"></i>
            <span>Project Management</span>
        </a>
        <div id="collapseProjectManagement" class="collapse" aria-labelledby="headingProjectManagement"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header"></h6>
                <a class="collapse-item" href="{{ url('projects') }}">All Projects</a>
                <a class="collapse-item" href="{{ url('projects/create') }}">Create Project</a>
            </div>
        </div>
    </li>



    {{-- @endif --}}

    <!-- Nav Item - User Task -->
    {{-- @if(auth()->check() && auth()->user()->roles->isEmpty() || (auth()->user()->hasRole('Super-Admin') || auth()->user()->hasRole('Project-Manager') )) --}}
    {{-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUserTask"
            aria-expanded="false" aria-controls="collapseUserTask">
            <i class="fas fa-fw fa-cog"></i>
            <span>User Task</span>
        </a>
    </li> --}}
    {{-- @endif --}}

    <!-- Sidebar Toggle Button -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
