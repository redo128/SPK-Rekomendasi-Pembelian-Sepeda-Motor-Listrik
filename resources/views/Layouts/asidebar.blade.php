<ul class="sidebar-nav" id="sidebar-nav">
  <li class="nav-item">
    <a class="nav-link " href="index.html">
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>
    </a>
  </li><!-- End Dashboard Nav -->
  @if(auth()->user()->role=="superadmin")
      <li class="nav-item">
        <a class="nav-link collapsed"  href="{{route('SuperAdmin.bobot')}}">
          <i class="bi bi-person"></i>
          <span>Menentukan Bobot</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('toko.index')}}">
          <i class="bi bi-person"></i>
          <span>Toko</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('brand.index')}}">
          <i class="bi bi-person"></i>
          <span>Brand</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('kriteria.index')}}">
          <i class="bi bi-person"></i>
          <span>Kriteria</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('kriteriaperbandingan.index')}}">
          <i class="bi bi-person"></i>
          <span>Perbandingan Kriteria</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('sepeda_sa.index')}}">
          <i class="bi bi-person"></i>
          <span>Sepeda Listrik</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('Sa.perhitungan')}}">
          <i class="bi bi-person"></i>
          <span>Perhitungan</span>
        </a>
      </li>
      @endif
      @if(auth()->user()->role=="pembeli")
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('preferensi_kriteria')}}">
          <i class="bi bi-person"></i>
          <span>Preferensi Kriteria</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('sepeda_pembeli.index')}}">
          <i class="bi bi-person"></i>
          <span>List Sepeda Listrik</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('list_antrian')}}">
          <i class="bi bi-person"></i>
          <span>List Antrian</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('perhitungan_pembeli',auth()->user()->id)}}">
          <i class="bi bi-person"></i>
          <span>Perhitungan</span>
        </a>
      </li>
      @endif
      @if(auth()->user()->role=="penjual")
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('sepeda_penjual.index')}}">
          <i class="bi bi-person"></i>
          <span>List Sepeda Listrik </span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('sepeda_pembeli.index')}}">
          <i class="bi bi-person"></i>
          <span>Sepeda yang banyak dibandingkan </span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('list_antrian')}}">
          <i class="bi bi-person"></i>
          <span>List Sub Admin</span>
        </a>
      </li>

      @endif
    </ul>
