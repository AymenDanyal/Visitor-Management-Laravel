@extends('layouts.master')

@section('content')
<div class="container-fluid card shadow mb-4">
    <h1 class="heading">Visit History</h1>

    <!-- DataTable -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="checkInsTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Visitor Name</th>
                            <th>Gatekeeper Name</th>
                            <th>Purpose of Visit</th>
                            <th>Department</th>
                            <th>Department Person Name</th>
                            <th>Check-In Time</th>
                            <th>Check-Out Time</th>
                            <th>Created At</th>
                            @can('visitor_history_delete')
                                <th>Actions</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($checkIns as $checkIn)
                        <tr id="row-{{ $checkIn->id }}">
                            <td>{{ $checkIn->visitor->name }}</td>
                            <td>{{ $checkIn->gatekeeper->name }}</td>
                            <td>{{ $checkIn->purposes->name }}</td>
                            <td>{{ $checkIn->departments->name }}</td>
                            <td>{{ $checkIn->department_person_name }}</td>
                            <td>{{ $checkIn->check_in_time }}</td>
                            <td>{{ $checkIn->check_out_time }}</td>
                            <td>{{ $checkIn->created_at }}</td>
                            <td id="checkin-row-{{ $checkIn->id }}">
                                @can('visitor_history_delete')
                                    <button class="btn btn-danger delete-btn" data-id="{{ $checkIn->id }}">Delete</button>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
<style>
    .heading {
        padding: 22px 0px;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        $('#checkInsTable').DataTable({
            "paging": true,
            "searching": true,
            "info": true
        });

        $('.delete-btn').on('click', function() {
            const checkInId = $(this).data('id');
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
                        url: `/check-ins/${checkInId}`,
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                'The check-in record has been deleted.',
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
