<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    public    $timestamps   = false;
    public    $incrementing = false;
    protected $table        = 'states';
    protected $primaryKey   = 'state_id';

    public function lgas()
    {
        return $this->hasMany(Lga::class, 'lga_id', 'state_id');
    }
}