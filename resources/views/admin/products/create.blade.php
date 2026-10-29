@extends('admin.layout')

@section('title', 'Add Product')
@section('topbar-title', 'Products')

@section('content')
    <div class="page-heading">
        <div>
            <div class="eyebrow">Product management</div>
            <h1>Add product</h1>
            <p>Create a new product for your website.</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="button button-light">&larr; Back to products</a>
    </div>

    <div class="panel" style="max-width: 860px;">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.products._form')
        </form>
    </div>
@endsection
