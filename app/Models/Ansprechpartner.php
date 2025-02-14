<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Ansprechpartner extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kunde_id',
        'position',
        'titel',
        'vorname',
        'nachname',
        'email',
        'ort',
        'street',
        'zip',
        'mobil',
        'tel',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'kunde_id' => 'integer',
    ];

    /**
     * Get the kunde that owns the ansprechpartner.
     */
    public function kunde(): BelongsTo
    {
        return $this->belongsTo(Kunde::class);
    }

    public function title()
    {
        return $this->belongsTo(Title::class);
    }

   
}
