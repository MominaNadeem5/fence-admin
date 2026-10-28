
@extends('admin.layout')

@section('title', 'Categories')
@section('topbar-title', 'Product Categories')

@section('content')
    <div class="page-heading">
        <div>
            <div class="eyebrow">PRODUCT MANAGEMENT</div>
            <h1>Categories</h1>
            <p>Manage your product categories, images and display order.</p>
        </div>

        <a href="{{ route('admin.categories.create') }}" class="button">
            + Add Category
        </a>
    </div>

    @if (session('success'))
        <div class="panel" style="border-left:4px solid #16a34a;">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="panel" style="border-left:4px solid #dc2626;">
            {{ session('error') }}
        </div>
    @endif

    <div class="panel">
        <div class="panel-header">
            <div>
                <h2>All Categories</h2>
                <p>{{ $categories->total() }} categories in total</p>
            </div>
        </div>

        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr>
                        <th style="padding:14px;text-align:left;">Image</th>
                        <th style="padding:14px;text-align:left;">Category Name</th>
                        <th style="padding:14px;text-align:left;">Products</th>
                        <th style="padding:14px;text-align:left;">Status</th>
                        <th style="padding:14px;text-align:left;">Order</th>
                        <th style="padding:14px;text-align:right;">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($categories as $category)
                        <tr style="border-top:1px solid #e5e7eb;">
                            <td style="padding:14px;">
                                @if ($category->image_path)
                                    <img
                                        src="{{ asset('storage/' . $category->image_path) }}"
                                        alt="{{ $category->name }}"
                                        style="width:56px;height:56px;object-fit:cover;border-radius:8px;"
                                    >
                                @else
                                    <span style="color:#9ca3af;">No image</span>
                                @endif
                            </td>

                            <td style="padding:14px;">
                                <strong>{{ $category->name }}</strong>
                                <div style="color:#6b7280;margin-top:4px;">
                                    {{ \Illuminate\Support\Str::limit($category->description, 70) }}
                                </div>
                            </td>

                            <td style="padding:14px;">
                                {{ $category->products_count }}
                            </td>

                            <td style="padding:14px;">
                                @if ($category->is_active)
                                    <span style="color:#15803d;">Active</span>
                                @else
                                    <span style="color:#dc2626;">Inactive</span>
                                @endif
                            </td>

                            <td style="padding:14px;">
                                {{ $category->sort_order }}
                            </td>

                            <td style="padding:14px;text-align:right;white-space:nowrap;">
                                <a
                                    href="{{ route('admin.categories.edit', $category) }}"
                                    class="button"
                                >Edit</a>

                                <form
                                    action="{{ route('admin.categories.destroy', $category) }}"
                                    method="POST"
                                    style="display:inline-block;"
                                    onsubmit="return confirm('Are you sure you want to delete this category?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="button"
                                        style="color:#dc2626;"
                                    >Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding:30px;text-align:center;color:#6b7280;">
                                No categories found. Click Add Category to create your first category.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:20px;">
            {{ $categories->links() }}
        </div>
    </div>
@endsection

