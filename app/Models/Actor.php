<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Actor extends Model
{
    use HasFactory;

    protected $fillable = ['eid', 'name', 'image'];


    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        });

        $query->when($filters['genre'] ?? false, function ($query, $genre) {
            $query->whereHas('genres', function ($query) use ($genre) {
                $query->where('name', $genre);
            });
        });
    }


    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'actor_movie', 'actor_id', 'movie_id');
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => 'https://image.tmdb.org/t/p/w500' . $value,
        );
    }
}
