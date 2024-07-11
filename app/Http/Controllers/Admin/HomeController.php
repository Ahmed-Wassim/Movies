<?php

namespace App\Http\Controllers\Admin;

use Carbon\Month;
use App\Models\Actor;
use App\Models\Genre;
use App\Models\Movie;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    use ApiResponses;
    public function genreCount()
    {
        return $this->successResponse(Genre::count());
    }

    public function movieCount()
    {
        return $this->successResponse(Movie::count());
    }

    public function actorCount()
    {
        return $this->successResponse(Actor::count());
    }

    public function chart()
    {
        $movies = Movie::where('release_year', request()->year)
            ->select(
                '*',
                DB::raw('YEAR(release_date) as year'),
                DB::raw('MONTH(release_date) as month'),
                DB::raw('COUNT(*) as total'),
            )->groupBy('month')
            ->get();

        return $this->successResponse($movies);
    }
}
