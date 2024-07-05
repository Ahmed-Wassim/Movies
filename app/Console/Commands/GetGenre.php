<?php

namespace App\Console\Commands;

use App\Models\Genre;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class GetGenre extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:genres';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Getting All Genres From API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::table('genres')->truncate();
        $genres = Http::get(config('services.tmdb.url') . '/genre/movie/list?api_key=' . config('services.tmdb.key') . '&language=en-US')->json()['genres'];
        foreach ($genres as $genre) {
            Genre::firstOrCreate([
                'eid' => $genre['id'],
                'name' => $genre['name'],
            ]);
        }
    }
}