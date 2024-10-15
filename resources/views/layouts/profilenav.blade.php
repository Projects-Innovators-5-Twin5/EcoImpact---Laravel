<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<script src="{{ asset('js/profile.js') }}"></script>

<div class="col-10 col-xl-4">
            <div class="row">
             
                <div class="col-12">
                    <form action="{{ route('updateImageProfile') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card card-body border-0 shadow mb-4">
                        <h2 class="h5 mb-4">Select profile photo</h2>
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <!-- Avatar -->
                                <img class="rounded avatar-xl"  id="avatarPreview" src="{{ $user->image ? asset('storage/' . $user->image) : asset('assets/img/team/default_img.png') }}"
                                    alt="change avatar">
                            </div>
                            <div class="file-field">
                                <div class="d-flex justify-content-xl-center ms-xl-3">
                                    <div class="d-flex">
                                        <svg class="icon text-gray-500 me-2" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <input type="file" name="image" id="imageInput" onchange="previewImage(event)">
                                        <div class="d-md-block text-left">
                                            <div class="fw-normal text-dark mb-1">Choose Image</div>
                                            <div class="text-gray small">JPG, GIF or PNG. Max size of 800K</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <button type="submit" class="btn btn-primary mt-3 col-md-4 ms-auto" onclick="updateProfileImage()">Save</button>

                      </form>
                    </div>
                </div>
            
            </div>
               <div class="col-12">
                    <div class="card card-body border-0 shadow mb-4">
                    <ul class="nav flex-column items-center">
                        <li class="nav-item-profile {{ Request::segment(1) == 'dashboard' ? 'active' : '' }}">
                            <a href="/dashboard" class="nav-link">
                            <span class="sidebar-icon"> <i class="fas fa-home" style="font-size:18px;"></i>
                            </span>
                            <span class="sidebar-text">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item-profile {{ Request::segment(1) == 'dashboard' ? 'active' : '' }}">
                            <a href="/dashboard" class="nav-link">
                            <span class="sidebar-icon"><i class="fas fa-lightbulb"></i></span>
                            <span class="sidebar-text"> Energy Consumption</span>
                            </a>
                        </li>
                        <li class="nav-item-profile {{ Request::segment(1) == 'dashboard' ? 'active' : '' }}">
                            <a href="/dashboard" class="nav-link">
                            <span class="sidebar-icon"> <i class="fa-solid fa-cart-shopping"></i></span>
                            <span class="sidebar-text">Order History</span>
                            </a>
                        </li>
                        <li class="nav-item-profile {{ Request::segment(1) == 'dashboard' ? 'active' : '' }}">
                            <a href="/dashboard" class="nav-link">
                            <span class="sidebar-icon"> <i class="fa-solid fa-calendar-week"></i></span>
                            <span class="sidebar-text">Campaign Participation History</span>
                            </a>
                        </li>
                        <li class="nav-item-profile {{ Request::segment(1) == 'dashboard' ? 'active' : '' }}">
                            <a href="/dashboard" class="nav-link">
                            <span class="sidebar-icon"><i class="fa-solid fa-calendar-week"></i></span>
                            <span class="sidebar-text">Challenge Participation History</span>
                            </a>
                        </li>
                        <li class="nav-item-profile {{ Request::segment(1) == 'dashboard' ? 'active' : '' }}">
                            <a href="/dashboard" class="nav-link">
                            <span class="sidebar-icon"> <i class="fa-solid fa-gear"></i></span>
                            <span class="sidebar-text">Profile Settings</span>
                            </a>
                        </li>
                        <li class="nav-item-profile {{ Request::segment(1) == 'dashboard' ? 'active' : '' }}">
                            <a href="/dashboard" class="nav-link">
                            <span class="sidebar-icon"> <i class="fa-solid fa-bell"></i></span>
                            <span class="sidebar-text">Notifications</span>
                            </a>
                        </li>
                        <li class="nav-item-profile {{ Request::segment(1) == 'dashboard' ? 'active' : '' }}">
                            <a href="/dashboard" class="nav-link">
                            <span class="sidebar-icon"><i class="fa-solid fa-right-from-bracket"></i></span>
                            <span class="sidebar-text">Log out</span>
                            </a>
                        </li>
                    </div>
                </div>
        </div>