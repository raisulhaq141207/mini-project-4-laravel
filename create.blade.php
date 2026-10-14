@extends('layouts.app')
@section('title', 'Tambah Supplier')

@section('content')
<h3 class="mb-3">Tambah Supplier</h3>
<div class="card"><div class="card-body">
    <form action="{{ route('suppliers.store') }}" method="POST" novalidate>
        @csrf
        @include('suppliers._form')
    </form>
</div></div>
@endsection
