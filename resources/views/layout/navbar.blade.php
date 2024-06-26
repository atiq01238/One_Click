<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Search -->
    <form action="{{ route('search', ['route' => Route::currentRouteName()]) }}" method="GET">
        <div class="input-group">
            <input type="text" name="query" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                            aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <!-- Nav Item - Alerts -->
        <!-- Inside the navbar -->
       <!-- Nav Item - Alerts -->
    <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" id="notificationsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell fa-fw"></i>
            <!-- Counter - Notifications -->
            <span class="badge badge-danger badge-counter">{{ auth()->user()->unreadNotifications->count() }}</span>
        </a>
        <!-- Dropdown - Notifications -->
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="notificationsDropdown">
            <h6 class="dropdown-header">Notifications</h6>
            @forelse(auth()->user()->unreadNotifications as $notification)
                @php
                    $route = '';
                    $id = null;
                    $iconClass = 'fa-file-alt';
                    $type = $notification->type;

                    if ($type === 'App\Notifications\TaskAssignedNotification') {
                        $route = 'tasks.show';
                        $id = $notification->data['task_id'];
                    } elseif ($type === 'App\Notifications\TaskUpdatedNotification') {
                        $route = 'tasks.show';
                        $id = $notification->data['task_id'];
                    } elseif ($type === 'App\Notifications\ReportedTaskNotification') {
                        // $route = 'report.index';
                        $id = $notification->data['reported_task_id'];
                        $iconClass = 'fa-flag';
                    } elseif ($type === 'App\Notifications\ProjectAssignedNotification') {
                        $route = 'projects.show';
                        $id = $notification->data['project_id'];
                    }
                @endphp

                @if ($type === 'App\Notifications\ReportedTaskNotification')
                    <a class="dropdown-item d-flex align-items-center" href=" {{-- {{ url('tasks', ['id' => $task->id]) }} --}}">
                        <div class="mr-3">
                            <div class="icon-circle bg-primary">
                                <i class="fas {{ $iconClass }} text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500">{{ $notification->created_at->diffForHumans() }}</div>
                            <span class="font-weight-bold">{{ $notification->data['message'] }}</span>
                        </div>
                    </a>
                @elseif ($route && $id)
                    <a class="dropdown-item d-flex align-items-center" href="{{ route($route, $id) }}">
                        <div class="mr-3">
                            <div class="icon-circle bg-primary">
                                <i class="fas {{ $iconClass }} text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500">{{ $notification->created_at->diffForHumans() }}</div>
                            <span class="font-weight-bold">{{ $notification->data['message'] }}</span>
                        </div>
                    </a>
                @endif
            @empty
                <a class="dropdown-item d-flex align-items-center">
                    <div class="mr-3">
                        <div class="icon-circle bg-secondary">
                            <i class="fas fa-bell text-white"></i>
                        </div>
                    </div>
                    <div>
                        <span class="font-weight-bold">No notifications</span>
                    </div>
                </a>
            @endforelse

            <a class="dropdown-item text-center small text-gray-500" href="{{ route('notifications.markAllAsRead') }}">Mark all as read</a>
        </div>
    </li>



        <!-- Nav Item - Messages -->
        {{-- <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                <span class="badge badge-danger badge-counter">{{ auth()->user()->unreadNotifications()->count() }}</span>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                    Message Center
                </h6>
                @foreach(auth()->user()->unreadNotifications as $notification)
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <!-- Display your notification content here -->
                    <div class="dropdown-list-image mr-3">
                        <!-- Display your notification image/avatar here -->
                        <img class="rounded-circle" src="{{ $notification->data['image'] }}" alt="...">
                    </div>
                    <div class="font-weight-bold">
                        <!-- Display your notification message content here -->
                        <div class="text-truncate">{{ $notification->data['message'] }}</div>
                        <!-- Display your notification timestamp or additional information here -->
                        <div class="small text-gray-500">{{ $notification->created_at->diffForHumans() }}</div>
                    </div>
                </a>
                @endforeach
                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
            </div>
        </li> --}}


        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @if (Auth::check())
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->first_name }}
                        {{ Auth::user()->last_name }}</span>
                @else
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">Guest</span>
                @endif
                <img class="img-profile rounded-circle" src="{{ asset('profile_imgs/' . $image) }}">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ url('profiles') }}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Settings
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                    Activity Log
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <form action="{{ url('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                </a>
            </div>
        </li>

    </ul>

</nav>
