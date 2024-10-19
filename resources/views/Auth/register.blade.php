@extends('auth.layout')

@section('content')
<main>
    <title>EcoImpact - Sign up page</title>
    <!-- Section -->
    <section class="vh-lg-100 mt-5 mt-lg-0 bg-soft d-flex align-items-center">
        <div class="container">
            <p class="text-center">
                <a href="/landing" class="d-flex align-items-center justify-content-center">
                    <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                    </svg>
                    Back to homepage
                </a>
            </p>
            <div class="row justify-content-center form-bg-image" style="background-image: url('/assets/img/illustrations/signin.svg');">
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="bg-white shadow border-0 rounded border-light p-4 p-lg-5 w-100 fmxw-500">
                        <div class="text-center text-md-center mb-4 mt-md-0">
                            <h1 class="mb-0 h3">Create Account</h1>
                        </div>
                        <form action="{{ url('/register') }}" method="POST" class="mt-4">
                            @csrf

                            <!-- Nom -->
                            <div class="form-group mb-4">
                                <label for="name">Nom</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">
                                        <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                        </svg>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Emna Khiari" id="name" name="name" value="{{ old('name') }}" autofocus >
                                </div>
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="form-group mb-4">
                                <label for="email">Your Email</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">
                                        <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                        </svg>
                                    </span>
                                    <input type="email" class="form-control" placeholder="example@company.com" id="email" name="email" value="{{ old('email') }}" >
                                </div>
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Mot de passe -->
                            <div class="form-group mb-4">
                                <label for="password">Your Password</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon2">
                                        <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </span>
                                    <input type="password" placeholder="Password" class="form-control" id="password" name="password" >
                                </div>
                                @error('password')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Confirmation mot de passe -->
                            <div class="form-group mb-4">
                                <label for="confirm_password">Confirm Password</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon2">
                                        <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </span>
                                    <input type="password" placeholder="Confirm Password" class="form-control" id="confirm_password" name="password_confirmation">
                                </div>
                                @error('password_confirmation')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Checkbox termes et conditions -->
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms" >
                                    <label class="form-check-label fw-normal mb-0" for="terms">
                                        I agree to the <a href="#" class="fw-bold">terms and conditions</a>
                                    </label>
                                </div>
                            </div>

                            <!-- Bouton d'envoi -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-gray-800">Sign up</button>
                            </div>
                        </form>

                        <div class="mt-3 mb-4 text-center">
                            <span class="fw-normal">or login with</span>
                        </div>
                        <div class="d-flex justify-content-center my-4">
                            <!-- Social media buttons -->
                            <a href="#" class="btn btn-icon-only btn-pill btn-outline-gray-500 me-2" aria-label="facebook button" title="facebook button">
                                <svg class="icon icon-xxs" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="facebook-f" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                    <path fill="currentColor" d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"></path>
                                </svg>
                            </a>
                            <a href="#" class="btn btn-icon-only btn-pill btn-outline-gray-500 me-2" aria-label="twitter button" title="twitter button">
                                <svg class="icon icon-xxs" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="twitter" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path fill="currentColor" d="M459.37 151.72c.32 4.84.32 9.68.32 14.52 0 147.54-112.23 317.24-317.24 317.24-63.17 0-121.64-18.43-171.17-50.25 8.77 1.07 17.58 1.4 26.58 1.4 52.1 0 100.17-17.79 138.73-47.68-48.71-1.07-89.99-32.97-104.23-76.87 6.81 1.34 13.74 2.04 20.81 2.04 10.11 0 19.99-1.39 29.45-4.02-51-10.19-89.22-55.29-89.22-109.76 0-.49 0-1 .02-1.48 15.07 8.4 32.28 13.43 50.54 14.01-29.99-20.05-49.89-54.16-49.89-92.66 0-20.47 5.56-39.67 15.17-56.15 55.46 68.05 138.56 112.39 232.6 117.06-1.97-8.2-2.98-16.79-2.98-25.68 0-62.27 50.62-112.89 112.89-112.89 32.52 0 61.82 13.73 82.45 35.85 25.99-5.08 50.35-14.51 72.23-27.44-8.47 26.45-26.17 48.59-49.59 62.79 22.93-2.72 44.67-8.77 64.82-17.61-15.13 22.88-34.09 43.1-55.72 59.27z"></path>
                                </svg>
                            </a>
                            <a href="#" class="btn btn-icon-only btn-pill btn-outline-gray-500" aria-label="github button" title="github button">
                                <svg class="icon icon-xxs" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="github" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                                    <path fill="currentColor" d="M632 488c-18 0-34-2-50-5-4-8-7-14-11-20-3-5-5-11-8-16-5 4-10 7-16 9-4 1-9 2-14 2s-9-1-14-2c-5-2-11-5-16-9-3 5-6 11-9 16-4 6-8 12-12 20-16 3-32 5-50 5-35 0-67-7-95-21-26-13-49-31-67-54-12 5-27 9-44 9-43 0-81-24-101-58-8-13-14-27-16-43-2-10-3-21-4-33-5-2-8-6-11-10-4-5-8-11-12-16-7-9-11-18-16-27-1-3-2-7-3-10-1-4-2-8-2-13 0-1 0-2 0-3v-3c4-3 9-6 14-8 5-2 9-5 12-8 10-11 15-25 15-42 0-18-8-35-22-44-4-3-8-5-12-7-12-5-24-8-37-8-9 0-17 1-25 3-12 3-25 10-34 19-5 5-10 11-12 18-5-3-10-5-16-6-14-2-27-1-39 3-6 2-10 4-14 6-4 3-7 7-9 11-2 5-4 11-5 16-1 5-2 10-2 15-1 7-1 14-2 21-1 2-2 4-4 5-6 1-4 1-8 1-12 0-18-1-36-2-54 0-6 1-12 1-18 0-16 0-33 1-50s2-32 5-49c2-12 4-23 7-34 1-5 1-9 3-12 1-4 4-8 8-10 0-1 0-1-1-1 0 0-1 0-1 1-1 2-1 5-1 8-1 5-1 10-1 15 0 4 0 7 1 11 0 3 0 7 0 10 1 10 1 21 3 32s4 19 7 29c0 1 1 2 1 3 1 5 2 9 4 13 2 6 5 11 9 16 7 9 17 17 29 22 14 6 31 10 48 10 31 0 64-11 92-28 3 0 7 0 10-1 2-1 4-2 6-3 8-4 17-10 23-17 11-10 16-24 18-39s-2-32-12-43c-8-8-21-14-35-14-7 0-15 2-22 5 5-11 9-22 11-34s1-25-1-37c-1-5-2-10-3-15-2-9-3-18-3-28s1-19 3-28c1-5 2-10 3-15 1-6 2-12 4-18 1-4 3-8 6-11 4-4 10-5 16-5 11 0 22 3 32 8 14 6 25 18 33 32 3 5 4 10 5 15 2 8 2 15 2 23 0 14-2 27-6 39-5 13-10 25-16 37-8 14-18 27-31-1 0 0-1 1-1 1 2 7 4 12 7 17 8 11 12 26 12 42 0 12-1 23-3 34-1 5-1 10-2 15-3 0 0 0 0 0 0z"></path>
                                </svg>
                            </a>
                        </div>
                        <div class="text-center">
                            <p class="text-muted mb-0">Already have an account? <a href="{{ url('/login') }}" class="fw-bold">Login</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection