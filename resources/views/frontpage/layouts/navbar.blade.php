<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
      <a class="navbar-brand" href="index.html">Damar <span>Motorbike Rental</span></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="oi oi-menu"></span> Menu
      </button>

      <div class="collapse navbar-collapse" id="ftco-nav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item {{ ($active === "Home") ? 'active' : '' }}"><a href="/" class="nav-link ">Home</a></li>
          <li class="nav-item {{ ($active === "About") ? 'active' : '' }}"><a href="/about" class="nav-link">About</a></li>
          <li class="nav-item {{ ($active === "Motor") ? 'active' : '' }}"><a href="/view-motor" class="nav-link">Motors</a></li>
          <li class="nav-item {{ ($active === "Contact") ? 'active' : '' }}"><a href="/contact" class="nav-link">Contact</a></li>
          <li class="nav-item {{ ($active === "Login") ? 'active' : '' }}">
              <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ ($active === "Profile") ? 'active' : '' }}" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">@if (Auth::check())
                        {{ Auth::user()->nama_pegawai }}
                    @endif<i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        @if (Route::has('login'))
                            @auth
                                <li><a class="dropdown-item" href="/dashboard">Dashboard</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <form method="POST" action="{{ route('logout') }}">
                                  @csrf
                                  <li><a class="dropdown-item" href="route('logout')"
                                  onclick="event.preventDefault();
                                              this.closest('form').submit();">Logout</a></li>
                                </form>
                            @else
                              <li><a class="dropdown-item" href="/login">Login</a></li>
                            @endauth
                        @endif
                    </ul>
                </li>
            </ul>
          </a>
          </li>
            
        </ul>
      </div>
    </div>
</nav>