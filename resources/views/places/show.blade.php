@extends('adminlte::page')

@section('content')
<div>
  <br>
  <button class="btn btn-outline-primary mb-3" onclick="window.history.back()">← Back</button>
</div>
  <h1 class="mb-4">Place Details</h1>
    {{-- Cover --}}
    <div class="card mb-4">
      @if($cover = $place->assets->where('category','cover')->first())
      <img src="{{ asset('storage/'.$cover->filepath) }}" class="img-fluid rounded mb-3" style="max-width:300px; height:auto;">
    @endif
    <div class="card-body">
      <h3 class="card-title mb-1">{{ $place->name }}</h3>
      <p class="text-muted mb-0>">
        {{ $place->category }} • {{ $place->address }}
      </p>
    <p class="mb-0">⭐ {{ number_format($place->reviews_avg_rating ?? 0,1) }} ({{ $place->reviews_count ?? 0 }} reviews)</p>
    </div>
  </div>
    @if(method_exists($place, 'reviews'))
      <h5>Reviews ({{ $place->reviews->count() }})</h5>

      @auth
      <div class="card mb-4">
        <div class="card-header">Write a Review</div>
        <div class="card-body">
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
        </div>
      </div>
      @endauth

      @forelse($place->reviews()->latest()->with('user:id,name')->get() as $r)
        <div class="card mb-2">
          <div class="card-body">
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
        </div>
      @empty
        <p class="text-muted">No reviews yet.</p>
      @endforelse
    @else
      <h5 class="text-muted">Reviews module not ready yet.</h5>
    @endif
  </div>

  <div class="card">
    <div class="card-body text-center">
      <div class="fs-1 lh-1">⭐ {{ number_format($place->average_rating ?? 0,1) }}</div>
      <div class="text-muted">Average rating</div>
      <div class="text-muted">{{ $place->reviews_count ?? 0 }} total reviews</div>
    </div>
  </div>
</div>
@endsection
