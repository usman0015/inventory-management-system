@extends('layouts.app')

@section('title', 'Edit Item')

@section('breadcrumb')
<a href="{{ route('dashboard.index') }}">Dashboard</a>
<span class="sep">/</span>
<a href="{{ route('items.index') }}">Items</a>
<span class="sep">/</span>
<span class="current">Edit Item</span>
@endsection

@section('content')
<div class="form-page">
    <div class="page-header">
        <h4><i class="bi bi-pencil-square me-2 text-primary"></i>Edit Item</h4>
        <a href="{{ route('items.index') }}" class="btn btn-light btn-sm">
            <i class="bi bi-arrow-left me-1"></i>Back to Items
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger d-flex align-items-start gap-2" role="alert">
            <i class="bi bi-exclamation-triangle-fill mt-1"></i>
            <div>
                <strong>Something went wrong.</strong> Please fix the errors below and try again.
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="app-card form-card">
        <div class="app-card-header">
            <h6 class="mb-0"><i class="bi bi-box-seam me-2 text-primary"></i>Item Information</h6>
        </div>
        <div class="app-card-body">
            <form action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data" data-loading>
                @csrf
                @method('PUT')

                <div class="form-section">
                    <div class="form-section-title">
                        <span class="section-icon"><i class="bi bi-pencil-square"></i></span>
                        Details
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="itemName" class="form-label">Item Name <span class="text-danger">*</span></label>
                            <div class="input-icon">
                                <i class="bi bi-tag"></i>
                                <input type="text" id="itemName" name="name" value="{{ old('name', $item->name) }}" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" placeholder="e.g. Wireless Mouse">
                            </div>
                            @if ($errors->has('name'))
                                <div class="error-text"><i class="bi bi-exclamation-circle"></i>{{ $errors->first('name') }}</div>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                            <div class="input-icon">
                                <i class="bi bi-collection"></i>
                                <input type="text" name="category" value="{{ old('category', $item->category) }}" class="form-control {{ $errors->has('category') ? 'is-invalid' : '' }}" placeholder="e.g. Electronics">
                            </div>
                            @if ($errors->has('category'))
                                <div class="error-text"><i class="bi bi-exclamation-circle"></i>{{ $errors->first('category') }}</div>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <label for="quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
                            <div class="input-icon">
                                <i class="bi bi-sort-numeric-up"></i>
                                <input type="number" name="quantity" value="{{ old('quantity', $item->quantity) }}" min="0" class="form-control {{ $errors->has('quantity') ? 'is-invalid' : '' }}" placeholder="e.g. 25">
                            </div>
                            @if ($errors->has('quantity'))
                                <div class="error-text"><i class="bi bi-exclamation-circle"></i>{{ $errors->first('quantity') }}</div>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <label for="price" class="form-label">Price ($) <span class="text-danger">*</span></label>
                            <div class="input-icon">
                                <i class="bi bi-currency-dollar"></i>
                                <input type="number" step="0.01" min="0" name="price" value="{{ old('price', $item->price) }}" class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" placeholder="e.g. 49.99">
                            </div>
                            @if ($errors->has('price'))
                                <div class="error-text"><i class="bi bi-exclamation-circle"></i>{{ $errors->first('price') }}</div>
                            @endif
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" rows="4" placeholder="Describe the item in a few words...">{{ old('description', $item->description) }}</textarea>
                            <button type="button" id="generateBtn" class="ai-generate-btn">
                                <i class="bi bi-stars me-1"></i>Generate with AI
                            </button>
                            @if ($errors->has('description'))
                                <div class="error-text"><i class="bi bi-exclamation-circle"></i>{{ $errors->first('description') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-title">
                        <span class="section-icon"><i class="bi bi-image"></i></span>
                        Item Image
                    </div>

                    @if ($item->image)
                        <div class="mb-3">
                            <div class="form-label">Current Image</div>
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="existing-image">
                        </div>
                    @endif

                    <div class="image-upload {{ $item->image || old('image') ? '' : '' }}" id="imageDropzone">
                        <div id="uploadPrompt">
                            <i class="bi bi-cloud-arrow-up upload-icon"></i>
                            <div class="upload-text">Click to upload a new image</div>
                            <div class="upload-sub">PNG, JPG or GIF · Max 2MB</div>
                        </div>
                        <div id="imagePreviewWrap" class="image-upload-inner" style="display:none;">
                            <div class="image-preview-wrap">
                                <img id="preview" src="#" alt="Image preview">
                                <button type="button" class="image-remove" id="removeImage" aria-label="Remove image">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                        </div>
                        <input type="file" id="imageInput" name="image" accept="image/*" aria-label="Choose item image">
                    </div>
                    <div class="field-hint" id="imageHint">Leave empty to keep the current image.</div>
                    @if ($errors->has('image'))
                        <div class="error-text"><i class="bi bi-exclamation-circle"></i>{{ $errors->first('image') }}</div>
                    @endif
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-check-lg me-1"></i>Update Item
                    </button>
                    <a href="{{ route('items.index') }}" class="btn btn-light border">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    var imageInput = document.getElementById('imageInput');
    var dropzone = document.getElementById('imageDropzone');
    var preview = document.getElementById('preview');
    var imagePreviewWrap = document.getElementById('imagePreviewWrap');
    var uploadPrompt = document.getElementById('uploadPrompt');
    var removeBtn = document.getElementById('removeImage');
    var imageHint = document.getElementById('imageHint');

    dropzone.addEventListener('click', function (e) {
        if (e.target.closest('.image-remove')) return;
        imageInput.click();
    });

    imageInput.addEventListener('change', function () {
        var file = this.files[0];
        if (!file) return;

        if (!file.type.match('image.*')) {
            imageHint.textContent = 'Please choose a valid image file.';
            this.value = '';
            return;
        }

        if (file.size > 2 * 1024 * 1024) {
            imageHint.textContent = 'Image is too large. Maximum size is 2MB.';
            this.value = '';
            return;
        }

        preview.src = URL.createObjectURL(file);
        uploadPrompt.style.display = 'none';
        imagePreviewWrap.style.display = 'block';
        dropzone.classList.add('has-image');
        imageHint.textContent = file.name;
    });

    removeBtn.addEventListener('click', function () {
        imageInput.value = '';
        preview.src = '#';
        imagePreviewWrap.style.display = 'none';
        uploadPrompt.style.display = 'block';
        dropzone.classList.remove('has-image');
        imageHint.textContent = 'Leave empty to keep the current image.';
    });

    var generateBtn = document.getElementById('generateBtn');
    var itemName = document.getElementById('itemName');
    var description = document.getElementById('description');

    generateBtn.addEventListener('click', async function () {
        var name = itemName.value.trim();
        if (!name) {
            showToast('Please enter an item name first.', 'warning');
            itemName.focus();
            return;
        }

        generateBtn.disabled = true;
        generateBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Generating...';

        try {
            var response = await fetch('{{ route('ai.generate') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ name: name })
            });

            var data = await response.json();

            if (data.description) {
                description.value = data.description;
                showToast('Description generated successfully!', 'success');
            } else {
                showToast('AI could not generate a description.', 'error');
            }
        } catch (error) {
            console.error(error);
            showToast('Error generating description.', 'error');
        } finally {
            generateBtn.disabled = false;
            generateBtn.innerHTML = '<i class="bi bi-stars me-1"></i>Generate with AI';
        }
    });
});
</script>
@endsection