<link rel="stylesheet" href="{{ asset('css/profile.css') }}">

<div class="col-10 col-xl-4">
            <div class="row">
             
                <div class="col-12">
                    <div class="card card-body border-0 shadow mb-4">
                        <h2 class="h5 mb-4">Select profile photo</h2>
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <!-- Avatar -->
                                <img class="rounded avatar-xl" src="../assets/img/team/profile-picture-1.jpg"
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
                                        <input type="file">
                                        <div class="d-md-block text-left">
                                            <div class="fw-normal text-dark mb-1">Choose Image</div>
                                            <div class="text-gray small">JPG, GIF or PNG. Max size of 800K</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
            </div>
               <div class="col-12">
                    <div class="card card-body border-0 shadow mb-4">
                    <ul class="nav flex-column items-center">
                        <li class="nav-item-profile {{ Request::segment(1) == 'dashboard' ? 'active' : '' }}">
                            <a href="/dashboard" class="nav-link">
                            <span class="sidebar-icon"> <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                                <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                                </svg></span></span>
                            <span class="sidebar-text">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item-profile {{ Request::segment(1) == 'dashboard' ? 'active' : '' }}">
                            <a href="/dashboard" class="nav-link">
                            <span class="sidebar-icon"> <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                                <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                                </svg></span></span>
                            <span class="sidebar-text">Energy Consumption</span>
                            </a>
                        </li>
                        <li class="nav-item-profile {{ Request::segment(1) == 'dashboard' ? 'active' : '' }}">
                            <a href="/dashboard" class="nav-link">
                            <span class="sidebar-icon"> <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                                <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                                </svg></span></span>
                            <span class="sidebar-text">Order History</span>
                            </a>
                        </li>
                        <li class="nav-item-profile {{ Request::segment(1) == 'dashboard' ? 'active' : '' }}">
                            <a href="/dashboard" class="nav-link">
                            <span class="sidebar-icon"> <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                                <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                                </svg></span></span>
                            <span class="sidebar-text">Campaign Participation History</span>
                            </a>
                        </li>
                        <li class="nav-item-profile {{ Request::segment(1) == 'dashboard' ? 'active' : '' }}">
                            <a href="/dashboard" class="nav-link">
                            <span class="sidebar-icon"> <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                                <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                                </svg></span></span>
                            <span class="sidebar-text">Challenge Participation History</span>
                            </a>
                        </li>
                        <li class="nav-item-profile {{ Request::segment(1) == 'dashboard' ? 'active' : '' }}">
                            <a href="/dashboard" class="nav-link">
                            <span class="sidebar-icon"> <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                                <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                                </svg></span></span>
                            <span class="sidebar-text">Profile Settings</span>
                            </a>
                        </li>
                        <li class="nav-item-profile {{ Request::segment(1) == 'dashboard' ? 'active' : '' }}">
                            <a href="/dashboard" class="nav-link">
                            <span class="sidebar-icon"> <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                                <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                                </svg></span></span>
                            <span class="sidebar-text">Notifications</span>
                            </a>
                        </li>
                        <li class="nav-item-profile {{ Request::segment(1) == 'dashboard' ? 'active' : '' }}">
                            <a href="/dashboard" class="nav-link">
                            <span class="sidebar-icon"> <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                                <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                                </svg></span></span>
                            <span class="sidebar-text">Log out</span>
                            </a>
                        </li>
                    </div>
                </div>
        </div>