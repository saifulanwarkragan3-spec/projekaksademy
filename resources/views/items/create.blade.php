@extends('layouts.app')

@section('title', 'Tambah Barang')
@section('page_description', 'Daftarkan barang baru. Stok awal dimulai dari nol; catat penambahan melalui transaksi masuk.')

@section('content')
  <div class="card" style="max-width: 58rem">
    <form action="{{ route('items.store') }}" method="POST">
      @csrf
      @include('items._form')
      <div class="card-footer d-flex gap-2">
        <button type="submit" class="btn btn-primary"><i class="bi bi-check2 me-1"></i> Simpan barang</button>
        <a href="{{ route('items.index') }}" class="btn btn-light">Batal</a>
      </div>
    </form>
  </div>
@endsection