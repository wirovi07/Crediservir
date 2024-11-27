<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Eventcategory extends Model
{
    use HasFactory;

    protected $table = 'event_categories';

    protected $fillable = [
        'event_id',
        'category_id',
    ];
}
