<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Waitinglist extends Model
{
    use HasFactory;

    protected $table = 'waitinglist';

    protected $fillable = [
        'registration_date',
        'event_id',
        'assistant_id',
    ];
}
