<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promotionalcodes extends Model
{
    use HasFactory;

    protected $table = 'promotional_codes';

    protected $fillable = [
        'code',
        'discount',
        'start_date',
        'end_date',
        'status',
    ];
}
