<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Registrations extends Model
{
    use HasFactory;

    protected $table = 'registrations';

    protected $fillable = [
        'type_input',
        'calculated_value',
        'purchase_date',
        'code_promotional',
        'user_id',
        'assistant_id',
        'event_id',
        
    ];
}
