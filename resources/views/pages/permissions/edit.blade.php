@extends('layouts.master')

@section('content')
<div class="container-fluid card shadow mb-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="p-5">
                <div class="text-left">
                    <h1 class="heading">Edit Permission</h1>
                </div>
                <form action="{{ route('permissions.update', ['id' => $permission->id]) }}" method="POST" class="permission">
                    @csrf
                    @method('PUT')
                    
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <input type="hidden" name="id" value="{{ $permission->id }}">

                    <div class="row form-group">
                        <div class="mb-3 col-sm-12">
                            <input name="name" class="form-control" placeholder="Permission Name" required value="{{ old('name', $permission->name) }}">
                        </div>

                        <div class="mb-3 col-sm-12">
                            <button class="btn btn-block btn-primary" type="submit">Update Permission</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    // Custom JavaScript for permissions can be added here if needed
</script>
@endpush
