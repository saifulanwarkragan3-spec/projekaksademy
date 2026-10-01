@extends('layouts.app')

@section('title', 'Transaksi Stok')
@section('page_description', 'Riwayat barang masuk dan keluar tercatat untuk setiap perubahan stok.')
@section('page_action')
  <a href="{{ route('stock-movements.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Catat transaksi</a>
@endsection

@section('content')
  <section class="card">
    <div class="card-body border-bottom" style="border-color:var(--inventory-line)!important">
      <form action="{{ route('stock-movements.index') }}" method="GET" class="row g-2 align-items-end">
        <div class="col-12 col-md-5">
          <label for="search" class="form-label small">Cari barang</label>
          <input id="search" name="search" value="{{ $search }}" class="form-control" placeholder="Nama atau kode barang" />
        </div>
        <div class="col-12 col-md-3">
          <label for="type" class="form-label small">Jenis transaksi</label>
          <select id="type" name="type" class="form-select">
            <option value="">Semua jenis</option>
            <option value="in" @selected($type === 'in')>Barang masuk</option>
            <option value="out" @selected($type === 'out')>Barang keluar</option>
          </select>
        </div>
        <div class="col-auto d-flex gap-2">
          <button class="btn btn-outline-secondary" type="submit">Filter</button>
          <a href="{{ route('stock-movements.index') }}" class="btn btn-light">Reset</a>
        </div>
      </form>
    </div>
    <div class="table-responsive">
      <table class="table mb-0">
        <thead><tr><th>Tanggal</th><th>Barang</th><th>Jenis</th><th>Catatan</th><th class="text-end">Jumlah</th></tr></thead>
        <tbody>
          @forelse ($movements as $movement)
            <tr>
              <td class="text-nowrap">{{ $movement->moved_at->format('d M Y') }}</td>
              <td><div class="fw-semibold">{{ $movement->item->name }}</div><div class="small text-body-secondary">{{ $movement->item->code }}</div></td>
              <td><span class="status-pill movement-{{ $movement->type }}">{{ $movement->type === 'in' ? 'Masuk' : 'Keluar' }}</span></td>
              <td>{{ $movement->note ?: '—' }}</td>
              <td class="text-end fw-semibold">{{ number_format($movement->quantity) }} {{ $movement->item->unit }}</td>
            </tr>
          @empty
            <tr><td colspan="5" class="text-center text-body-secondary py-5">Belum ada transaksi stok.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if ($movements->hasPages())
      <div class="card-footer">{{ $movements->links() }}</div>
    @endif
  </section>
@endsection