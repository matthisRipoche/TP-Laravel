<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['title', 'release_year', 'synopsis'])]
class Film extends Model
{
    use HasFactory, Notifiable;

}
