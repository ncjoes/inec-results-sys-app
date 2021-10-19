<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    public    $timestamps   = false;
    public    $incrementing = false;
    protected $table        = 'party';
    protected $primaryKey   = 'partyid';
}