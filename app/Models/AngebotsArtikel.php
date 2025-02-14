<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AngebotsArtikel extends Model
{
    use HasFactory;

    protected $fillable = [
        'position_id', // Jede AngebotsArtikel gehört zu einer Position
        'artikel_id',
        'aktiv',
        'artikelbeschreibung',
        'image',
        'kategorie',
        'menge',
        'einzelpreis',
        'gesamtpreis',
    ];

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    // Beziehung zu Artikel
    public function artikel()
    {
        return $this->belongsTo(Artikel::class, 'artikel_id');
    }
}
