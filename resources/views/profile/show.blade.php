@extends('layouts.app') 

@section('content')
<div class="container">
    <h1 class="my-4">My Profile</h1>

    {{-- Display Success or Error Messages --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- User Details Form --}}
    <div class="card mb-4">
        <div class="card-header">
            Update Profile Information
        </div>
        <div class="card-body">
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        </div>
    </div>

    {{-- Change Password Form --}}
    <div class="card">
        <div class="card-header">
            Change Password
        </div>
        <div class="card-body">
            <form action="{{ route('profile.changePassword') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="current_password" class="form-label">Current Password</label>
                    <input type="password" name="current_password" id="current_password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-warning">Change Password</button>
            </form>
        </div>
    </div>
</div>
@endsection
