{{--
  Partial sidebar: menu navigasi di sisi kiri, disisipkan ke layouts/app.blade.php lewat @include('layouts.partials.sidebar').
--}}
<!--begin::Sidebar-->
{{-- app-sidebar: komponen sidebar AdminLTE; data-bs-theme="dark" membuat sidebar berwarna gelap --}}
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
  {{-- sidebar-brand: logo + nama aplikasi di atas sidebar --}}
  <div class="sidebar-brand">
    <a href="{{ route('dashboard') }}" class="brand-link d-flex align-items-center gap-2">
      <span class="brand-mark"><i class="bi bi-box-seam"></i></span>
      <span class="brand-text fw-semibold">{{ config('app.name') }}</span>
    </a>
  </div>
  <div class="sidebar-wrapper">
    <nav class="mt-2" aria-label="Main navigation">
      {{-- sidebar-menu: daftar menu; data-lte-toggle="treeview" = fitur AdminLTE untuk menu bertingkat --}}
      <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" id="navigation">
        <li class="nav-item">
          <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="nav-icon bi bi-grid-1x2"></i><p>Ringkasan</p>
          </a>
        </li>

        <li class="nav-header">INVENTORI</li>
        <li class="nav-item">
          <a href="{{ route('items.index') }}" class="nav-link {{ request()->routeIs('items.*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-box-seam"></i><p>Barang</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('stock-movements.index') }}" class="nav-link {{ request()->routeIs('stock-movements.*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-arrow-left-right"></i><p>Transaksi Stok</p>
          </a>
        </li>
        <li class="nav-header">MASTER DATA</li>
        <li class="nav-item">
          <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-tags"></i><p>Kategori</p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>
<!--end::Sidebar-->