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
    @can('User Management')
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
    @endcan


    <!-- Nav Item - Permissions and Access Control -->
    @can('Permissions and Access Control')
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
    @endcan

    <!-- Nav Item - Project Manager -->
    @can('access project management')
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
    @endcan

    <!-- Nav Item - User Task -->

    @can('access task management')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTaskManagement" aria-expanded="false" aria-controls="collapseTaskManagement">
            <i class="fas fa-fw fa-cog"></i>
            <span>Task Management</span>
        </a>
        <div id="collapseTaskManagement" class="collapse" aria-labelledby="headingTaskManagement" data-bs-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <!-- Dropdown content goes here -->
                <a class="collapse-item" href="{{ url('tasks') }}"> All Task</a>
                <a class="collapse-item" href="{{ url('tasks/create') }}"> Create Task</a>
                <!-- Add more dropdown items as needed -->
            </div>
        </div>
    </li>
    @endcan

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTask" aria-expanded="false" aria-controls="collapseTask">
            <i class="fas fa-fw fa-tasks"></i> <!-- Assuming "fa-tasks" represents tasks -->
            <span>Tasks</span>
        </a>
        <div id="collapseTask" class="collapse" aria-labelledby="headingTask" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ url('usertasks') }}">All Tasks</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseApeal" aria-expanded="false" aria-controls="collapseApeal">
            <i class="fas fa-fw fa-tasks"></i> <!-- Assuming "fa-tasks" represents tasks -->
            <span>Report</span>
        </a>
        <div id="collapseApeal" class="collapse" aria-labelledby="headingApeal" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ url('reports') }}">All Report</a>
            </div>
        </div>
    </li>


    <!-- Sidebar Toggle Button -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
