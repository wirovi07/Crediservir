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
        'birthdate',
        'email',
        'phone',
        'user_id'
    ];
}
