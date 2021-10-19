<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $data)
 */
class Result extends Model
{
    public    $timestamps = false;
    protected $table      = 'announced_pu_results';
    protected $primaryKey = 'result_id';
    protected $fillable   = [
        'polling_unit_uniqueid',
        'party_abbreviation',
        'party_score',
        'entered_by_user',
        'date_entered',
        'user_ip_address',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'polling_unit_uniqueid', 'uniqueid');
    }
}