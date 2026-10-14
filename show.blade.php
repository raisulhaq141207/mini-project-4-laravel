@extends('layouts.app')
@section('title', $product->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Detail Produk</h3>
    <div>
        <a href="{{ route('products.edit', $product) }}" class="btn btn-outline-primary">Edit</a>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>

<div class="card"><div class="card-body">
    <dl class="row mb-0">
        <dt class="col-sm-3">SKU</dt><dd class="col-sm-9">{{ $product->sku }}</dd>
        <dt class="col-sm-3">Nama</dt><dd class="col-sm-9">{{ $product->name }}</dd>
        <dt class="col-sm-3">Kategori</dt><dd class="col-sm-9">{{ $product->category->name }}</dd>
        <dt class="col-sm-3">Supplier</dt><dd class="col-sm-9">{{ $product->supplier->name ?? '-' }}</dd>
        <dt class="col-sm-3">Harga</dt><dd class="col-sm-9">Rp {{ number_format($product->price, 0, ',', '.') }}</dd>
        <dt class="col-sm-3">Stok</dt>
        <dd class="col-sm-9">
            {{ $product->stock }}
            @if ($product->isLowStock()) <span class="badge bg-danger">Stok menipis</span> @endif
        </dd>
        <dt class="col-sm-3">Stok Minimum</dt><dd class="col-sm-9">{{ $product->min_stock }}</dd>
        <dt class="col-sm-3">Deskripsi</dt><dd class="col-sm-9">{{ $product->description ?: '-' }}</dd>
    </dl>
</div></div>
@endsection
