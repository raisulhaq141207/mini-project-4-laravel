@extends('layouts.app')

@section('content')
<h3 class="mb-4">Dashboard</h3>

<div class="row g-3 mb-4">
    @foreach ([
        ['Total Produk', $totalProducts, 'primary'],
        ['Kategori', $totalCategories, 'success'],
        ['Supplier', $totalSuppliers, 'warning'],
        ['Nilai Stok', 'Rp ' . number_format($totalValue, 0, ',', '.'), 'info'],
    ] as [$label, $value, $color])
        <div class="col-md-3">
            <div class="card border-{{ $color }}">
                <div class="card-body">
                    <div class="text-muted small">{{ $label }}</div>
                    <div class="fs-4 fw-bold">{{ $value }}</div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="card">
    <div class="card-header bg-danger text-white">⚠️ Stok Menipis</div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>SKU</th><th>Nama</th><th>Kategori</th><th>Stok</th><th>Min</th></tr></thead>
            <tbody>
            @forelse ($lowStock as $p)
                <tr>
                    <td>{{ $p->sku }}</td>
                    <td><a href="{{ route('products.show', $p) }}">{{ $p->name }}</a></td>
                    <td>{{ $p->category->name }}</td>
                    <td class="text-danger fw-bold">{{ $p->stock }}</td>
                    <td>{{ $p->min_stock }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted">Semua stok aman.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
