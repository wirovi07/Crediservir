<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory;

    protected $table = 'event';

    protected $fillable = [
        'title',
        'description',
        'date',
        'hour',
        'place',
        'availabl_space',
        'type',
        'base_value',
        'opening_date',
        'closing_date',
        'organizer_id',
    ];
}
