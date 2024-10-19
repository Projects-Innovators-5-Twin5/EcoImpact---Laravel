@extends('auth.layout')

@section('content')
<main>
    <section class="vh-lg-100 mt-5 mt-lg-0 bg-soft d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="signin-inner my-3 bg-white shadow border-0 rounded p-4 w-100 fmxw-500">
                        <h1 class="h3">Forgot your password?</h1>
                        <p class="mb-4">Enter your email and we will send you a password reset link.</p>
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="mb-4">
                                <label for="email">Your Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="example@example.com" required>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-gray-800">Send Password Reset Link</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
