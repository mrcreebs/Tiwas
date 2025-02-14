<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Kunde extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'is_business',
        'titel',
        'vorname',
        'nachname',
        'bname',
        'tel',
        'mobil',
        'email',
        'ort',
        'street',
        'zip',
        'www',
        'bank',
        'iban',
        'bic',
        'disc',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'is_business' => 'boolean',
    ];

    /**
     * Get the ansprechpartner records associated with the kunde.
     */
    public function ansprechpartner(): HasMany
    {
        return $this->hasMany(Ansprechpartner::class);
    }

    public function title()
    {
        return $this->belongsTo(Title::class);
    }

    public function getFullNameAttribute()
{
    if ($this->is_business) {
        if (!empty($this->vorname) && !empty($this->nachname) && !empty($this->bname)) {
            return "{$this->nachname}, {$this->vorname} ({$this->bname})";
        } elseif (!empty($this->bname)) {
            return $this->bname;
        } else {
            return "{$this->vorname} {$this->nachname}";
        }
    } else {
        return "{$this->vorname} {$this->nachname}";
    }
}
    

}
