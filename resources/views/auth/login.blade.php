@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center min-vh-100" style="background: linear-gradient(135deg, #667eea, #764ba2);">
    <div class="card p-4 shadow-lg rounded" style="width: 100%; max-width: 400px; background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border: none;">
        <div class="text-center mb-3">
            <h2 class="text-white">Login</h2>
        </div>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label class="text-white">Email</label>
                <input type="email" name="email" class="form-control bg-transparent text-white border-light @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="text-white">Password</label>
                <input type="password" name="password" class="form-control bg-transparent text-white border-light @error('password') is-invalid @enderror" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-light w-100 fw-bold">Login</button>
        </form>
    </div>
</div>
@endsection