{{-- resources/views/admin/categories/form.blade.php --}}
<div class="row">
    <div class="col-md-8">
        <div class="mb-3">
            <label for="name" class="form-label">Category Name *</label>
            <input type="text" 
                   class="form-control @error('name') is-invalid @enderror" 
                   id="name" 
                   name="name" 
                   value="{{ old('name', $category->name ?? '') }}" 
                   required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" 
                   class="form-control @error('slug') is-invalid @enderror" 
                   id="slug" 
                   name="slug" 
                   value="{{ old('slug', $category->slug ?? '') }}">
            <div class="form-text">Leave empty to auto-generate from name</div>
            @error('slug')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" 
                      id="description" 
                      name="description" 
                      rows="4">{{ old('description', $category->description ?? '') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="parent_id" class="form-label">Parent Category</label>
                <select class="form-control @error('parent_id') is-invalid @enderror" 
                        id="parent_id" 
                        name="parent_id">
                    <option value="">— No Parent (Main Category) —</option>
                    @foreach($parentCategories as $parent)
                        <option value="{{ $parent->id }}" 
                            {{ (old('parent_id', $category->parent_id ?? '') == $parent->id) ? 'selected' : '' }}>
                            {{ $parent->name }}
                        </option>
                    @endforeach
                </select>
                @error('parent_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6 mb-3">
                <label for="order" class="form-label">Display Order</label>
                <input type="number" 
                       class="form-control @error('order') is-invalid @enderror" 
                       id="order" 
                       name="order" 
                       value="{{ old('order', $category->order ?? 0) }}" 
                       min="0">
                @error('order')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <label for="image" class="form-label">Category Image</label>
                    <input type="file" 
                           class="form-control @error('image') is-invalid @enderror" 
                           id="image" 
                           name="image"
                           accept="image/*">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    
                    @if(isset($category) && $category->image)
                    <div class="mt-3">
                        <p>Current Image:</p>
                        <img src="{{ asset('storage/' . $category->image) }}" 
                             alt="{{ $category->name }}" 
                             class="img-thumbnail" 
                             style="max-height: 200px;">
                        <div class="form-check mt-2">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="remove_image" 
                                   name="remove_image" 
                                   value="1">
                            <label class="form-check-label" for="remove_image">
                                Remove current image
                            </label>
                        </div>
                    </div>
                    @endif
                </div>
                
                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" 
                               type="checkbox" 
                               id="is_active" 
                               name="is_active" 
                               value="1"
                               {{ (old('is_active', $category->is_active ?? true)) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active Category</label>
                    </div>
                </div>
                
                <hr>
                
                <div class="mb-3">
                    <label for="meta_title" class="form-label">Meta Title (SEO)</label>
                    <input type="text" 
                           class="form-control" 
                           id="meta_title" 
                           name="meta_title" 
                           value="{{ old('meta_title', $category->meta_title ?? '') }}">
                </div>
                
                <div class="mb-3">
                    <label for="meta_description" class="form-label">Meta Description (SEO)</label>
                    <textarea class="form-control" 
                              id="meta_description" 
                              name="meta_description" 
                              rows="3">{{ old('meta_description', $category->meta_description ?? '') }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-generate slug from name
    document.getElementById('name').addEventListener('input', function() {
        const name = this.value;
        const slugField = document.getElementById('slug');
        
        // Only auto-generate if slug field is empty or matches current auto-generated slug
        if (!slugField.value || slugField.value === '{{ $category->slug ?? '' }}') {
            slugField.value = name.toLowerCase()
                .replace(/[^\w\s]/gi, '')
                .replace(/\s+/g, '-')
                .trim();
        }
    });
</script>
@endpush