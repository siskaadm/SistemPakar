<header id="header" class="fixed-top">
    <nav class="navbar navbar-expand-lg">
        <div class="container d-flex align-items-center justify-content-between">
            <div class="logo">
                <h1><a href="/">Cek Motor Vario</a></h1>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ setActive('beranda') }}" href="/">Beranda</a></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ setActive('panduan') }}" href="/#values">Panduan</a></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ setActive('page.data') }}" href="{{ route('page.data') }}">Data</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ setActive('page.diagnosa') }}" href="{{ route('page.diagnosa') }}">Diagnosa</a>
                    </li>
                    @if (auth()->check())
                        <li class="nav-item">
                            <div class="dropdown">
                                <a href="javascript:void(0)" id="dropdownProfile" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <img src="img/user.png" alt="" width="30"
                                        class="mx-2">{{ Auth::user()->username }}
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownProfile">
                                    <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}">Log out</a></li>
                                </ul>
                            </div>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                    @endif
                    
                </ul>
            </div>
        </div>
    </nav>
</header><!-- End Header -->
