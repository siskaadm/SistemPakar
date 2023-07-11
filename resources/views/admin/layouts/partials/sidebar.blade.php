<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="{{asset('AdminLTE/dist')}}/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Sistem Pakar Vario 125</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="/" class="d-block">Selamat datang, {{ auth()->user()->level}} </a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
              with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Data Pakar
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('gejala.index')}}" class="nav-link {{ $elementActive === 'gejala' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Gejala</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('kerusakan.index')}}" class="nav-link {{ $elementActive === 'kerusakan' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Kerusakan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('kategori.index')}}" class="nav-link {{ $elementActive === 'kategori' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Kategori</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('rekomendasisolusi.index')}}" class="nav-link {{ $elementActive === 'rekomendasisolusi' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Solusi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('aturan.index') }}" class="nav-link {{ $elementActive === 'aturan' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Aturan</p>
                </a>
              </li>
            </ul>
          </li>

        @if (auth()->user()->level == 'admin')
          <li class="nav-item">
            <a href="{{ route('laporan.index') }}" class="nav-link {{ $elementActive == 'laporan' ? 'active' : '' }}">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Data Laporan
              </p>
            </a>
          </li>

          {{-- @role('super_admin') --}}
        {{-- User --}}
        <li class="nav-item">
          <a href="{{ route('user.index') }}" class="nav-link {{ $elementActive == 'user' ? 'active' : '' }}">
            <i class="nav-icon fas fa-user"></i>
            <p>
              Data User
            </p>
          </a>
        </li>
        @endif
        {{-- User --}}
        {{-- @endrole --}}

        {{-- Logout --}}
        <li class="nav-item">
          <a href="{{ route('logout') }}" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>
              Logout
            </p>
          </a>
        </li>
  </aside>