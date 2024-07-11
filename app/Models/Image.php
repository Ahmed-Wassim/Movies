<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['path'];

    public function path(): Attribute
    {
        return new Attribute(get: fn ($value) => 'https://image.tmdb.org/t/p/w500' . $value);
    }

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
