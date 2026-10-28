
@extends('admin.layout')

@section('content')
<style>
    .product-form-page {
        max-width: 1000px;
        margin: 0 auto;
        color: #1f2937;
    }

    .product-form-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 25px;
    }

    .product-form-header h1 {
        margin: 0 0 7px;
        font-size: 27px;
        font-weight: 700;
    }

    .product-form-header p {
        margin: 0;
        color: #6b7280;
        font-size: 14px;
    }

    .product-form-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        overflow: hidden;
    }

    .product-form-card-header {
        padding: 22px 26px;
        border-bottom: 1px solid #edf0ed;
    }

    .product-form-card-header h2 {
        margin: 0 0 6px;
        font-size: 18px;
    }

    .product-form-card-header p {
        margin: 0;
        color: #6b7280;
        font-size: 13px;
    }

    .product-form-body {
        padding: 26px;
    }

    .product-form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0 22px;
    }

    .product-form-field {
        margin-bottom: 22px;
    }

    .product-form-field.full-width {
        grid-column: 1 / -1;
    }

    .product-form-field label {
        display: block;
        margin-bottom: 9px;
        font-size: 13px;
        font-weight: 600;
        color: #374151;
    }

    .product-form-field input:not([type="checkbox"]),
    .product-form-field select,
    .product-form-field textarea {
        box-sizing: border-box;
        width: 100%;
        padding: 12px 13px;
        border: 1px solid #dfe4df;
        border-radius: 8px;
        background: #fff;
        color: #1f2937;
        font: inherit;
        font-size: 14px;
    }

    .product-form-field textarea {
        min-height: 125px;
        resize: vertical;
    }

    .product-form-field input:focus,
    .product-form-field select:focus,
    .product-form-field textarea:focus {
        outline: none;
        border-color: #557b60;
        box-shadow: 0 0 0 3px rgba(85, 123, 96, .12);
    }

    .product-form-help {
        display: block;
        margin-top: 7px;
        color: #6b7280;
        font-size: 12px;
    }

    .product-form-error {
        display: block;
        margin-top: 6px;
        color: #b91c1c;
        font-size: 12px;
    }

    .product-form-status {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 14px;
        padding: 16px;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        background: #fafbf9;
    }

    .product-form-status strong {
        display: block;
        font-size: 14px;
    }

    .product-form-status small {
        display: block;
        margin-top: 4px;
        color: #6b7280;
        font-size: 12px;
    }

    .product-form-status input {
        width: 18px;
        height: 18px;
        accent-color: #244b35;
    }

    .product-form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        padding-top: 22px;
        border-top: 1px solid #edf0ed;
        margin-top: 8px;
    }

    .product-form-btn {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        padding: 11px 18px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        border: 1px solid #e5e7eb;
    }

    .product-form-btn-secondary {
        background: #fff;
        color: #374151;
    }

    .product-form-btn-primary {
        background: #244b35;
        color: #fff;
        border-color: #244b35;
    }

    @media (max-width: 650px) {
        .product-form-grid {
            grid-template-columns: 1fr;
        }

        .product-form-field.full-width {
            grid-column: auto;
        }

        .product-form-body {
            padding: 18px;
        }

        .product-form-card-header {
            padding: 18px;
        }

        .product-form-header h1 {
            font-size: 23px;
        }

        .product-form-actions {
            flex-direction: column-reverse;
        }

        .product-form-actions .product-form-btn {
            width: 100%;
            box-sizing: border-box;
        }
    }
</style>

<div class="product-form-page">
    <div class="product-form-header">
        <div>
            <h1>Add Product</h1>
            <p>Add a product to your store and assign its category.</p>
        </div>

        <a
            href="{{ route('admin.products.index') }}"
            class="product-form-btn product-form-btn-secondary"
        >
            ← Back to Products
        </a>
    </div>

    @if ($errors->any())
        <div style="padding: 14px 18px; margin-bottom: 20px; border-radius: 9px; background: #fef2f2; color: #991b1b;">
            Please check the highlighted fields and try again.
        </div>
    @endif

    <div class="product-form-card">
        <div class="product-form-card-header">
            <h2>Product Information</h2>
            <p>Fields marked with * are required.</p>
        </div>

        <form
            class="product-form-body"
            action="{{ route('admin.products.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf

            <div class="product-form-grid">
                <div class="product-form-field full-width">
                    <label for="name">Product Name *</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Enter product name"
                        required
                    >
                    @error('name')
                        <span class="product-form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="product-form-field">
                    <label for="category_id">Category</label>
                    <select id="category_id" name="category_id">
                        <option value="">Select a category</option>

                        @foreach ($categories as $category)
                            <option
                                value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}
                            >
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    <span class="product-form-help">
                        Choose which category this product belongs to.
                    </span>

                    @error('category_id')
                        <span class="product-form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="product-form-field">
                    <label for="price">Price *</label>
                    <input
                        type="number"
                        id="price"
                        name="price"
                        value="{{ old('price') }}"
                        min="0"
                        step="0.01"
                        placeholder="0.00"
                        required
                    >
                    @error('price')
                        <span class="product-form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="product-form-field full-width">
                    <label for="description">Description</label>
                    <textarea
                        id="description"
                        name="description"
                        placeholder="Describe your product..."
                    >{{ old('description') }}</textarea>

                    @error('description')
                        <span class="product-form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="product-form-field full-width">
                    <label for="image">Product Image</label>
                    <input
                        type="file"
                        id="image"
                        name="image"
                        accept=".jpg,.jpeg,.png,.webp"
                    >
                    <span class="product-form-help">
                        JPG, JPEG, PNG or WEBP. Maximum size: 5 MB.
                    </span>

                    @error('image')
                        <span class="product-form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="product-form-field full-width">
                    <label>Visibility</label>

                    <div class="product-form-status">
                        <div>
                            <strong>Active Product</strong>
                            <small>Active products can appear on the public website.</small>
                        </div>

                        <input
                            type="checkbox"
                            name="is_active"
                            value="1"
                            {{ old('is_active', '1') ? 'checked' : '' }}
                        >
                    </div>
                </div>
            </div>

            <div class="product-form-actions">
                <a
                    href="{{ route('admin.products.index') }}"
                    class="product-form-btn product-form-btn-secondary"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="product-form-btn product-form-btn-primary"
                >
                    Save Product
                </button>
            </div>
        </form>
    </div>
</div>
@endsection