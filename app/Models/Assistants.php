<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assistants extends Model
{
    use HasFactory;

    protected $table = 'assistants';

    protected $fillable = [
        'first_name',
        'last_name',
        'date_birth',
        'email',
        'phone_number',
        'organizer_id'
    ];
}