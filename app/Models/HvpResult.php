<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HvpResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'guest_name',
        'part_1_ranking',
        'part_2_ranking',
        'scores',
    ];

    protected $casts = [
        'part_1_ranking' => 'array',
        'part_2_ranking' => 'array',
        'scores' => 'array',
    ];
    //
}
