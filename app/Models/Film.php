<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'release_year', 'synopsis'];

    public function locations()
    {
        return $this->hasMany(Location::class);
    }
}
