<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    public    $timestamps   = false;
    public    $incrementing = false;
    protected $table        = 'polling_unit';
    protected $primaryKey   = 'uniqueid';

    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_id', 'ward_id');
    }

    public function lga()
    {
        return $this->belongsTo(Lga::class . 'lga_id', 'lga_id');
    }

    public function agents()
    {
        $this->hasMany(Agent::class, 'pollingunit_uniqueid', 'uniqueid');
    }
}