@extends('layouts.app')
@section('title', 'Edit Supplier')

@section('content')
<h3 class="mb-3">Edit Supplier</h3>
<div class="card"><div class="card-body">
    <form action="{{ route('suppliers.update', $supplier) }}" method="POST" novalidate>
        @csrf @method('PUT')
        @include('suppliers._form')
    </form>
</div></div>
@endsection
