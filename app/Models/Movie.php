<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'eid',
        'title',
        'description',
        'poster',
        'banner',
        'release_date',
        'vote',
        'vote_count'
    ];



    // scopes
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%');
            });
        });
        $query->when($filters['genre'] ?? false, function ($query, $genre) {
            $query->whereHas('genres', function ($query) use ($genre) {
                $query->where('name', $genre);
            });
        });
    }


    // accessors
    protected function poster(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => 'https://image.tmdb.org/t/p/w500' . $value,
        );
    }

    protected function banner(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => 'https://image.tmdb.org/t/p/w500' . $value,
        );
    }


    // relations
    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'genre_movie', 'movie_id', 'genre_id')->select('name');
    }

    public function actors(): BelongsToMany
    {
        return $this->belongsToMany(Actor::class, 'actor_movie', 'movie_id', 'actor_id');
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
