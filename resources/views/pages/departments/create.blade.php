@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="p-5">
                <div class="text-left">
                    <h1 class="heading">Add Department</h1>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('departments.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row form-group">
                        <div class="mb-3 col-sm-12">
                            <label for="name">Department Name</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required placeholder="Department Name">
                        </div>
                    </div>

                    <div class="mb-3 col-sm-12">
                        <button class="btn btn-block btn-primary" type="submit">Add Department</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    jQuery(document).ready(function($) {
        // Add any custom JavaScript if needed
    });
</script>
@endpush
purposes