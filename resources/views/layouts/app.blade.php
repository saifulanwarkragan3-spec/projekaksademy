{{--
  Layout utama (master layout): kerangka HTML untuk semua halaman setelah login (header, sidebar, isi, footer).
  Halaman lain memakainya dengan @extends('layouts.app'), lalu mengisi bagian @yield lewat @section.
  Tema tampilan: AdminLTE 4 (template admin berbasis Bootstrap 5).
--}}
<!doctype html>
<html lang="id" data-bs-theme="light" data-lte-color-mode="off">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    {{-- config('app.name'): mengambil nama aplikasi dari config/app.php (nilai APP_NAME di file .env) --}}
    {{-- @yield('title'): "slot kosong" yang nanti diisi oleh @section('title', ...) di halaman anak --}}
    <title>{{ config('app.name') }} | @yield('title')</title>

    {{-- CDN (Content Delivery Network): file CSS diambil dari internet, bukan dari folder project --}}
    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" crossorigin="anonymous" />
    {{-- asset(): membuat URL lengkap ke file di folder public/, contoh http://localhost/adminlte/css/adminlte.min.css --}}
    <!-- AdminLTE -->
    <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.min.css') }}" />
    <style>
      :root { --inventory-ink: #25312f; --inventory-muted: #75817d; --inventory-line: #e4e9e6; --inventory-green: #147a69; }
      body { color: var(--inventory-ink); background: #f3f6f4 !important; }
      .app-main { background: #f3f6f4; }
      .app-content-header { padding-bottom: .25rem; }
      .app-content-header h1 { color: var(--inventory-ink); font-weight: 650; }
      .app-sidebar { background: #20332f !important; }
      .sidebar-brand { height: 4.5rem; }
      .brand-mark { display: grid; place-items: center; width: 2rem; height: 2rem; color: #d9f4ed; background: #287868; border-radius: 6px; }
      .sidebar-menu .nav-link.active { background: #31554c !important; }
      .card { border: 1px solid var(--inventory-line); border-radius: 6px; box-shadow: none; }
      .card-header, .card-footer { background: #fff; border-color: var(--inventory-line); }
      .metric-card { min-height: 132px; border-left: 4px solid var(--metric-color); }
      .metric-label { color: var(--inventory-muted); font-size: .83rem; font-weight: 600; }
      .metric-value { color: var(--inventory-ink); font-size: 1.85rem; font-weight: 700; line-height: 1.1; }
      .metric-icon { display: grid; place-items: center; width: 2.6rem; height: 2.6rem; color: var(--metric-color); background: var(--metric-soft); border-radius: 6px; font-size: 1.2rem; }
      .table thead th { color: #687570; background: #f7f9f8; font-size: .76rem; font-weight: 700; text-transform: uppercase; }
      .table td, .table th { padding: .8rem .75rem; vertical-align: middle; }
      .form-label { color: #3c4945; font-weight: 600; }
      .btn-primary { --bs-btn-bg: #147a69; --bs-btn-border-color: #147a69; --bs-btn-hover-bg: #106555; --bs-btn-hover-border-color: #106555; }
      .text-inventory { color: var(--inventory-green) !important; }
      .stock-low { color: #a34d13; background: #fff1df; }
      .stock-ok { color: #16725f; background: #e4f4ee; }
      .movement-in { color: #16725f; background: #e4f4ee; }
      .movement-out { color: #a34d13; background: #fff1df; }
      .status-pill { display: inline-block; padding: .25rem .55rem; border-radius: 999px; font-size: .75rem; font-weight: 650; }
      .table-actions { white-space: nowrap; }
      @media (max-width: 575.98px) { .app-content-header h1 { font-size: 1.35rem !important; } .table td, .table th { padding: .65rem .5rem; } }
    </style>
  </head>
  {{-- class body AdminLTE: layout-fixed = header/sidebar diam saat scroll, sidebar-expand-lg = sidebar terbuka di layar besar --}}
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    {{-- app-wrapper: pembungkus utama struktur AdminLTE (header, sidebar, main, footer) --}}
    <div class="app-wrapper">

      {{-- @include: menyisipkan file Blade lain (partial) di sini; titik "." = pemisah folder --}}
      {{-- 'layouts.partials.header' = resources/views/layouts/partials/header.blade.php --}}
      @include('layouts.partials.header')

      {{-- @include sidebar: menu navigasi di sisi kiri --}}
      @include('layouts.partials.sidebar')

      {{-- app-main: area konten utama AdminLTE (di sebelah kanan sidebar) --}}
      <!--begin::App Main-->
      <main class="app-main">
        {{-- app-content-header: judul halaman; @yield('title') dipakai lagi di sini --}}
        <div class="app-content-header">
          <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between gap-3">
              <div>
                <h1 class="mb-0 fs-3">@yield('title')</h1>
                @hasSection('page_description')
                  <p class="mb-0 mt-1 text-body-secondary">@yield('page_description')</p>
                @endif
              </div>
              @yield('page_action')
            </div>
          </div>
        </div>
        <div class="app-content">
          <div class="container-fluid">

            {{-- Pesan sukses / error dari controller --}}
            {{-- session('success'): flash message, dikirim controller lewat ->with('success', '...'); hanya muncul 1x setelah redirect --}}
            {{-- @if / @endif: blok ini hanya ditampilkan jika kondisinya bernilai true (ada pesan) --}}
            @if (session('success'))
              {{-- alert Bootstrap: kotak pesan hijau yang bisa ditutup dengan tombol X (data-bs-dismiss="alert") --}}
              <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            @endif
            {{-- session('error'): sama seperti di atas, tapi untuk pesan gagal (kotak merah) --}}
            @if (session('error'))
              <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            @endif
            @if ($errors->any())
              <div class="alert alert-danger alert-dismissible fade show">
                <div class="fw-semibold">Periksa kembali data yang dimasukkan.</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
              </div>
            @endif

            {{-- Isi halaman --}}
            {{-- @yield('content'): tempat isi @section('content') ... @endsection dari halaman anak dimasukkan --}}
            @yield('content')

          </div>
        </div>
      </main>
      <!--end::App Main-->

      {{-- @include footer: bagian bawah halaman (copyright) --}}
      @include('layouts.partials.footer')

    </div>

    {{-- Script JavaScript ditaruh di akhir body agar halaman tampil dulu sebelum script dimuat --}}
    {{-- Popper (untuk posisi dropdown) & Bootstrap JS dari CDN, lalu AdminLTE JS dari folder public/ lewat asset() --}}
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('adminlte/css/adminlte.min.js') }}"></script>
  </body>
</html>