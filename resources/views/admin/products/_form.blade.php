@php($isEdit = isset($product))

<div class="form-grid">
    <div class="field full">
        <label for="name">Product name *</label>
        <input type="text" id="name" name="name" maxlength="255"
               value="{{ old('name', $product->name ?? '') }}"
               class="{{ $errors->has('name') ? 'is-invalid' : '' }}" required>
        @error('name') <span class="error-text">{{ $message }}</span> @enderror
    </div>

    <div class="field">
        <label for="category_id">Category</label>
        <select id="category_id" name="category_id" class="{{ $errors->has('category_id') ? 'is-invalid' : '' }}">
            <option value="">No category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}"
                    {{ (string) old('category_id', $product->category_id ?? '') === (string) $category->id ? 'selected' : '' }}>
                    {{ $category->name }}{{ $category->is_active ? '' : ' (inactive)' }}
                </option>
            @endforeach
        </select>
        @error('category_id') <span class="error-text">{{ $message }}</span> @enderror
    </div>

    <div class="field">
        <label for="price">Price *</label>
        <input type="number" id="price" name="price" min="0" step="0.01"
               value="{{ old('price', $product->price ?? '') }}"
               class="{{ $errors->has('price') ? 'is-invalid' : '' }}" required>
        @error('price') <span class="error-text">{{ $message }}</span> @enderror
    </div>

    <div class="field full">
        <label for="description">Description</label>
        <textarea id="description" name="description" rows="4"
                  class="{{ $errors->has('description') ? 'is-invalid' : '' }}">{{ old('description', $product->description ?? '') }}</textarea>
        @error('description') <span class="error-text">{{ $message }}</span> @enderror
    </div>

    <div class="field full">
        <label for="image">{{ $isEdit ? 'Product image' : 'Product image (optional)' }}</label>
        @if ($isEdit && $product->image_path)
            <img class="image-preview" src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}">
        @endif
        <input type="file" id="image" name="image" accept=".jpg,.jpeg,.png,.webp">
        <div class="hint">
            JPG, PNG or WebP, up to 5 MB.{{ $isEdit ? ' Leave empty to keep the current image.' : '' }}
        </div>
        @error('image') <span class="error-text">{{ $message }}</span> @enderror
    </div>

    <div class="field full">
        <div class="toggle-row">
            <div>
                <strong>Active product</strong>
                <small>Show this product on the public website.</small>
            </div>
            <input type="checkbox" name="is_active" value="1" aria-label="Active product"
                {{ old('is_active', $isEdit ? $product->is_active : true) ? 'checked' : '' }}>
        </div>
    </div>
</div>

<div class="form-footer">
    <a href="{{ route('admin.products.index') }}" class="button button-light">Cancel</a>
    <button type="submit" class="button">{{ $isEdit ? 'Save changes' : 'Create product' }}</button>
</div>
