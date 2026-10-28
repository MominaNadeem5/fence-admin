
@extends('admin.layout')

@section('content')
<div style="padding: 25px;">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h2 style="margin: 0 0 8px;">Products</h2>
            <p style="margin: 0; color: #6b7280;">Manage your products and categories.</p>
        </div>

        <a href="{{ route('admin.products.create') }}"
           style="background: #2563eb; color: white; padding: 11px 18px; border-radius: 6px; text-decoration: none;">
            + Add Product
        </a>
    </div>

    @if (session('success'))
        <div style="background: #dcfce7; color: #166534; padding: 14px; border-radius: 6px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="overflow-x: auto; background: white; border-radius: 8px; border: 1px solid #e5e7eb;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead style="background: #f3f4f6;">
                <tr>
                    <th style="padding: 14px;">Image</th>
                    <th style="padding: 14px;">Name</th>
                    <th style="padding: 14px;">Category</th>
                    <th style="padding: 14px;">Price</th>
                    <th style="padding: 14px;">Status</th>
                    <th style="padding: 14px;">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($products as $product)
                    <tr style="border-top: 1px solid #e5e7eb;">
                        <td style="padding: 14px;">
                            @if ($product->image_path)
                                <img src="{{ asset('storage/' . $product->image_path) }}"
                                     alt="{{ $product->name }}"
                                     style="width: 55px; height: 55px; object-fit: cover; border-radius: 6px;">
                            @else
                                <span style="color: #9ca3af;">No image</span>
                            @endif
                        </td>

                        <td style="padding: 14px;">{{ $product->name }}</td>

                        <td style="padding: 14px;">
                            {{ $product->category?->name ?? 'Uncategorized' }}
                        </td>

                        <td style="padding: 14px;">{{ number_format((float) $product->price, 2) }}</td>

                        <td style="padding: 14px;">
                            @if ($product->is_active)
                                <span style="color: #15803d;">Active</span>
                            @else
                                <span style="color: #dc2626;">Inactive</span>
                            @endif
                        </td>

                        <td style="padding: 14px; white-space: nowrap;">
                            <a href="{{ route('admin.products.edit', $product) }}"
                               style="color: #2563eb; text-decoration: none; margin-right: 10px;">
                                Edit
                            </a>

                            <form action="{{ route('admin.products.destroy', $product) }}"
                                  method="POST"
                                  style="display: inline;"
                                  onsubmit="return confirm('Are you sure you want to delete this product?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        style="color: #dc2626; border: none; background: none; cursor: pointer;">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding: 25px; text-align: center; color: #6b7280;">
                            No products found. Click "Add Product" to create your first product.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px;">
        {{ $products->links() }}
    </div>

</div>
@endsection
