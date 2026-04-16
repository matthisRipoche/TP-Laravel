<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Upvote extends Model
{
    protected $fillable = ['user_id', 'location_id'];
}
