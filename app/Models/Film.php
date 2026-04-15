<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'release_year', 'synopsis'])]
class Film extends Model
{
    use HasFactory, Notifiable;

}
