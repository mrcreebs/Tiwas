<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Artikel extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'artikelnummer',
        'aktiv',
        'name',
        'disc',
        'image',
        'price',
        'anzahl',
        'kategorie',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'aktiv' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function artikel()
    {
        return $this->hasMany(AngebotsArtikel::class);
    }
}
