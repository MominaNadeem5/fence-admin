
@extends('admin.layout')

@section('content')
<style>
    .products-page {
        max-width: 1200px;
        margin: 0 auto;
        color: #1f2937;
    }

    .products-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 26px;
    }

    .products-header h1 {
        margin: 0 0 7px;
        font-size: 27px;
        font-weight: 700;
    }

    .products-header p {
        margin: 0;
        color: #6b7280;
        font-size: 14px;
    }

    .products-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 15px;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
    }

    .products-btn-primary {
        background: #244b35;
        color: #fff;
        border-color: #244b35;
    }

    .products-btn-edit {
        background: #f0f5f0;
        color: #244b35;
    }

    .products-btn-delete {
        background: #fff1f2;
        color: #be123c;
        border-color: #ffe4e6;
    }

    .products-table-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
    }

    .products-table-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 22px;
        border-bottom: 1px solid #edf0ed;
    }

    .products-table-top h2 {
        margin: 0;
        font-size: 17px;
    }

    .products-count {
        color: #6b7280;
        font-size: 13px;
    }

    .products-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .products-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        white-space: nowrap;
    }

    .products-table th {
        padding: 14px 18px;
        background: #f8faf8;
        color: #6b7280;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .05em;
    }

    .products-table td {
        padding: 16px 18px;
        border-top: 1px solid #edf0ed;
        font-size: 13px;
        vertical-align: middle;
    }

    .products-item {
        display: flex;
        align-items: center;
        gap: 13px;
        min-width: 220px;
    }

    .products-image {
        width: 54px;
        height: 54px;
        flex-shrink: 0;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        object-fit: cover;
        background: #f3f5f2;
    }

    .products-placeholder {
        display: grid;
        place-items: center;
        color: #6b7280;
        font-size: 10px;
    }

    .products-name {
        font-weight: 600;
        color: #1f2937;
        white-space: normal;
        max-width: 230px;
    }

    .products-description {
        color: #6b7280;
        font-size: 12px;
        margin-top: 5px;
        max-width: 230px;
        white-space: normal;
    }

    .products-category {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 6px;
        background: #f0f5f0;
        color: #315b3c;
        font-size: 12px;
    }

    .products-price {
        font-weight: 700;
        color: #244b35;
    }

    .products-status {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
    }

    .products-status-active {
        color: #166534;
        background: #dcfce7;
    }

    .products-status-inactive {
        color: #9f1239;
        background: #ffe4e6;
    }

    .products-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .products-alert {
        padding: 14px 17px;
        margin-bottom: 20px;
        border-radius: 9px;
        font-size: 14px;
    }

    .products-alert-success {
        background: #ecfdf3;
        color: #166534;
    }

    .products-alert-error {
        background: #fef2f2;
        color: #991b1b;
    }

    .products-empty {
        padding: 55px 20px;
        text-align: center;
        color: #6b7280;
    }

    .products-empty h3 {
        color: #1f2937;
        margin-bottom: 8px;
    }

    .products-pagination {
        padding: 18px 22px;
        border-top: 1px solid #edf0ed;
    }

    @media (max-width: 600px) {
        .products-header h1 {
            font-size: 23px;
        }

        .products-header .products-btn {
            width: 100%;
            box-sizing: border-box;
        }

        .products-table-top {
            padding: 16px;
        }
    }
</style>

<div class="products-page">
    <div class="products-header">
        <div>
            <h1>Products</h1>
            <p>Manage your products, prices and categories.</p>
        </div>

        <a
            href="{{ route('admin.products.create') }}"
            class="products-btn products-btn-primary"
        >
            + Add Product
        </a>
    </div>

    @if (session('success'))
        <div class="products-alert products-alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="products-alert products-alert-error">
            {{ session('error') }}
        </div>
    @endif

    <div class="products-table-card">
        <div class="products-table-top">
            <h2>All Products</h2>
            <span class="products-count">
                {{ $products->total() }} products
            </span>
        </div>

        <div class="products-table-wrap">
            <table class="products-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>
                                <div class="products-item">
                                    @if ($product->image_path)
                                        <img
                                            class="products-image"
                                            src="{{ asset('storage/' . $product->image_path) }}"
                                            alt="{{ $product->name }}"
                                        >
                                    @else
                                        <div class="products-image products-placeholder">
                                            No image
                                        </div>
                                    @endif

                                    <div>
                                        <div class="products-name">
                                            {{ $product->name }}
                                        </div>

                                        @if ($product->description)
                                            <div class="products-description">
                                                {{ \Illuminate\Support\Str::limit($product->description, 65) }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="products-category">
                                    {{ $product->category?->name ?? 'Uncategorized' }}
                                </span>
                            </td>

                            <td class="products-price">
                                {{ number_format((float) $product->price, 2) }}
                            </td>

                            <td>
                                @if ($product->is_active)
                                    <span class="products-status products-status-active">
                                        Active
                                    </span>
                                @else
                                    <span class="products-status products-status-inactive">
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div class="products-actions">
                                    <a
                                        href="{{ route('admin.products.edit', $product) }}"
                                        class="products-btn products-btn-edit"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.products.destroy', $product) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this product?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="products-btn products-btn-delete"
                                        >
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="products-empty">
                                    <h3>No products yet</h3>
                                    <p>Add your first product to get started.</p>

                                    <a
                                        href="{{ route('admin.products.create') }}"
                                        class="products-btn products-btn-primary"
                                    >
                                        + Add Your First Product
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($products->hasPages())
            <div class="products-pagination">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>
@endsection