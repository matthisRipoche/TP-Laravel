<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Film extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'release_year', 'synopsis'];

    public function locations()
    {
        return $this->hasMany(Location::class);
    }
}
