<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    use ApiResponses;
    public function index()
    {
        $genres = Genre::select('id', 'name')->withCount('movies')->get();
        return $this->successResponse($genres);
    }

    public function destroy(Genre $genre)
    {
        $genre->delete();
        return $this->successResponse($genre);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->genre_ids;
        Genre::whereIn('id', $ids)->delete();
        return $this->successResponse("Genres Deleted successfully");
    }
}
