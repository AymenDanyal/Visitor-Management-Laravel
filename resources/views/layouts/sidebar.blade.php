<ul class="navbar-nav accordion bgside sidebar sidebar-dark" id="accordionSidebar">
    <a class="d-flex align-items-center justify-content-center sidebar-brand" href="/">
        <div class="sidebar-brand-icon">
            <img class="logo img-fluid d-block auto p-2 p-md-4" src="{{asset('/logo/avon.png')}}" alt="Visitor Log Logo">
        </div>
    </a>
    <hr class="sidebar-divider my-0">


    <li class="nav-item">
        <a class="nav-link collapsed" href="#" aria-expanded="true" data-toggle="collapse" aria-controls="collapseTwo"
            data-target="#visitor">
            <i class="fas fa-file-alt"></i> <span>Visitors</span>
        </a>
        <div class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar" id="visitor">
             <div class="bg-white collapse-inner py-2 rounded">
                <h6 class="collapse-header">Blogs</h6>
                <a class="collapse-item"  href="{{ route('visitors.index') }}">Visitors</a>
                <a class="collapse-item" href="{{ route('visitors.create') }}">Add Visitors</a>
            </div> 
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" aria-expanded="true" data-toggle="collapse" aria-controls="collapseTwo"
            data-target="#products">
            <i class="fas fa-boxes"></i> <span>Departments</span>
        </a>
        <div class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar" id="products">
            {{-- <div class="bg-white collapse-inner py-2 rounded">
                <h6 class="collapse-header">Products</h6>
                <a class="collapse-item" href="{{ route('products.index') }}">Products</a>
                <a class="collapse-item" href="{{ route('products.create') }}">Add Products</a>
                <a class="collapse-item"  href="{{ route('product-cats.index') }}">Products Categroies</a>
            </div> --}}
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" aria-expanded="true" data-toggle="collapse" aria-controls="collapseTwo"
            data-target="#user">
            <i class="fas fa-file-alt"></i> <span>Users</span>
        </a>
        <div class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar" id="user">
           <div class="bg-white collapse-inner py-2 rounded">
                <h6 class="collapse-header">Blogs</h6>
                <a class="collapse-item"  href="{{ route('users.index') }}">Users</a>
                <a class="collapse-item" href="{{ route('users.create') }}">Add User</a>
            </div> 
        </div>
    </li>
    
    <hr class="d-none d-md-block sidebar-divider">
    <div class="d-none d-md-inline text-center">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>