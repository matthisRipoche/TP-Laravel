<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'city', 'country', 'description', 'film_id', 'user_id', 'upvotes_count'])]
class Location extends Model
{
    use HasFactory, Notifiable;

}
