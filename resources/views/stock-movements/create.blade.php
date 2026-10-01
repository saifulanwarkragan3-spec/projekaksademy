@extends('layouts.app')

@section('title', 'Catat Transaksi Stok')
@section('page_description', 'Setiap transaksi akan memperbarui stok dan tersimpan di riwayat.')

@section('content')
  <div class="card" style="max-width: 46rem">
    <form action="{{ route('stock-movements.store') }}" method="POST">
      @csrf
      <div class="card-body">
        <div class="mb-3">
          <label class="form-label d-block">Jenis transaksi</label>
          <div class="btn-group" role="group" aria-label="Jenis transaksi">
            <input type="radio" class="btn-check" name="type" id="type-in" value="in" @checked(old('type', 'in') === 'in') />
            <label class="btn btn-outline-success" for="type-in"><i class="bi bi-box-arrow-in-down me-1"></i> Barang masuk</label>
            <input type="radio" class="btn-check" name="type" id="type-out" value="out" @checked(old('type') === 'out') />
            <label class="btn btn-outline-warning" for="type-out"><i class="bi bi-box-arrow-up me-1"></i> Barang keluar</label>
          </div>
          @error('type')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
          <label for="item_id" class="form-label">Barang</label>
          <select id="item_id" name="item_id" class="form-select @error('item_id') is-invalid @enderror" required>
            <option value="">Pilih barang</option>
            @foreach ($items as $item)
              <option value="{{ $item->id }}" @selected(old('item_id') == $item->id)>{{ $item->name }} ({{ $item->code }}) · stok {{ $item->stock }} {{ $item->unit }}</option>
            @endforeach
          </select>
          @error('item_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
          @if ($items->isEmpty())<div class="form-text">Tambahkan barang terlebih dahulu sebelum mencatat transaksi.</div>@endif
        </div>
        <div class="row g-3">
          <div class="col-sm-6">
            <label for="quantity" class="form-label">Jumlah</label>
            <input id="quantity" name="quantity" type="number" min="1" value="{{ old('quantity', 1) }}" class="form-control @error('quantity') is-invalid @enderror" required />
            @error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-sm-6">
            <label for="moved_at" class="form-label">Tanggal</label>
            <input id="moved_at" name="moved_at" type="date" value="{{ old('moved_at', now()->toDateString()) }}" class="form-control @error('moved_at') is-invalid @enderror" required />
            @error('moved_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>
        <div class="mt-3">
          <label for="note" class="form-label">Catatan <span class="fw-normal text-body-secondary">(opsional)</span></label>
          <input id="note" name="note" value="{{ old('note') }}" maxlength="255" class="form-control @error('note') is-invalid @enderror" placeholder="Contoh: pembelian atau pemakaian" />
          @error('note')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
      </div>
      <div class="card-footer d-flex gap-2">
        <button type="submit" class="btn btn-primary" @disabled($items->isEmpty())><i class="bi bi-check2 me-1"></i> Simpan transaksi</button>
        <a href="{{ route('stock-movements.index') }}" class="btn btn-light">Batal</a>
      </div>
    </form>
  </div>
@endsection