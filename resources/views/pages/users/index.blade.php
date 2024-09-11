@extends('layouts.master')

@section('content')

@can('users_index')
<div class="container-fluid card shadow mb-4">
    <h1 class="heading">Users</h1>
    @can('users_create')
    <a href="{{ route('users.create') }}" class="btn btn-primary add-button">Add User</a>
    @endcan
    <!-- DataTable -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="usersTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Role</th>
                            @canany(['users_edit', 'user_delete'])
                            <th>Actions</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr id="row-{{ $user->id }}">
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>
                                @foreach($user->roles as $role)
                                {{ $role->name }}<br>
                                @endforeach
                            </td>
                            @canany(['users_edit', 'user_delete'])
                            <td>
                                @can('users_edit')
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-success">Edit</a>
                                @endcan

                                @can('users_delete')
                                <button class="btn btn-danger delete-user" data-id="{{ $user->id }}">Delete</button>
                                @endcan
                            </td>
                            @endcanany
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endcan
@can('roles_index')
<div class="container-fluid card shadow mb-4">
    <h1 class="heading">Roles</h1>
    @can('roles_create')
    <a href="{{ route('roles.create') }}" class="btn btn-primary add-button">Add Role</a>
    @endcan
    <!-- DataTable -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="rolesTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Permissions</th>
                            @canany(['roles_edit', 'roles_delete'])
                            <th>Actions</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                        <tr id="row-{{ $role->id }}">
                            <td>{{ $role->name }}</td>
                            <td>
                                @foreach($role->permissions as $permission)
                                {{ $permission->name }}<br>
                                @endforeach
                            </td>
                            @canany(['roles_edit', 'roles_delete'])
                            <td>


                                @can('roles_edit')
                                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-success">Edit</a>
                                @endcan
                                @can('roles_delete')
                                <button class="btn btn-danger delete-role" data-id="{{ $role->id }}">Delete</button>
                                @endcan
                            </td>
                            @endcanany
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endcan
@can('permissions_index')
<div class="container-fluid card shadow mb-4">
    <h1 class="heading">Permissions</h1>
    @can('permissions_create')
    <a href="{{ route('permissions.create') }}" class="btn btn-primary add-button">Add Permission</a>
    @endcan
    <!-- DataTable -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="permissionsTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Permissions</th>
                            @canany(['permissions_edit', 'permissions_delete'])
                            <th>Actions</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($permissions as $permission)
                        <tr id="row-{{ $permission->id }}">
                            <td>{{ $permission->name }}</td>
                            @canany(['permissions_edit', 'permissions_delete'])
                            <td>
                                @can('permissions_edit')
                                <a href="{{ route('permissions.edit', $permission->id) }}"
                                    class="btn btn-success">Edit</a>
                                @endcan
                                @can('permissions_delete')
                                <button class="btn btn-danger delete-permission"
                                    data-id="{{ $permission->id }}">Delete</button>
                                @endcan
                            </td>
                            @endcanany
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endcan
@endsection
@push('style')
<style>
    .add-button {
        width: 150px;
        position: absolute;
        right: 25px;
        top: 43px;
        border-radius: 4px;
    }

    .heading {
        padding: 22px 0;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        $('#usersTable').DataTable({
            "paging": true,
            "searching": true,
            "info": true
        });

        $('#rolesTable').DataTable({
            "paging": true,
            "searching": true,
            "info": true
        });

        $('#permissionsTable').DataTable({
            "paging": true,
            "searching": true,
            "info": true
        });

        $('.delete-user').on('click', function() {
            const userId = $(this).data('id');
            const row = $(this).closest('tr');

            Swal.fire({
                title: 'Are you sure?',
                text: 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/users/${userId}`,
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                'The user has been deleted.',
                                'success'
                            ).then(() => {
                                row.remove();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error!',
                                'There was an error with the request.',
                                'error'
                            );
                        }
                    });
                }
            });
        });

        $('.delete-role').on('click', function() {
            const roleId = $(this).data('id');
            const row = $(this).closest('tr');

            Swal.fire({
                title: 'Are you sure?',
                text: 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/roles/${roleId}`,
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                'The role has been deleted.',
                                'success'
                            ).then(() => {
                                row.remove();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error!',
                                'There was an error with the request.',
                                'error'
                            );
                        }
                    });
                }
            });
        });

        $('.delete-permission').on('click', function() {
            const permissionId = $(this).data('id');
            const row = $(this).closest('tr');

            Swal.fire({
                title: 'Are you sure?',
                text: 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/permissions/${permissionId}`,
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                'The permission has been deleted.',
                                'success'
                            ).then(() => {
                                row.remove();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error!',
                                'There was an error with the request.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });
</script>
@endpush