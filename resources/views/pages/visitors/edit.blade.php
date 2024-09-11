@extends('layouts.master')

@section('content')
<div class="container-fluid card shadow mb-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="p-5">
                <div class="text-left">
                    <h1 class="heading">Edit Visitor</h1>
                </div>
                <form action="{{ route('visitors.update', ['id' => $visitor->id]) }}" method="POST" class="user"
                    enctype="multipart/form-data">
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

                    <input type="hidden" name="id" value="{{ $visitor->id }}">

                    <div class="row form-group">
                        <div class="mb-3 col-sm-6">
                            <input name="name" class="form-control" placeholder="Visitor Name" required
                                value="{{ $visitor->name }}">
                        </div>
                        <div class="mb-3 col-sm-6">
                            <input name="phone" class="form-control" placeholder="Phone Number" required
                                value="{{ $visitor->phone }}">
                        </div>
                        
                        <div class="mb-3 col-sm-12">
                            <label for="purpose">Purpose of Visit</label>
                            <select id="purpose" class="form-control" name="purpose_of_visit" required>
                                <option value="">Select Purpose</option>
                                @foreach ($purposes as $purpose)
                                    <option value="{{ $purpose->id }}" {{ $visitor->purpose_of_visit == $purpose->id ? 'selected' : '' }}>
                                        {{ $purpose->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3 col-sm-4">
                            <label>CNIC Front Image</label>
                            <input class="form-control" name="cnic_front_image" type="file">
                            <!-- Show the old CNIC front image underneath the input field -->
                            @if($visitor->cnic_front_image)
                            <img src="{{ asset('storage/' . $visitor->cnic_front_image) }}" alt="CNIC Front Image"
                                class="mt-2 img-thumbnail" style="max-width: 150px;">
                            @endif
                        </div>

                        <div class="mb-3 col-sm-4">
                            <label>CNIC Back Image</label>
                            <input class="form-control" name="cnic_back_image"  type="file">
                            <!-- Show the old CNIC back image underneath the input field -->
                            @if($visitor->cnic_back_image)
                            <img src="{{ asset('storage/' . $visitor->cnic_back_image) }}" alt="CNIC Back Image"
                                class="mt-2 img-thumbnail" style="max-width: 150px;">
                            @endif
                        </div>

                        <div class="mb-3 col-sm-4">
                            <label>User Image</label>
                            <input class="form-control" name="user_image" type="file">
                            <!-- Show the old user image underneath the input field -->
                            @if($visitor->user_image)
                            <img src="{{ asset('storage/' . $visitor->user_image) }}" alt="User Image"
                                class="mt-2 img-thumbnail" style="max-width: 150px;">
                            @endif
                        </div>

                        <div class="mb-3 col-sm-6">
                            <label for="organization">Organization</label>
                            <input id="organization" name="organization_name" class="form-control" type="text"
                                value="{{ $visitor->organization_name }}">
                        </div>
                        <div class="mb-3 col-sm-6">
                            <label for="vehicle_number">Vehicle Number</label>
                            <input id="vehicle_number" name="vehicle_number" class="form-control" type="text"
                                value="{{ $visitor->vehicle_number }}">
                        </div>
                        <div class="mb-3 col-sm-12">
                            <label for="comments">Comments</label>
                            <textarea id="comments" class="form-control"
                                name="comments">{{ $visitor->comments }}</textarea>
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
<script type="text/javascript">

</script>
@endpush