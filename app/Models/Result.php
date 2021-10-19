<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    public    $timestamps = false;
    protected $table      = 'announced_pu_results';
    protected $primaryKey = 'result_id';

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'polling_unit_uniqueid', 'uniqueid');
    }
}