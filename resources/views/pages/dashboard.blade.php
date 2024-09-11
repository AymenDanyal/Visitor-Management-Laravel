@extends('layouts.master')

@section('content')
<div class="container-fluid card shadow mb-4">

    <div class="row">
        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        {{-- <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Contact Quries</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ DB::table('contact_queries')->count() }}</div>

                        </div> --}}
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        {{-- <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Products</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ DB::table('products')->count() }}</div>
                        </div> --}}
                        <div class="col-auto">
                            <i class="fas fa-shapes fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        {{-- <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Blogs</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ DB::table('products')->count() }}</div>
                        </div> --}}
                        <div class="col-auto">
                            <i class="fas fa-blog fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     
    
        
    </div>
</div>
@endsection

@push('scripts')

@endpush
