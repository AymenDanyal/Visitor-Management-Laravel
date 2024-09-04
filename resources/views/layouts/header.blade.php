
        <nav class="bg-white mb-4 navbar navbar-expand navbar-light shadow static-top topbar">
            <button class="rounded-circle btn btn-link d-md-none mr-3" id="sidebarToggleTop">
                <i class="fa fa-bars"></i>
            </button>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" aria-expanded="false" data-toggle="dropdown"
                        aria-haspopup="true" id="userDropdown" role="button">
                        <span class="d-none d-lg-inline mr-2 small text-gray-600">Admin</span>
                        <img class="rounded-circle img-profile" src="{{asset('/logo/undraw_profile.svg')}}">
                    </a>
                    <div class="shadow animated--grow-in dropdown-menu dropdown-menu-right"
                        aria-labelledby="userDropdown">
                        <form id="logout-form" action="/logout" method="POST" >
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-fw fa-sign-out-alt fa-sm mr-2 text-gray-400"></i> Logout
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
   


    <style>
        .bgside {
            background-color: #ecedf1;
        }

        .sidebar-dark .nav-item .nav-link {
            color: #000;
        }

        .sidebar-dark .nav-item .nav-link i {
            color: #000;
        }

        .sidebar-dark .nav-item .nav-link:active,
        .sidebar-dark .nav-item .nav-link:focus,
        .sidebar-dark .nav-item .nav-link:hover {
            color: #ba0404;
        }

        .sidebar-dark .nav-item .nav-link:active i,
        .sidebar-dark .nav-item .nav-link:focus i,
        .sidebar-dark .nav-item .nav-link:hover i {
            color: #ba0404;
        }

        .sidebar-dark .nav-item .nav-link[data-toggle=collapse]::after {
            color: #000;
        }
    </style>