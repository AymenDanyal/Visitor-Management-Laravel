<!DOCTYPE html>
<html lang="en">

@include('layouts.head')

<body id="page-top">
    <div id="wrapper">
        @include('layouts.sidebar')

        <div class="d-flex flex-column" id="content-wrapper">

            <div id="content">
                @include('layouts.header')
                @yield('content')
            </div>
                
                @include('layouts.footer')

            </div>
            @stack('scripts')
</body>

</html>