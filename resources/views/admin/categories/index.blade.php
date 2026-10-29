@extends('admin.layout')

@section('title', 'Categories')
@section('topbar-title', 'Product Categories')

@section('content')
    <div class="page-heading">
        <div>
            <div class="eyebrow">Product management</div>
            <h1>Categories</h1>
            <p>Manage your product categories, images and display order.</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="button">+ Add Category</a>
    </div>

    <div class="panel">
        <form method="GET" action="{{ route('admin.categories.index') }}" class="toolbar">
            <input class="input search" type="search" name="search" value="{{ $search }}"
                   placeholder="Search by category name" aria-label="Search categories">

            <select class="input" name="status" aria-label="Filter by status">
                <option value="">All statuses</option>
                <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $status === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>

            <button type="submit" class="button">Filter</button>
            @if ($search !== '' || $status)
                <a href="{{ route('admin.categories.index') }}" class="button button-light">Reset</a>
            @endif
        </form>

        @if ($categories->isEmpty())
            <div class="empty">
                @if ($search !== '' || $status)
                    <strong>No categories match your filters</strong>
                    <p>Try a different search term or reset the filters.</p>
                    <a href="{{ route('admin.categories.index') }}" class="button button-light">Reset filters</a>
                @else
                    <strong>No categories yet</strong>
                    <p>Create your first category to organise your products.</p>
                    <a href="{{ route('admin.categories.create') }}" class="button">+ Add Category</a>
                @endif
            </div>
        @else
            <div class="table-wrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Category</th>
                            <th>Products</th>
                            <th>Status</th>
                            <th>Order</th>
                            <th style="text-align:right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>
                                    @if ($category->image_path)
                                        <img class="thumb" src="{{ asset('storage/'.$category->image_path) }}" alt="{{ $category->name }}" loading="lazy">
                                    @else
                                        <div class="thumb-empty">No image</div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $category->name }}</strong>
                                    @if ($category->description)
                                        <div class="cell-sub">{{ \Illuminate\Support\Str::limit($category->description, 70) }}</div>
                                    @endif
                                </td>
                                <td>{{ $category->products_count }}</td>
                                <td>
                                    <span class="badge {{ $category->is_active ? 'badge-success' : 'badge-muted' }}">
                                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>{{ $category->sort_order }}</td>
                                <td class="actions">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="button button-light button-sm">Edit</a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                          data-confirm="Delete the category “{{ $category->name }}”? This cannot be undone.">
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

            {{ $categories->links() }}
        @endif
    </div>
@endsection
