@extends('adminlte::page')

@section('content')
<div class="row">
  <div class="col-md-8">
    <h3 class="mb-1">{{ $place->name }}</h3>
    <div class="text-muted mb-2">
      {{ $place->category }} • {{ $place->address }}
    </div>

    {{-- Cover --}}
    @if($cover = $place->assets->where('category','cover')->first())
      <img src="{{ asset('storage/'.$cover->filepath) }}" class="img-fluid rounded mb-3" style="max-width:500px; height:auto;">
    @endif

    {{-- Gallery --}}
    {{-- @foreach($place->assets->where('category','gallery') as $img)
      <img src="{{ asset('storage/'.$img->filepath) }}" class="img-fluid rounded mb-2" >
    @endforeach --}}

    {{-- Stats --}}
    ⭐ {{ number_format($place->reviews_avg_rating ?? 0,1) }} ({{ $place->reviews_count ?? 0 }} reviews)

    <hr>


    @if(method_exists($place, 'reviews'))
      <h5>Reviews ({{ $place->reviews->count() }})</h5>

      @auth
      <form action="{{ route('reviews.store',$place) }}" method="POST" class="mb-4">
        @csrf
        <div class="mb-2">
          <label class="form-label">Rating</label>
          <select name="rating" class="form-select" required>
            @for($i=5;$i>=1;$i--)
              <option value="{{ $i }}">{{ $i }} ⭐</option>
            @endfor
          </select>
          @error('rating') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>
        <div class="mb-2">
          <label class="form-label">Comment (optional)</label>
          <textarea name="comment" class="form-control" rows="3"></textarea>
        </div>
        <button class="btn btn-primary">Submit Review</button>
      </form>
      @else
        <div class="alert alert-info">Please <a href="{{ route('login') }}">log in</a> to write a review.</div>
      @endauth

      @forelse($place->reviews()->latest()->with('user:id,name')->get() as $r)
        <div class="border rounded p-3 mb-2">
          <div class="d-flex justify-content-between">
            <div>
              <strong>{{ $r->user->name ?? 'Anonymous' }}</strong>
              <span class="ms-2">⭐ {{ $r->rating }}</span>
            </div>
            <small class="text-muted">{{ $r->created_at->diffForHumans() }}</small>
          </div>
          @if($r->comment)
            <div class="mt-2">{{ $r->comment }}</div>
          @endif
        </div>
      @empty
        <p class="text-muted">No reviews yet.</p>
      @endforelse
    @else
      <h5 class="text-muted">Reviews module not ready yet.</h5>
    @endif
  </div>

  <div class="col-md-4">
    <div class="border rounded p-3">
      <div class="fs-1 lh-1">⭐ {{ number_format($place->average_rating ?? 0,1) }}</div>
      <div class="text-muted">Average rating</div>
      <div class="text-muted">{{ $place->reviews_count ?? 0 }} total reviews</div>
    </div>
  </div>
</div>
@endsection
