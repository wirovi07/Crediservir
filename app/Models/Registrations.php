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
        'title',
        'input_type',
        'calculated_value',
        'purchase_date',
        'promotionalCodeApplied',
        'organizer_id',
        'event_id',
        'assistant_id',
        
    ];
}
