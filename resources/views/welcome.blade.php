@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 text-center">
            <h1>Welcome to {{ config('app.name') }}</h1>
            <p>Please select your role to continue.</p>
            
            <div class="row justify-content-center mt-4">
                <div class="col-md-6">
                    <form action="{{ route('role.redirect') }}" method="POST">
                        @csrf
                        <div class="input-group mb-3">
                            <select name="role" class="form-control @error('role') is-invalid @enderror">
                                <option value="">Select your role</option>
                                <option value="student">Student</option>
                                <option value="teacher">Teacher</option>
                                <option value="admin">Admin</option>
                                <option value="developer">Developer</option>
                            </select>
                            <button class="btn btn-primary" type="submit">Continue</button>
                        </div>
                        @error('role')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection