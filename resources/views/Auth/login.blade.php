@extends('auth.layout')

@section('content')
<main>
    <title>EcoImpact - Sign In</title>
    <!-- Section -->
    <section class="vh-lg-100 mt-5 mt-lg-0 bg-soft d-flex align-items-center">
        <div class="container">
            <!-- Back to homepage link -->
            <p class="text-center">
                <a href="/landing" class="d-flex align-items-center justify-content-center">
                    <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                    </svg>
                    Back to homepage
                </a>
            </p>
            <!-- Sign In Form -->
            <div class="row justify-content-center form-bg-image" style="background-image: url('/assets/img/illustrations/signin.svg');">
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="bg-white shadow border-0 rounded border-light p-4 p-lg-5 w-100 fmxw-500">
                        <div class="text-center mb-4">
                            <h1 class="h3">Welcome back</h1>
                        </div>
                        <form method="POST" action="{{ route('login.submit') }}">
    @csrf
    <!-- Email Input -->
    <div class="form-group mb-4">
        <label for="email">Your Email</label>
        <div class="input-group">
        <span class="input-group-text" id="basic-addon1">
                                        <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                        </svg>
                                    </span>            <input type="email" class="form-control" name="email" placeholder="example@company.com" id="email" required autofocus value="{{ old('email') }}">
        </div>
        @error('email')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <!-- Password Input -->
    <div class="form-group mb-4">
        <label for="password">Your Password</label>
        <div class="input-group">
        <span class="input-group-text" id="basic-addon2">
                                        <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </span>
            <input type="password" name="password" class="form-control" placeholder="Password" id="password" required>
        </div>
        @error('password')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>


                            <!-- Remember Me & Forgot Password -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                    <label class="form-check-label" for="remember">Remember me</label>
                                </div>
                                <a href="/forgotPassword" class="small text-right">Lost password?</a>
                            </div>
                            <!-- Submit Button -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-gray-800">Sign in</button>
                            </div>
                        </form>


                       

                        <!-- Social Login Options -->
                        <div class="mt-3 mb-4 text-center">
                            <span class="fw-normal">or login with</span>
                        </div>
                        <div class="d-flex justify-content-center my-4">
                            <a href="#" class="btn btn-icon-only btn-pill btn-outline-gray-500 me-2" aria-label="Facebook login" title="Facebook login">
                                <svg class="icon icon-xxs" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                    <path fill="currentColor" d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"></path>
                                </svg>
                            </a>
                            <a href="#" class="btn btn-icon-only btn-pill btn-outline-gray-500 me-2" aria-label="Twitter login" title="Twitter login">
                                <svg class="icon icon-xxs" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path fill="currentColor" d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"></path>
                                </svg>
                            </a>
                            <a href="#" class="btn btn-icon-only btn-pill btn-outline-gray-500" aria-label="GitHub login" title="GitHub login">
                                <svg class="icon icon-xxs" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512">
                                    <path fill="currentColor" d="M165.9 397.4c0 2-2.3 3.6-5.2 3.6-3.3.3-5.6-1.3-5.6-3.6 0-2 2.3-3.6 5.2-3.6 3-.3 5.6 1.3 5.6 3.6zm-31.3-2.6c-.7 2 .7 4.3 3.3 4.6 2.6.7 5.6-.7 6.3-2.6.7-2-.7-4.3-3.3-4.6-2.6-.7-5.6.7-6.3 2.6zm44.2 1c-2.9.7-4.9 2.3-4.6 4.9.3 2.3 3.3 3.6 6.5 2.6 3-.7 4.9-2.3 4.6-4.9-.3-2.3-3.3-3.6-6.5-2.6z"></path>
                                </svg>
                            </a>
                        </div>
                        <div class="d-flex justify-content-center align-items-center mt-4">
                            <span class="fw-normal">
                                Not registered? 
                                <a href="/register" class="fw-bold">Create account</a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
