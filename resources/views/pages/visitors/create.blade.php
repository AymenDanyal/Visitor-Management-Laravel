@extends('layouts.master')

@section('content')
<div class="container-fluid card shadow mb-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="p-5">
                <div class="text-left">
                    <h1 class="heading">Add Visitor</h1>
                </div>
                <form action="{{ route('visitors.store') }}" class="user" enctype="multipart/form-data" method="post">
                    @csrf
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <input type="hidden" class="form-control" value="{{ Auth::user()->id }}" name="gatekeeper_id" required>
                    <input type="hidden" class="form-control" value="" name="group" required>

                    <div class="row form-group">
                        <div class="mb-3 col-sm-6">
                            <input class="form-control" name="name" required placeholder="Visitor Name">
                        </div>
                        <div class="mb-3 col-sm-6">
                            <input class="form-control" name="phone" required placeholder="Phone Number">
                        </div>
                        <div class="mb-3 col-sm-4">
                            <label>CNIC Front Image</label> 
                            <input class="form-control" name="cnic_front_image" required type="file">
                        </div>
                        <div class="mb-3 col-sm-4">
                            <label>CNIC Back Image</label> 
                            <input class="form-control" name="cnic_back_image" required type="file">
                        </div>
                        <div class="mb-3 col-sm-4">
                            <label>User Image</label> 
                            <input class="form-control" name="user_image" required type="file">
                        </div>
                        <div class="mb-3 col-sm-12">
                            <label for="purpose">Purpose of Visit</label>
                            <select id="purpose" class="form-control" name="purpose_of_visit" required>
                                <option value="">Select Purpose</option>
                                @foreach ($purposes as $purpose)
                                    <option value="{{ $purpose->id}}"user>
                                        {{ $purpose->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-sm-6">
                            <input class="form-control" name="department" required placeholder="Department">
                        </div>
                        <div class="mb-3 col-sm-6">
                            <input class="form-control" name="department_person_name" required placeholder="Department Person Name">
                        </div>
                        <div class="mb-3 col-sm-6">
                            <input class="form-control" name="organization_name" placeholder="Organization Name">
                        </div>
                        <div class="mb-3 col-sm-6">
                            <input class="form-control" name="vehicle_number" placeholder="Vehicle Number">
                        </div>
                        <div class="mb-3 col-sm-12">
                            <label>Comments</label> 
                            <textarea class="form-control" name="comments"></textarea>
                        </div>
                        <div class="mb-3 col-sm-12">
                            <button class="btn btn-block btn-primary" type="submit">Submit</button>
                        </div>
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
        // You can add any custom JavaScript for file upload previews or other purposes here

        // Initialize CKEditor for any text areas, if needed
        if ($("#comments").length > 0) {
            CKEDITOR.replace('comments');
        }
    });
</script>
@endpush
