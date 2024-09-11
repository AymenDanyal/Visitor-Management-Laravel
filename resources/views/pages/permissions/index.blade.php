@extends('layouts.master')

@section('content')
<div class="container-fluid card shadow mb-4">
    <h1 class="heading">Users</h1>

    <a href="{{ route('users.create') }}" class="btn btn-primary add-button">Add User</a>

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
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr id="row-{{ $user->id }}">
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->role }}</td>
                            <td id="user-row-{{ $user->id }}">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-success">Edit</a>
                                <button class="btn btn-danger delete-btn" data-id="{{ $user->id }}">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid card shadow mb-4">
    <h1 class="heading">Roles</h1>

    <a href="{{ route('users.create') }}" class="btn btn-primary add-button">Add User</a>

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
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr id="row-{{ $user->id }}">
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->role }}</td>
                            <td id="user-row-{{ $user->id }}">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-success">Edit</a>
                                <button class="btn btn-danger delete-btn" data-id="{{ $user->id }}">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
{{-- </div>
<div class="container-fluid card shadow mb-4">
    <h1 class="heading">Roles Permissions</h1>

    <a href="{{ route('users.create') }}" class="btn btn-primary add-button">Add User</a>

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
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr id="row-{{ $user->id }}">
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->role }}</td>
                            <td id="user-row-{{ $user->id }}">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-success">Edit</a>
                                <button class="btn btn-danger delete-btn" data-id="{{ $user->id }}">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>  --}}
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
        padding: 22px 0px;
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

        $('.delete-btn').on('click', function() {
            const userId = $(this).data('id');
            const row = $(this).closest('tr');

            // SweetAlert2 for confirmation
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
                    // Proceed with AJAX request
                    $.ajax({
                        url: `/users/${userId}`,
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            // Show success message and remove the row
                            Swal.fire(
                                'Deleted!',
                                'The user has been deleted.',
                                'success'
                            ).then(() => {
                                row.remove();
                            });
                        },
                        error: function(xhr) {
                            // Show error message
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
