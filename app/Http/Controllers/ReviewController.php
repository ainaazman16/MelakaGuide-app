<?php
namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Place $place)
    {
        $data = $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000',
        ]);

        // Merge required keys so created record has user_id & place_id
        $values = array_merge($data, [
            'user_id'  => auth()->id(),
            'place_id' => $place->id,
        ]);

        // update existing review or create new one
        Review::updateOrCreate(
            ['user_id' => auth()->id(), 'place_id' => $place->id],
            $values
        );

        return back()->with('success', 'Review saved.');
    }

    public function destroy(Review $review)
    {
        // ensure only the owner can delete
        if ($review->user_id !== auth()->id()) {
            abort(403);
        }

        $review->delete();

        return back()->with('success', 'Review deleted.');
    }
}
