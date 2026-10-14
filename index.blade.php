@extends('layouts.app')
@section('title', 'Supplier')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Supplier</h3>
    <a href="{{ route('suppliers.create') }}" class="btn btn-primary">+ Tambah Supplier</a>
</div>
<div class="card"><div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light"><tr><th>Nama</th><th>Telepon</th><th>Email</th><th class="text-center">Produk</th><th class="text-end">Aksi</th></tr></thead>
        <tbody>
        @forelse ($suppliers as $s)
            <tr>
                <td>{{ $s->name }}</td>
                <td>{{ $s->phone ?: '-' }}</td>
                <td>{{ $s->email ?: '-' }}</td>
                <td class="text-center">{{ $s->products_count }}</td>
                <td class="text-end">
                    <a href="{{ route('suppliers.edit', $s) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                    <form action="{{ route('suppliers.destroy', $s) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Hapus supplier ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center text-muted py-4">Belum ada supplier.</td></tr>
        @endforelse
        </tbody>
    </table>
</div></div>
<div class="mt-3">{{ $suppliers->links('pagination::bootstrap-5') }}</div>
@endsection
