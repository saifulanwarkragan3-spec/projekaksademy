@extends('layouts.app')

@section('title', 'Ringkasan Inventori')
@section('page_description', 'Pantau persediaan dan aktivitas stok terbaru.')
@section('page_action')
  <a href="{{ route('stock-movements.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Catat transaksi</a>
@endsection

@section('content')
  <div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
      <div class="card metric-card h-100" style="--metric-color:#147a69;--metric-soft:#e4f4ee">
        <div class="card-body d-flex align-items-center justify-content-between">
          <div><div class="metric-label mb-2">Jenis barang</div><div class="metric-value">{{ number_format($metrics['items']) }}</div></div>
          <span class="metric-icon"><i class="bi bi-box-seam"></i></span>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
      <div class="card metric-card h-100" style="--metric-color:#2574a8;--metric-soft:#e7f2f8">
        <div class="card-body d-flex align-items-center justify-content-between">
          <div><div class="metric-label mb-2">Total unit stok</div><div class="metric-value">{{ number_format($metrics['stock']) }}</div></div>
          <span class="metric-icon"><i class="bi bi-stack"></i></span>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
      <div class="card metric-card h-100" style="--metric-color:#b66a1b;--metric-soft:#fff1df">
        <div class="card-body d-flex align-items-center justify-content-between">
          <div><div class="metric-label mb-2">Perlu restok</div><div class="metric-value">{{ number_format($metrics['lowStock']) }}</div></div>
          <span class="metric-icon"><i class="bi bi-exclamation-triangle"></i></span>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
      <div class="card metric-card h-100" style="--metric-color:#6c6195;--metric-soft:#efedf7">
        <div class="card-body d-flex align-items-center justify-content-between">
          <div><div class="metric-label mb-2">Kategori</div><div class="metric-value">{{ number_format($metrics['categories']) }}</div></div>
          <span class="metric-icon"><i class="bi bi-tags"></i></span>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-3">
    <div class="col-12 col-xl-5">
      <section class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h2 class="h6 mb-0 fw-bold">Stok perlu diperhatikan</h2>
          <a href="{{ route('items.index', ['stock' => 'low']) }}" class="small text-inventory">Lihat semua</a>
        </div>
        <div class="table-responsive">
          <table class="table mb-0">
            <thead><tr><th>Barang</th><th class="text-end">Stok</th></tr></thead>
            <tbody>
              @forelse ($lowStockItems as $item)
                <tr>
                  <td><div class="fw-semibold">{{ $item->name }}</div><div class="small text-body-secondary">{{ $item->code }} · {{ $item->category->name }}</div></td>
                  <td class="text-end"><span class="status-pill stock-low">{{ $item->stock }} / min. {{ $item->min_stock }} {{ $item->unit }}</span></td>
                </tr>
              @empty
                <tr><td colspan="2" class="text-center text-body-secondary py-4">Semua stok berada di atas batas minimum.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </section>
    </div>
    <div class="col-12 col-xl-7">
      <section class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h2 class="h6 mb-0 fw-bold">Aktivitas stok terbaru</h2>
          <a href="{{ route('stock-movements.index') }}" class="small text-inventory">Semua transaksi</a>
        </div>
        <div class="table-responsive">
          <table class="table mb-0">
            <thead><tr><th>Tanggal</th><th>Barang</th><th>Jenis</th><th class="text-end">Jumlah</th></tr></thead>
            <tbody>
              @forelse ($recentMovements as $movement)
                <tr>
                  <td class="text-nowrap">{{ $movement->moved_at->format('d M Y') }}</td>
                  <td><div class="fw-semibold">{{ $movement->item->name }}</div><div class="small text-body-secondary">{{ $movement->item->code }}</div></td>
                  <td><span class="status-pill movement-{{ $movement->type }}">{{ $movement->type === 'in' ? 'Masuk' : 'Keluar' }}</span></td>
                  <td class="text-end fw-semibold">{{ $movement->quantity }} {{ $movement->item->unit }}</td>
                </tr>
              @empty
                <tr><td colspan="4" class="text-center text-body-secondary py-4">Belum ada transaksi stok.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </section>
    </div>
  </div>
@endsection