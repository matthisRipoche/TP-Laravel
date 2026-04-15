<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'city', 'country', 'description', 'film_id', 'user_id', 'upvotes_count'])]
class Location extends Model
{
    use HasFactory, Notifiable;

}
