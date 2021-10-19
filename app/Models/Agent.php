<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    public    $timestamps   = false;
    protected $table        = 'agentname';
    protected $primaryKey   = 'name_id';

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'pollingunit_uniqueid', 'uniqueid');
    }
}