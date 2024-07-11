<?php

namespace App\Http\Controllers\Admin;

use App\Models\Movie;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class MovieController extends Controller
{
    use ApiResponses;
    public function index()
    {
        $genres = Movie::select('id', 'title', 'release_date', 'poster', 'banner', 'vote', 'vote_count')
            ->with('genres')
            ->filter(request(['genre']))
            ->get();

        return $this->successResponse($genres);
    }

    public function show(string $id)
    {
        $movie = Movie::select('id', 'title', 'release_date', 'poster', 'banner', 'vote', 'vote_count')->with('genres', 'actors', 'images')->find($id);

        return $this->successResponse($movie);
    }

    public function destroy(Movie $movie)
    {
        try {
            $movie->delete();
            return $this->successResponse($movie);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to delete movie.', 500);
        }
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->movie_ids;

        DB::beginTransaction();

        try {
            Movie::whereIn('id', $ids)->delete();
            DB::commit();
            return $this->successResponse("Movies deleted successfully.");
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to delete movies.', 500);
        }
    }
}
