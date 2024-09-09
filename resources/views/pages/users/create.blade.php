@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="p-5">
                <div class="text-left">
                    <h1 class="heading">Add User</h1>
                </div>
                <form action="{{ route('users.store') }}" class="user" enctype="multipart/form-data" method="post">
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

                    <div class="row form-group">
                        <div class="mb-3 col-sm-12">
                            <input class="form-control" name="name" value="{{ old('name') }}" required placeholder="Name">
                        </div>
                        <div class="mb-3 col-sm-12">
                            <input class="form-control" name="email" type="email" value="{{ old('email') }}" required placeholder="Email">
                        </div>
                        <div class="mb-3 col-sm-12">
                            <input class="form-control" name="phone" value="{{ old('phone') }}" required placeholder="Phone Number">
                        </div>
                        <div class="mb-3 col-sm-12">
                            <input class="form-control" name="password" type="password" required placeholder="Password">
                        </div>
                        <div class="mb-3 col-sm-12">
                            <input class="form-control" name="password_confirmation" type="password" required placeholder="Confirm Password">
                        </div>
                        <div class="mb-3 col-sm-12">
                            <label for="role">Role</label>
                            <select id="role" class="form-control" name="role" required>
                                <option value="">Select Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role }}">{{ ucfirst($role) }}</option>
                                @endforeach
                            </select>
                            
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
        // You can add any custom JavaScript here, if needed
    });
</script>
@endpush
