<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lga extends Model
{
    public    $timestamps   = false;
    protected $table        = 'lga';
    protected $primaryKey   = 'uniqueid';

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function wards()
    {
        return $this->hasMany(Ward::class, 'lga_id', 'lga_id')->orderBy('ward_id');
    }

    public function units()
    {
        return $this->hasMany(Unit::class, 'lga_id', 'lga_id')->orderBy('polling_unit_name');
    }
}