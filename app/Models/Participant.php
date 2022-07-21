<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'restaurant_number',
        'leader_name',
        'members_number',
        'custom_id',
        'status',
        'location',
        'file_name',
        'accepted_tos'
    ];
}
