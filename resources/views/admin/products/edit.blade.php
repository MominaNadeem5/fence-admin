@extends('admin.layout')

@section('title', 'Edit Product')
@section('topbar-title', 'Products')

@section('content')
    <div class="page-heading">
        <div>
            <div class="eyebrow">Product management</div>
            <h1>Edit product</h1>
            <p>Update the details of “{{ $product->name }}”.</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="button button-light">&larr; Back to products</a>
    </div>

    <div class="panel" style="max-width: 860px;">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.products._form')
        </form>
    </div>
@endsection
