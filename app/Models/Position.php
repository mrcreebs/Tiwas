<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $fillable = [
        'angebot_id', // Annahme: Jede Position gehört zu einem Angebot
        'position',
        'rabatt',
        'kopftext',
        'fusstext',
    ];

    public function angebotsArtikel()
    {
        return $this->hasMany(AngebotsArtikel::class, 'position_id');
    }
}