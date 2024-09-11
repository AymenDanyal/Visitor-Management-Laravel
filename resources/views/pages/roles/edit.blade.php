@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="p-5">
                <div class="text-left">
                    <h1 class="heading">Edit Role</h1>
                </div>
                <form action="{{ route('roles.update', ['id' => $role->id]) }}" method="POST" class="role">
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

                    <input type="hidden" name="id" value="{{ $role->id }}">

                    <div class="row form-group">
                        <div class="mb-3 col-sm-12">
                            <input name="name" class="form-control" placeholder="Role Name" required value="{{ old('name', $role->name) }}">
                        </div>
                        
                        <div class="mb-3 col-sm-12">
                            <label for="permissions">Permissions</label>
                            <div class="form-check">
                                @foreach($permissions as $permission)
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="permission-{{ $permission->id }}" name="permissions[]" value="{{ $permission->id }}" {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="permission-{{ $permission->id }}">
                                            {{ ucfirst($permission->name) }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                     
                        <div class="mb-3 col-sm-12">
                            <button class="btn btn-block btn-primary" type="submit">Update Role</button>
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
    // Any custom JavaScript can be added here if needed
</script>
@endpush
