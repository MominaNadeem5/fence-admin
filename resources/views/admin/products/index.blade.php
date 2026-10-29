@extends('admin.layout')

@section('title', 'Products')
@section('topbar-title', 'Products')

@section('content')
    <div class="page-heading">
        <div>
            <div class="eyebrow">Product management</div>
            <h1>Products</h1>
            <p>Manage the products shown on your website.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="button">+ Add Product</a>
    </div>

    <div class="panel">
        <form method="GET" action="{{ route('admin.products.index') }}" class="toolbar">
            <input class="input search" type="search" name="search" value="{{ $search }}"
                   placeholder="Search by product name" aria-label="Search products">

            <select class="input" name="category" aria-label="Filter by category">
                <option value="">All categories</option>
                <option value="none" {{ $categoryId === 'none' ? 'selected' : '' }}>No category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ (string) $categoryId === (string) $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <select class="input" name="status" aria-label="Filter by status">
                <option value="">All statuses</option>
                <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $status === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>

            <button type="submit" class="button">Filter</button>
            @if ($search !== '' || $status || $categoryId)
                <a href="{{ route('admin.products.index') }}" class="button button-light">Reset</a>
            @endif
        </form>

        @if ($products->isEmpty())
            <div class="empty">
                @if ($search !== '' || $status || $categoryId)
                    <strong>No products match your filters</strong>
                    <p>Try a different search term or reset the filters.</p>
                    <a href="{{ route('admin.products.index') }}" class="button button-light">Reset filters</a>
                @else
                    <strong>No products yet</strong>
                    <p>Add your first product to show it on the website.</p>
                    <a href="{{ route('admin.products.create') }}" class="button">+ Add Product</a>
                @endif
            </div>
        @else
            <div class="table-wrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th style="text-align:right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>
                                    @if ($product->image_path)
                                        <img class="thumb" src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}" loading="lazy">
                                    @else
                                        <div class="thumb-empty">No image</div>
                                    @endif
                                </td>
                                <td><strong>{{ $product->name }}</strong></td>
                                <td>{{ $product->category?->name ?? 'Uncategorized' }}</td>
                                <td>{{ number_format((float) $product->price, 2) }}</td>
                                <td>
                                    <span class="badge {{ $product->is_active ? 'badge-success' : 'badge-muted' }}">
                                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="actions">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="button button-light button-sm">Edit</a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                          data-confirm="Delete “{{ $product->name }}”? This cannot be undone.">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="button button-danger button-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $products->links() }}
        @endif
    </div>
@endsection
