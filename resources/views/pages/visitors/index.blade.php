@extends('layouts.master')

@section('content')
<div class="container-fluid card shadow mb-4">
    <h1 class="heading">Visitors</h1>

    <a href="{{ route('visitors.create') }}" class="btn btn-primary add-button">Add visitor</a>

    <!-- DataTable -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="visitorsTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>CNIC Front Image</th>
                            <th>CNIC Back Image</th>
                            <th>User Image</th>
                            <th>Purpose of Visit</th>
                            <th>Department</th>
                            <th>Department Person Name</th>
                            <th>Organization Name</th>
                            <th>Vehicle Number</th>
                            <th>Comments</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($visitors as $visitor)
                        <tr id="row-{{ $visitor->id }}">
                            <td>{{ $visitor->name }}</td>
                            <td>{{ $visitor->phone }}</td>
                            <td>
                                @if($visitor->cnic_front_image)
                                <img src="{{ asset('storage/' . $visitor->cnic_front_image) }}" alt="CNIC Front Image"
                                    width="100">
                                @else
                                No Image
                                @endif
                            </td>
                            <td>
                                @if($visitor->cnic_back_image)
                                <img src="{{ asset('storage/' . $visitor->cnic_back_image) }}" alt="CNIC Back Image"
                                    width="100">
                                @else
                                No Image
                                @endif
                            </td>
                            <td>
                                @if($visitor->user_image)
                                <img src="{{ asset('storage/' . $visitor->user_image) }}" alt="User Image" width="100">
                                @else
                                No Image
                                @endif
                            </td>
                            <td>{{ $visitor->purpose_of_visit }}</td>
                            <td>{{ $visitor->department }}</td>
                            <td>{{ $visitor->department_person_name }}</td>
                            <td>{{ $visitor->organization_name }}</td>
                            <td>{{ $visitor->vehicle_number }}</td>
                            <td>{{ $visitor->comments }}</td>
                            <td id="visitor-row-{{ $visitor->id }}">
                                <a href="{{ route('visitors.edit', $visitor->id) }}" class="btn btn-success">Edit</a>
                                <button class="btn btn-danger delete-btn" data-id="{{ $visitor->id }}">Delete</button>
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
        $('#visitorsTable').DataTable({
            "paging": true,
            "searching": true,
            "info": true
        });

        $('.delete-btn').on('click', function() {
            const visitorId = $(this).data('id');
            const row = $(this).closest('trusers');

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
                    url: `/visitors/${visitorId}`,
                    type: 'DELETE',
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                        success: function(response) {
                            // Show success message and remove the row
                            Swal.fire(
                                'Deleted!',
                                'The visitor has been deleted.',
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