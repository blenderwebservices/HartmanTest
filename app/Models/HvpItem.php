<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class HvpItem extends Model
{
    use HasFactory;
    use HasTranslations;

    public $translatable = ['content'];

    protected $fillable = [
        'part',
        'content',
        'correct_order',
    ];
}
