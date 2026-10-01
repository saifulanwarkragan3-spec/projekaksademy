@extends('layouts.app')

@section('title', 'Barang')
@section('page_description', 'Kelola katalog dan pantau ketersediaan barang.')
@section('page_action')
  <a href="{{ route('items.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Tambah barang</a>
@endsection

@section('content')
  <section class="card">
    <div class="card-body border-bottom" style="border-color:var(--inventory-line)!important">
      <form action="{{ route('items.index') }}" method="GET" class="row g-2 align-items-end">
        <div class="col-12 col-md-5">
          <label for="search" class="form-label small">Cari barang</label>
          <div class="input-group">
            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
            <input id="search" name="search" value="{{ $search }}" class="form-control" placeholder="Nama atau kode barang" />
          </div>
        </div>
        <div class="col-12 col-md-4">
          <label for="category_id" class="form-label small">Kategori</label>
          <select id="category_id" name="category_id" class="form-select">
            <option value="0">Semua kategori</option>
            @foreach ($categories as $category)
              <option value="{{ $category->id }}" @selected($categoryId === $category->id)>{{ $category->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-12 col-md-auto d-flex gap-2">
          <button class="btn btn-outline-secondary" type="submit">Filter</button>
          <a href="{{ route('items.index') }}" class="btn btn-light">Reset</a>
        </div>
      </form>
    </div>
    <div class="table-responsive">
      <table class="table mb-0">
        <thead><tr><th>Barang</th><th>Kategori</th><th>Stok</th><th>Status</th><th class="text-end">Aksi</th></tr></thead>
        <tbody>
          @forelse ($items as $item)
            <tr>
              <td><div class="fw-semibold">{{ $item->name }}</div><div class="small text-body-secondary">{{ $item->code }} · {{ $item->unit }}</div></td>
              <td>{{ $item->category->name }}</td>
              <td class="fw-semibold">{{ number_format($item->stock) }} <span class="fw-normal text-body-secondary">{{ $item->unit }}</span><div class="small text-body-secondary">Min. {{ $item->min_stock }}</div></td>
              <td><span class="status-pill {{ $item->isLowStock() ? 'stock-low' : 'stock-ok' }}">{{ $item->isLowStock() ? 'Perlu restok' : 'Tersedia' }}</span></td>
              <td class="text-end table-actions">
                <a href="{{ route('items.edit', $item) }}" class="btn btn-sm btn-light" aria-label="Edit {{ $item->name }}" title="Edit"><i class="bi bi-pencil"></i></a>
                <form action="{{ route('items.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus barang ini?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-light text-danger" aria-label="Hapus {{ $item->name }}" title="Hapus"><i class="bi bi-trash"></i></button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="5" class="text-center text-body-secondary py-5">Belum ada barang yang cocok dengan filter ini.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if ($items->hasPages())
      <div class="card-footer">{{ $items->links() }}</div>
    @endif
  </section>
@endsection