<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Title extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name'];

    public function kundes()
    {
        return $this->hasMany(Kunde::class);
    }

    public function ansprechpartner()
    {
        return $this->hasMany(Ansprechpartner::class);
    }
}
