<!DOCTYPE html>
<html lang="en">

<head>
    
    <style>
        .login_logo {
            background-image: url('{{ asset('assets/logo/avon.png') }}');
            background-position: center center;
            background-repeat: no-repeat;
            background-size: 350px;
        }

        .logbtn {
            background-color: #ba0404;
            color: #fff !important;
        }
    </style>
</head>

<body class="bg-gradient-light">
    <div class="container">
        <div class="row justify-content-center py-5">
            <div class="col-lg-12 col-md-9 col-xl-10">
                @if (session('msg'))
                    <div class="alert alert-danger">
                        {{ session('msg') }}
                    </div>
                @endif
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-gradient-light login_logo py-5"></div>
                            <div class="col-lg-6 py-5">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <form action="{{ route('login') }}" method="POST" class="user">
                                        @csrf
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" id="exampleInputEmail" name="email" placeholder="Enter Email Address..." aria-describedby="emailHelp">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="exampleInputPassword" name="password" placeholder="Password">
                                        </div>
                                        <button type="submit" class="btn btn-user btn-block logbtn">Login</button>
                                        <hr>
                                    </form>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>
</body>

</html>
