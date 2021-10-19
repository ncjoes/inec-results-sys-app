<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    public    $timestamps   = false;
    public    $incrementing = false;
    protected $table        = 'ward';
    protected $primaryKey   = 'uniqueid';

    public function lga()
    {
        return $this->belongsTo(Lga::class, 'lga_id', 'lga_id');
    }

    public function units()
    {
        return $this->hasMany(Unit::class, 'ward_id', 'polling_unit_id');
    }
}
