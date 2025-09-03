@extends('adminlte::page')
@section('title','Places')

@section('content_header')
  <h1>Places</h1>
@stop

@section('content')
  @if(session('success')) <x-adminlte-alert theme="success" title="Success">{{ session('success') }}</x-adminlte-alert> @endif

  <div class="row mb-3">
    <div class="col-md-8">
      <form class="row g-2">
        <div class="col-md-6">
          <input name="q" value="{{ $q ?? '' }}" class="form-control" placeholder="Search places...">
        </div>
        <div class="col-md-3">
          <select name="sort" class="form-control">
            <option value="top" {{ ($sort ?? '') === 'top' ? 'selected' : '' }}>Top rated</option>
            <option value="new" {{ ($sort ?? '') === 'new' ? 'selected' : '' }}>Newest</option>
            <option value="name" {{ ($sort ?? '') === 'name' ? 'selected' : '' }}>Name A–Z</option>
          </select>
        </div>
        <div class="col-md-3">
          <button class="btn btn-primary w-100">Filter</button>
        </div>
      </form>
    </div>
    <div class="col-md-4 text-end">
      @auth
        <a href="{{ route('places.create') }}" class="btn btn-success">Add Place</a>
      @else
        <a href="{{ route('login') }}" class="btn btn-outline-primary">Log in to add a place</a>
      @endauth
    </div>
  </div>

  <div class="row">
    @foreach($places as $p)
      <div class="col-md-4 mb-3">
        <div class="card h-100">
          @if($p->cover_image)
            <img src="{{ asset('storage/'.$p->cover_image) }}" class="card-img-top" alt="">
          @endif
          <div class="card-body">
            <h5 class="card-title">{{ $p->name }}</h5>
            <p class="card-text small text-muted">{{ $p->category ?? '—' }} • ⭐ {{ number_format($p->reviews_avg_rating ?? 0,1) }} ({{ $p->reviews_count }})</p>
            <p class="card-text">{{ \Illuminate\Support\Str::limit($p->description, 100) }}</p>
            <a href="{{ route('places.show', $p) }}" class="btn btn-primary btn-sm">View</a>
            @auth
            <td>
          @if(Auth::id() === $p->user_id)
                <a href="{{ route('places.edit', $p) }}" class="btn btn-secondary btn-sm">Edit</a>
              
                <form action="{{ route('places.destroy', $p->id) }}" method="POST" class>
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"
                        onlick="return confirm('Are you sure you want to delete this place?')">
                        Delete</button>
                </form>
                @endif
            </td>
              
            @endauth
          </div>
        </div>
      </div>
    @endforeach
  </div>
  <div class="mt-3">{{ $places->links() }}</div>
@stop
