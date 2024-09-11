@extends('layouts.master')

@section('content')
<div class="container-fluid card shadow mb-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="p-5">
                <div class="text-left mb-4">
                    <h1 class="heading">Create New Role</h1>
                </div>
                <form action="{{ route('roles.store') }}" method="POST">
                    @csrf

                    @if ($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="form-group mb-4">
                        <label for="role-name" class="form-label">Role Name</label>
                        <input id="role-name" name="name" class="form-control" placeholder="Role Name" required value="{{ old('name') }}">
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label">Existing Permissions</label>
                        <div id="existing-permissions">
                            @foreach($permissions as $permission)
                                <div class="d-flex align-items-center mb-3" id="existing-permission-{{ $permission->id }}">
                                    <input type="checkbox" name="existing_permissions[]" value="{{ $permission->id }}" id="permission-{{ $permission->id }}" 
                                        @if(in_array($permission->id, old('existing_permissions', []))) checked @endif>
                                    <label class="form-check-label ms-2" for="permission-{{ $permission->id }}">
                                        {{ $permission->name }}
                                    </label>
                                    <button type="button" class="btn btn-danger btn-sm ms-3" onclick="removePermission({{ $permission->id }}, 'existing')">Remove</button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label">New Permissions</label>
                        <div id="new-permissions">
                            <!-- New permission fields will be added here -->
                        </div>
                        <button type="button" class="btn btn-secondary" id="add-permission">Add Permission</button>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary btn-block" type="submit">Create Role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        let permissionIndex = 0;

        // Add new permission field
        $('#add-permission').click(function() {
            permissionIndex++;
            const newPermissionHtml = `
                <div class="d-flex align-items-center mb-3" id="new-permission-${permissionIndex}">
                    <input type="text" name="new_permissions[]" class="form-control" placeholder="New Permission Name" required>
                    <button type="button" class="btn btn-danger btn-sm ms-3" onclick="removePermission(${permissionIndex}, 'new')">Remove</button>
                </div>
            `;
            $('#new-permissions').append(newPermissionHtml);
        });

        // Remove permission field
        window.removePermission = function(index, type) {
            if (type === 'existing') {
                $(`#existing-permission-${index}`).remove();
            } else {
                $(`#new-permission-${index}`).remove();
            }
        }
    });
</script>
@endpush
@endsection
