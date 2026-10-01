<div class="card-body">
  <div class="row g-3">
    <div class="col-md-6">
      <label for="name" class="form-label">Nama barang</label>
      <input id="name" name="name" value="{{ old('name', $item->name) }}" class="form-control @error('name') is-invalid @enderror" required />
      @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
      <label for="code" class="form-label">Kode barang</label>
      <input id="code" name="code" value="{{ old('code', $item->code) }}" class="form-control @error('code') is-invalid @enderror" required />
      @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
      <label for="category_id" class="form-label">Kategori</label>
      <select id="category_id" name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
        <option value="">Pilih kategori</option>
        @foreach ($categories as $category)
          <option value="{{ $category->id }}" @selected(old('category_id', $item->category_id) == $category->id)>{{ $category->name }}</option>
        @endforeach
      </select>
      @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-3">
      <label for="unit" class="form-label">Satuan</label>
      <input id="unit" name="unit" value="{{ old('unit', $item->unit) }}" placeholder="pcs, box, kg" class="form-control @error('unit') is-invalid @enderror" required />
      @error('unit')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-3">
      <label for="min_stock" class="form-label">Batas stok minimum</label>
      <input id="min_stock" name="min_stock" type="number" min="0" value="{{ old('min_stock', $item->min_stock ?? 0) }}" class="form-control @error('min_stock') is-invalid @enderror" required />
      @error('min_stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12">
      <label for="description" class="form-label">Deskripsi <span class="fw-normal text-body-secondary">(opsional)</span></label>
      <textarea id="description" name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $item->description) }}</textarea>
      @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
  </div>
</div>