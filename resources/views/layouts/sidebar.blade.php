<ul class="navbar-nav accordion bgside sidebar sidebar-dark" id="accordionSidebar">
    <a class="d-flex align-items-center justify-content-center sidebar-brand h-auto" href="/dashboard">
        <div class="sidebar-brand-icon">
            <img class="logo img-fluid d-block auto" src="{{asset('/logoW.webp')}}" alt="Visitor Log Logo" width="150px">
        </div>
    </a>
    @can('visitors_index')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" aria-expanded="true" data-toggle="collapse" aria-controls="collapseTwo"
            data-target="#visitor">
            <i class="fas fa-file-alt"></i> <span>Visitors</span>
        </a>
        <div class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar" id="visitor">
             <div class="bg-white collapse-inner py-2 rounded">
                <h6 class="collapse-header">Visitors</h6>
                <a class="collapse-item"  href="{{ route('visitors.index') }}">Visitors</a>
                @can('users_add')
                    <a class="collapse-item" href="{{ route('visitors.create') }}">Add Visitors</a>
                @endcan
            </div> 
        </div>
    </li>
    @endcan
    @can('departments_index')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" aria-expanded="true" data-toggle="collapse" aria-controls="collapseTwo"
            data-target="#departments">
            <i class="fas fa-boxes"></i> <span>Visit Options</span>
        </a>
        <div class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar" id="departments">
            <div class="bg-white collapse-inner py-2 rounded">
                <h6 class="collapse-header">Departments</h6>
                <a class="collapse-item" href="{{ route('departments.index') }}">Departments</a>
                <a class="collapse-item" href="{{ route('purposes.index') }}">Purposes</a>
            </div>
        </div>
    </li>
    @endcan
    @can('users_index')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" aria-expanded="true" data-toggle="collapse" aria-controls="collapseTwo"
            data-target="#user">
            <i class="fas fa-file-alt"></i> <span>Users</span>
        </a>
        <div class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar" id="user">
           <div class="bg-white collapse-inner py-2 rounded">
                <h6 class="collapse-header">Users</h6>
                <a class="collapse-item"  href="{{ route('users.index') }}">Users</a>
                @can('users_add')
                <a class="collapse-item" href="{{ route('users.create') }}">Add User</a>
                @endcan
            </div> 
        </div>
    </li>
    @endcan
   
    
    
    
    <hr class="d-none d-md-block sidebar-divider">
    <div class="d-none d-md-inline text-center">
        <button class="rounded-circle border-0" id="sidebarToggle" style="background-color: rgb(0 0 0 / 19%);">

        </button>
    </div>
</ul>
<style>
.sidebar #sidebarToggle {
    width: 2rem;
    height: 2rem;

}
</style>