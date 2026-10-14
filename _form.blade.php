@php $s = $supplier ?? null; @endphp
<div class="mb-3">
    <label class="form-label">Nama Supplier <span class="text-danger">*</span></label>
    <input type="text" name="name" value="{{ old('name', $s?->name) }}" class="form-control @error('name') is-invalid @enderror">
    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="row g-3 mb-3">
    <div class="col-md-6">
        <label class="form-label">Telepon</label>
        <input type="text" name="phone" value="{{ old('phone', $s?->phone) }}" class="form-control">
    </div>
    <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="text" name="email" value="{{ old('email', $s?->email) }}" class="form-control @error('email') is-invalid @enderror">
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>
<div class="mb-3">
    <label class="form-label">Alamat</label>
    <textarea name="address" rows="3" class="form-control">{{ old('address', $s?->address) }}</textarea>
</div>
<button class="btn btn-primary">Simpan</button>
<a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Batal</a>
