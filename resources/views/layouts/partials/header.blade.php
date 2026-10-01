{{--
  Partial header: navbar di bagian atas halaman. Bukan halaman sendiri, tapi potongan (partial)
  yang disisipkan ke layouts/app.blade.php lewat @include('layouts.partials.header').
--}}
<!--begin::Header-->
{{-- app-header navbar: komponen navbar Bootstrap/AdminLTE --}}
<nav class="app-header navbar navbar-expand bg-body">
  <div class="container-fluid">
    <!-- Tombol buka/tutup sidebar -->
    {{-- data-lte-toggle="sidebar": atribut AdminLTE, saat diklik JS AdminLTE membuka/menutup sidebar --}}
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button" aria-label="Toggle sidebar">
          {{-- <i class="bi bi-...">: ikon dari Bootstrap Icons --}}
          <i class="bi bi-list"></i>
        </a>
      </li>
    </ul>

    <div class="navbar-nav ms-auto d-flex flex-row align-items-center gap-2 text-body-secondary small">
      <i class="bi bi-calendar3"></i>
      <span>{{ now()->translatedFormat('l, d F Y') }}</span>
    </div>
  </div>
</nav>
<!--end::Header-->