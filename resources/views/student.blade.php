@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Student Registration</h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('student.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="form-group mb-3">
                            <label for="student_name">Full Name</label>
                            <input type="text" class="form-control @error('student_name') is-invalid @enderror" 
                                id="student_name" name="student_name" value="{{ old('student_name') }}" required>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="student_roll">Roll Number (8 digits)</label>
                                <input type="text" class="form-control @error('student_roll') is-invalid @enderror" 
                                    id="student_roll" name="student_roll" value="{{ old('student_roll') }}" 
                                    pattern="[0-9]{8}" title="Please enter 8 digits" required>
                            </div>
                            <div class="col-md-6">
                                <label for="student_reg">Registration Number (4-6 digits)</label>
                                <input type="text" class="form-control @error('student_reg') is-invalid @enderror" 
                                    id="student_reg" name="student_reg" value="{{ old('student_reg') }}" 
                                    pattern="[0-9]{4,6}" title="Please enter 4-6 digits" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="student_session">Session</label>
                                <input type="text" class="form-control @error('student_session') is-invalid @enderror" 
                                    id="student_session" name="student_session" value="{{ old('student_session') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="student_department">Department</label>
                                <input type="text" class="form-control @error('student_department') is-invalid @enderror" 
                                    id="student_department" name="student_department" value="{{ old('student_department') }}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="student_email">Email</label>
                                <input type="email" class="form-control @error('student_email') is-invalid @enderror" 
                                    id="student_email" name="student_email" value="{{ old('student_email') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="student_phone">Phone Number</label>
                                <input type="tel" class="form-control @error('student_phone') is-invalid @enderror" 
                                    id="student_phone" name="student_phone" value="{{ old('student_phone') }}" required>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="student_password">Password</label>
                            <input type="password" class="form-control @error('student_password') is-invalid @enderror" 
                                id="student_password" name="student_password" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="student_fingerprint">Fingerprint (Optional)</label>
                            <input type="file" class="form-control @error('student_fingerprint') is-invalid @enderror" 
                                id="student_fingerprint" name="student_fingerprint">
                        </div>

                        <button type="submit" class="btn btn-primary">Register</button>
                        <p>I have a Acount</p>
                        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection