@extends('adminlte::page')

@section('title', 'Edit Place')


@section('content_header')
<div>
  <buttton onclick="history.back()" class="btn btn-default mb-3">← Back</button>
</div>
    <h1>Edit Place</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('places.update', $place->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group mb-3">
                <label class="fw-bold">Place Name <span class="text-danger">*</span></label>
                <input name="name" value="{{ old('name', $place->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="row">
                <div class="col-md-6 form-group mb-3">
                    <label class="fw-bold">Category</label>
                    <input name="category" value="{{ old('category', $place->category) }}" class="form-control" placeholder="Cafe, Library, Park">
                </div>
                <div class="col-md-6 form-group mb-3">
                    <label class="fw-bold">Phone</label>
                    <input name="phone" value="{{ old('phone', $place->phone) }}" class="form-control">
                </div>
            </div>

            <div class="form-group mb-3">
                <label class="fw-bold">Address</label>
                <input name="address" value="{{ old('address', $place->address) }}" class="form-control" placeholder="123 Street, City">
            </div>

            <div class="form-group mb-3">
                <label class="fw-bold">Website</label>
                <input name="website" value="{{ old('website', $place->website) }}" class="form-control" placeholder="https://example.com">
            </div>

            <div class="form-group mb-3">
                <label class="fw-bold">Description</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Write something about this place...">{{ old('description', $place->description) }}</textarea>
            </div>
            <div>
              @if($place->cover_image)
                <img id="cover-preview" src="{{ asset('storage/'.$place->cover_image) }}"
                  alt="Current Cover" class="img-fluid mt-2" style="max-width:200px;">
                  @else
                  <img id="cover-preview" src="#" alt="Preview" class="img-fluid mt-2" style="max-width:200px; display:none;">
                  @endif
            </div>
            <div class="form-group mb-3">
                <label class="fw-bold">Cover Image</label>
                <input type="file" name="cover_image" class="form-control" accept="image/*" onchange="previewImage(event)">
                <p class="help-block">Optional. Upload a representative photo.</p>
                <img id="cover-preview" src="#" alt="Preview" class="img-fluid mt-2" style="max-width:200px; display:none;">
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('places.index') }}" class="btn btn-default">← Back</a>
                <button type="submit" class="btn btn-success">Save Place</button>
            </div>
        </form>
    </div>
</div>
@stop

@section('js')
<script>
function previewImage(e){
    const preview = document.getElementById('cover-preview');
    const file = e.target.files[0];
    if (!file) { preview.style.display = 'none'; return; }
    preview.src = URL.createObjectURL(file);
    preview.style.display = 'block';
}
</script>
@stop
