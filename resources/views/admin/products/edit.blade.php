
@extends('admin.layout')

@section('content')
<div style="max-width: 900px; margin: 30px auto; padding: 24px;">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h2 style="margin: 0;">Edit Product</h2>

        <a href="{{ route('admin.products.index') }}"
           style="background: #6b7280; color: white; padding: 10px 16px; border-radius: 6px; text-decoration: none;">
            Back to Products
        </a>
    </div>

    @if ($errors->any())
        <div style="background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 6px; margin-bottom: 20px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.update', $product) }}"
          method="POST"
          enctype="multipart/form-data"
          style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 10px #00000010;">

        @csrf
        @method('PUT')

        <div style="margin-bottom: 20px;">
            <label for="name" style="display: block; margin-bottom: 8px;">Product Name *</label>
            <input type="text" id="name" name="name"
                   value="{{ old('name', $product->name) }}" required
                   style="width: 100%; padding: 11px; border: 1px solid #d1d5db; border-radius: 6px; box-sizing: border-box;">
        </div>

        <div style="margin-bottom: 20px;">
            <label for="category_id" style="display: block; margin-bottom: 8px;">Category</label>
            <select id="category_id" name="category_id"
                    style="width: 100%; padding: 11px; border: 1px solid #d1d5db; border-radius: 6px;">
                <option value="">Select Category (Optional)</option>

                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 20px;">
            <label for="price" style="display: block; margin-bottom: 8px;">Price *</label>
            <input type="number" id="price" name="price"
                   value="{{ old('price', $product->price) }}"
                   min="0" step="0.01" required
                   style="width: 100%; padding: 11px; border: 1px solid #d1d5db; border-radius: 6px; box-sizing: border-box;">
        </div>

        <div style="margin-bottom: 20px;">
            <label for="description" style="display: block; margin-bottom: 8px;">Description</label>
            <textarea id="description" name="description" rows="4"
                      style="width: 100%; padding: 11px; border: 1px solid #d1d5db; border-radius: 6px; box-sizing: border-box;">{{ old('description', $product->description) }}</textarea>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px;">Current Image</label>

            @if ($product->image_path)
                <img src="{{ asset('storage/' . $product->image_path) }}"
                     alt="{{ $product->name }}"
                     style="width: 120px; height: 120px; object-fit: cover; border-radius: 8px; margin-bottom: 10px;">
            @else
                <p style="color: #6b7280;">No image uploaded.</p>
            @endif

            <label for="image" style="display: block; margin: 10px 0 8px;">Upload New Image (Optional)</label>
            <input type="file" id="image" name="image" accept=".jpg,.jpeg,.png,.webp">

            <small style="display: block; margin-top: 6px; color: #6b7280;">
                JPG, PNG or WebP. Maximum size: 5 MB. Leave empty to keep the current image.
            </small>
        </div>

        <div style="margin-bottom: 25px;">
            <label>
                <input type="checkbox" name="is_active" value="1"
                    {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                Active Product
            </label>
        </div>

        <button type="submit"
                style="background: #2563eb; color: white; border: none; padding: 12px 22px; border-radius: 6px; cursor: pointer;">
            Update Product
        </button>
    </form>
</div>
@endsection
