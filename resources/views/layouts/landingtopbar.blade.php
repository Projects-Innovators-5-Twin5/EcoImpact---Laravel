<link rel="stylesheet" href="{{ asset('css/landing.css') }}">

<div class="nav-content" style="    position: sticky;
    top: 0;
    z-index: 1005;
    background: #f2f4f6;
}">

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="/assets/img/landing/logo1.png" alt="logo" class="logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>


        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/landing">Home</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="/liste-consommations">Consumption</a>
                </li>

                <li class="nav-item">
                <a class="nav-link" href="/campaigns/front">Campaigns</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="/challengesfront">Challenges</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="/front/articles" aria-disabled="true">Blog</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="/produitss" aria-disabled="true">Store</a>
                </li>
            </ul>
        </div>
<div>
        @if (Auth::check()) 
  <li class="nav-item dropdown ms-lg-3">
    <a class="nav-link dropdown-toggle pt-1 px-0" href="#" role="button" data-bs-toggle="dropdown"
       aria-expanded="false">
      <div class="media d-flex align-items-center">
        <img class="avatar rounded-circle" alt="Image placeholder" src="/assets/img/team/profile-picture-1.jpg">
        <span style="color:black;font-size:15px;margin-left:10px;">
          {{ Auth::user()->name }} <!-- Display the user's name -->
        </span>
      </div>
    </a>

    <div class="dropdown-menu dashboard-dropdown dropdown-menu-end mt-2 py-1">
      <a class="dropdown-item d-flex align-items-center" href="/profile">
        <svg class="dropdown-icon text-gray-400 me-2" fill="currentColor" viewBox="0 0 20 20"
             xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
                clip-rule="evenodd"></path>
        </svg>
        My Profile
      </a>
      
      <div role="separator" class="dropdown-divider my-1"></div>
      <a class="dropdown-item d-flex align-items-center" href="#" id="logout-link">
        <svg class="dropdown-icon text-danger me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
        </svg>
        Log out
      </a>

      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>

      <script>
        document.getElementById('logout-link').addEventListener('click', function (event) {
          event.preventDefault(); // Prevent the default anchor click behavior
          document.getElementById('logout-form').submit(); // Submit the form
        });
      </script>
    </div>
  </li>
@else
  <!-- Show Login/Register button if not signed in -->
  <li class="nav-item ms-lg-3">
    <button class="btn btn-outline-secondary" type="button">
      <a href="/login" class="text-btn">Login/Register</a>
    </button>
  </li>
@endif


</div>

    </div>
    </nav>
</div>