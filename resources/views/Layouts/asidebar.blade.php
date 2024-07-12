<ul class="sidebar-nav" id="sidebar-nav">
  <!-- End Dashboard Nav -->
  @if(auth()->user()->role=="superadmin")
  <li class="nav-item">
    <a class="nav-link " href="{{route('Dashboard')}}">
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>
    </a>
  </li>
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
        <a class="nav-link collapsed" href="{{route('SuperAdmin.sub.admin')}}">
          <i class="bi bi-person"></i>
          <span>Sub Admin Toko</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-layout-text-window-reverse"></i><span>Perhitungan</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('sa.perhitungan.sepeda.listrik')}}">
              <i class="bi bi-circle"></i><span>Sepeda Listrik</span>
            </a>
          </li>
          <li>
            <a href="{{route('sa.perhitungan.sepeda.motor.listrik')}}">
              <i class="bi bi-circle"></i><span>Sepeda Motor Listrik</span>
            </a>
          </li>
        </ul>
      </li>
      @endif
      @if(auth()->user()->role=="pembeli")
      <li class="nav-item">
      <a class="nav-link " href="{{route('pembeli.index')}}">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('preferensi_kriteria')}}">
          <i class="bi bi-person"></i>
          <span>Preferensi Kriteria</span>
        </a>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('sepeda_pembeli.index')}}">
          <i class="bi bi-person"></i>
          <span>List Sepeda Listrik</span>
        </a>
      </li> -->
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#" aria-expanded="false">
          <i class="bi bi-bar-chart"></i><span>List Sepeda</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('list_sepeda_listrik')}}">
              <i class="bi bi-circle"></i><span>Sepeda Listrik</span>
            </a>
          </li>
          <li>
            <a href="{{route('list_sepeda_motor_listrik')}}">
              <i class="bi bi-circle"></i><span>Sepeda Motor Listrik</span>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('list_antrian')}}">
          <i class="bi bi-person"></i>
          <span>List Antrian</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" hidden href="{{route('perhitungan_pembeli',auth()->user()->id)}}">
          <i class="bi bi-person"></i>
          <span>Perhitungan</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-layout-text-window-reverse"></i><span>Perhitungan</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('pembeli.perhitungan.sepeda.listrik')}}">
              <i class="bi bi-circle"></i><span>Sepeda Listrik</span>
            </a>
          </li>
          <li>
            <a href="{{route('pembeli.perhitungan.sepeda.motor.listrik')}}">
              <i class="bi bi-circle"></i><span>Sepeda Motor Listrik</span>
            </a>
          </li>
        </ul>
      </li>
      @endif
      @if(auth()->user()->role=="penjual")
      <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('sepeda_penjual.index')}}">
          <i class="bi bi-person"></i>
          <span>List Sepeda Listrik </span>
        </a>
      </li> -->
      <li class="nav-item">
    <a class="nav-link " href="{{route('penjual.index')}}">
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>
    </a>
  </li>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#" aria-expanded="false">
          <i class="bi bi-bar-chart"></i><span>List Sepeda</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('penjual.sepeda.listrik')}}">
              <i class="bi bi-circle"></i><span>Sepeda Listrik</span>
            </a>
          </li>
          <li>
            <a href="{{route('penjual.list.sepeda.motor.listrik')}}">
              <i class="bi bi-circle"></i><span>Sepeda Motor Listrik</span>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('penjual.wishlist.pebeli')}}">
          <i class="bi bi-person"></i>
          <span>Sepeda yang banyak diinginkan </span>
        </a>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('list_antrian')}}">
          <i class="bi bi-person"></i>
          <span>List Sub Admin</span>
        </a>
      </li> -->

      @endif
    </ul>
