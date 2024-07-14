<?php

namespace App\Console\Commands;

use App\Models\Type;
use App\Models\Actor;
use App\Models\Genre;
use App\Models\Image;
use App\Models\Movie;
use Illuminate\Support\Arr;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class GetMovies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:movies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all movies from TMDB';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // DB::table('movies')->truncate();
        // DB::table('genre_movie')->truncate();
        $this->getMovies();
    }

    private function getMovies()
    {
        $pages = 5;
        $startTime = microtime(true);
        for ($i = 1; $i <= $pages; $i++) {

            $response = Http::get(config('services.tmdb.url') . '/movie/popular?api_key=' . config('services.tmdb.key') . '&language=en&page=' . $i)->json()['results'];


            foreach ($response as $result) {
                $movie = Movie::updateOrCreate([
                    'eid' => $result['id'],
                ], [
                    'title' => $result['title'],
                    'description' => $result['overview'],
                    'poster' => $result['poster_path'],
                    'banner' => $result['backdrop_path'],
                    'release_date' => ($result['release_date'] == '') ? null : $result['release_date'],
                    'vote' => $result['vote_average'],
                    'vote_count' => $result['vote_count'],
                ]);

                $this->attachGenres($result, $movie);
                $this->attachActors($movie);
                $this->attachImages($movie);
            }
        }

        $endTime = microtime(true);
        $duration = $endTime - $startTime;
        dd($duration);
    }

    private function attachGenres($result, $movie)
    {
        $genreIds = $result['genre_ids'];
        $genres = Genre::whereIn('eid', $genreIds)->get();

        $movie->genres()->attach($genres);
    }

    private function attachActors($movie)
    {
        $response = Http::get(config('services.tmdb.url') . '/movie/' . $movie->eid . '/credits?api_key=' . config('services.tmdb.key'))->json()['cast'];

        $count = 0;
        foreach ($response as $index => $result) {
            if ($result['known_for_department'] != 'Acting')
                continue;
            if ($count == 12)
                break;
            $actor = Actor::firstOrCreate([
                'eid' => $result['id'],
                'name' => $result['name'],
                'image' => $result['profile_path'],
            ]);

            $movie->actors()->syncWithoutDetaching($actor->id);

            $count++;
        }
    }

    private function attachImages(Movie $movie)
    {
        $response = Http::get(config('services.tmdb.url') . '/movie/' . $movie->eid . '/images?api_key=' . config('services.tmdb.key'))->json()['backdrops'];

        $movie->images()->delete();
        $count = 0;
        foreach ($response as $index => $result) {
            if ($count == 12)
                break;
            $movie->images()->create([
                'path' => $result['file_path'],
            ]);

            $count++;
        }
    }
}
