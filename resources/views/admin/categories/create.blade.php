
@extends('admin.layout')

@section('content')
<style>
    .category-edit-page { max-width: 1000px; margin: 0 auto; color: #1f2937; }
    .category-edit-header { display: flex; justify-content: space-between; align-items: center; gap: 16px; margin-bottom: 26px; flex-wrap: wrap; }
    .category-edit-header h1 { margin: 0 0 7px; font-size: 27px; font-weight: 700; }
    .category-edit-header p { margin: 0; color: #6b7280; font-size: 14px; }
    .category-edit-btn { display: inline-flex; align-items: center; justify-content: center; padding: 11px 18px; border-radius: 9px; text-decoration: none; font-size: 14px; font-weight: 600; cursor: pointer; border: 1px solid #dfe4df; background: #fff; color: #374151; }
    .category-back-btn { background: #fff; }
    .category-save-btn { background: #244b35; border-color: #244b35; color: #fff; }
    .category-edit-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden; }
    .category-edit-card-heading { padding: 22px 26px; border-bottom: 1px solid #edf0ed; }
    .category-edit-card-heading h2 { margin: 0 0 6px; font-size: 18px; }
    .category-edit-card-heading p { margin: 0; color: #6b7280; font-size: 13px; }
    .category-edit-form { padding: 26px; }
    .category-edit-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 22px; }
    .category-edit-field { min-width: 0; }
    .category-edit-field.full-width { grid-column: 1 / -1; }
    .category-edit-field label { display: block; margin-bottom: 8px; font-size: 13px; font-weight: 600; color: #374151; }
    .category-edit-field input:not([type="checkbox"]), .category-edit-field textarea { box-sizing: border-box; width: 100%; padding: 12px 13px; border: 1px solid #dfe4df; border-radius: 8px; background: #fff; color: #1f2937; font: inherit; font-size: 14px; }
    .category-edit-field textarea { min-height: 120px; resize: vertical; }
    .category-edit-field input:focus, .category-edit-field textarea:focus { outline: none; border-color: #557b60; box-shadow: 0 0 0 3px rgba(85,123,96,.12); }
    .category-edit-help { display: block; margin-top: 8px; color: #6b7280; font-size: 12px; }
    .category-edit-status { display: flex; justify-content: space-between; align-items: center; gap: 15px; padding: 16px; border: 1px solid #e5e7eb; border-radius: 10px; background: #fafbf9; }
    .category-edit-status strong { display: block; font-size: 14px; }
    .category-edit-status small { display: block; color: #6b7280; margin-top: 4px; font-size: 12px; }
    .category-edit-status input { width: 18px; height: 18px; accent-color: #244b35; }
    .category-edit-actions { display: flex; justify-content: flex-end; gap: 12px; padding-top: 22px; border-top: 1px solid #edf0ed; margin-top: 22px; }
    .category-edit-error { display: block; color: #b91c1c; margin-top: 6px; font-size: 12px; }
    @media (max-width: 650px) {
        .category-edit-grid { grid-template-columns: 1fr; gap: 18px; }
        .category-edit-form, .category-edit-card-heading { padding: 18px; }
        .category-edit-header h1 { font-size: 23px; }
        .category-edit-actions { flex-direction: column-reverse; }
        .category-edit-actions .category-edit-btn { width: 100%; box-sizing: border-box; }
    }
</style>

<div class="category-edit-page">
    <div class="category-edit-header">
        <div>
            <h1>Add Category</h1>
            <p>Create a new product category for your website.</p>
        </div>

        <a href="{{ route('admin.categories.index') }}" class="category-edit-btn category-back-btn">
            Back to Categories
        </a>
    </div>

    @if ($errors->any())
        <div style="padding:14px 18px;margin-bottom:20px;border-radius:9px;background:#fef2f2;color:#991b1b;">
            Please check the highlighted fields and try again.
        </div>
    @endif

    <div class="category-edit-card">
        <div class="category-edit-card-heading">
            <h2>Category Details</h2>
            <p>Enter the new category information below.</p>
        </div>

        <form class="category-edit-form"
              action="{{ route('admin.categories.store') }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf

            <div class="category-edit-grid">
                <div class="category-edit-field full-width">
                    <label for="name">Category Name *</label>
                    <input type="text" id="name" name="name"
                           value="{{ old('name') }}"
                           placeholder="e.g. Livestock Fence" required>
                    @error('name') <span class="category-edit-error">{{ $message }}</span> @enderror
                </div>

                <div class="category-edit-field full-width">
                    <label for="description">Description</label>
                    <textarea id="description" name="description"
                              placeholder="Write a short category description...">{{ old('description') }}</textarea>
                    @error('description') <span class="category-edit-error">{{ $message }}</span> @enderror
                </div>

                <div class="category-edit-field full-width">
                    <label for="image">Category Image</label>
                    <input type="file" id="image" name="image" accept=".jpg,.jpeg,.png,.webp">
                    <span class="category-edit-help">Optional. JPG, PNG or WEBP. Maximum 5 MB.</span>
                    @error('image') <span class="category-edit-error">{{ $message }}</span> @enderror
                </div>

                <div class="category-edit-field">
                    <label for="sort_order">Display Order</label>
                    <input type="number" id="sort_order" name="sort_order"
                           min="0" value="{{ old('sort_order', 0) }}">
                    <span class="category-edit-help">Smaller numbers appear first.</span>
                    @error('sort_order') <span class="category-edit-error">{{ $message }}</span> @enderror
                </div>

                <div class="category-edit-field">
                    <label>Visibility</label>
                    <div class="category-edit-status">
                        <div>
                            <strong>Active Category</strong>
                            <small>Show this category on the public website.</small>
                        </div>
                        <input type="checkbox" name="is_active" value="1"
                               {{ old('is_active', true) ? 'checked' : '' }}>
                    </div>
                </div>
            </div>

            <div class="category-edit-actions">
                <a href="{{ route('admin.categories.index') }}" class="category-edit-btn category-back-btn">
                    Cancel
                </a>
                <button type="submit" class="category-edit-btn category-save-btn">
                    Create Category
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
