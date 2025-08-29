<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PlaceController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        $sort = $request->query('sort', 'top'); // top|new|name

        $places = Place::query()
            ->when($q, fn($x) => $x->where(function ($w) use ($q) {
                $w->where('name', 'like', "%$q%")
                    ->orWhere('category', 'like', "%$q%")
                    ->orWhere('address', 'like', "%$q%");
            }))
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->when($sort === 'new', fn($x) => $x->latest())
            ->when($sort === 'name', fn($x) => $x->orderBy('name'))
            ->when($sort === 'top', fn($x) => $x->orderByDesc('reviews_avg_rating'))
            ->paginate(9)
            ->withQueryString();

        return view('places.index', compact('places', 'q', 'sort'));
    }

    public function create()
    {
        return view('places.create');
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'name'        => 'required|string|max:255',
        'category'    => 'nullable|string|max:100',
        'address'     => 'nullable|string|max:255',
        'phone'       => 'nullable|string|max:50',
        'website'     => 'nullable|url|max:255',
        'description' => 'nullable|string',
        'cover_image' => 'nullable|image|max:4096',
        'attachments.*' => 'nullable|file|max:8192',
    ]);

    // remove cover_image from fillable data
    unset($data['cover_image']);

    // ✅ Save place first
    $place = new \App\Models\Place();
    $place->fill($data);
    $place->save();

    // ✅ Now attach cover image
    if ($request->hasFile('cover_image')) {
        $file = $request->file('cover_image');
        $path = $file->store('places/cover', 'public');

        $place->assets()->create([
            'filename' => $file->getClientOriginalName(),
            'filepath' => $path,
            'filetype' => $file->getClientMimeType(),
            'category' => 'cover',
        ]);
    }

    // ✅ Attach gallery files
    if ($request->hasFile('attachments')) {
        foreach ($request->file('attachments') as $file) {
            $path = $file->store('places/gallery', 'public');

            $place->assets()->create([
                'filename' => $file->getClientOriginalName(),
                'filepath' => $path,
                'filetype' => $file->getClientMimeType(),
                'category' => 'gallery',
            ]);
        }
    }

    return redirect()
        ->route('places.show', $place->id)
        ->with('success', 'Place created successfully with files!');
}

   public function show(Place $place)
{
    $place->load(['assets']); // reviews not required yet
    return view('places.show', compact('place'));
}

    public function edit(Place $place)
    {
        return view('places.edit', compact('place'));
    }

    public function update(Request $request, Place $place)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('cover_image')) {
            $data['image'] = $request->file('cover_image')->store('places', 'public');
        }

        $place->update($data);
        return redirect()->route('places.show', $place)->with('success', 'Place updated.');
    }

    public function destroy(Place $place)
    {
        $place->delete();
        return redirect()->route('places.index')->with('success', 'Place deleted.');
    }
}
