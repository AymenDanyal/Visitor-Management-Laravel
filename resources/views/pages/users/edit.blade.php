@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="p-5">
                <div class="text-left">
                    <h1 class="heading">Edit User</h1>
                </div>
                <form action="{{ route('users.update', ['id' => $user->id]) }}" method="POST" class="user" enctype="multipart/form-data">
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

                    <input type="hidden" name="id" value="{{ $user->id }}">

                    <div class="row form-group">
                        <div class="mb-3 col-sm-12">
                            <input name="name" class="form-control" placeholder="Name" required value="{{ $user->name }}">
                        </div>
                        <div class="mb-3 col-sm-12">
                            <input name="email" type="email" class="form-control" placeholder="Email" required value="{{ $user->email }}">
                        </div>
                        <div class="mb-3 col-sm-12">
                            <input name="phone" class="form-control" placeholder="Phone Number" required value="{{ $user->phone }}">
                        </div>
                        <div class="mb-3 col-sm-12">
                            <label for="role">Role</label>
                            <select id="role" class="form-control" name="role" required>
                                <option value="">Select Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role }}" {{ $user->roles->contains('name', $role) ? 'selected' : '' }}>
                                        {{ ucfirst($role) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                     
                        <div class="mb-3 col-sm-12">
                            <button class="btn btn-block btn-primary" type="submit">Update User</button>
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
