<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Angebot extends Model
{
    use HasFactory;

    protected $fillable = ['kunde_id', 'datum', 'gesamtbetrag'];

    public function kunde()
    {
        return $this->belongsTo(Kunde::class);
    }

    public function positionen()
    {
        return $this->hasMany(Position::class)->orderBy('position');
    }

}