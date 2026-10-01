@extends('layouts.app')

@section('title', 'Edit Barang')
@section('page_description', 'Perbarui identitas dan batas stok barang.')

@section('content')
  <div class="card" style="max-width: 58rem">
    <form action="{{ route('items.update', $item) }}" method="POST">
      @csrf
      @method('PUT')
      @include('items._form')
      <div class="card-footer d-flex gap-2">
        <button type="submit" class="btn btn-primary"><i class="bi bi-check2 me-1"></i> Simpan perubahan</button>
        <a href="{{ route('items.index') }}" class="btn btn-light">Batal</a>
      </div>
    </form>
  </div>
@endsection