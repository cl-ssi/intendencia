<?php

namespace App\SanitaryResidence;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Room
 *
 * @mixin Builder
 */
class Room extends Model
{

    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number','floor','description', 'residence_id'
    ];

    public function residence() {
        return $this->belongsTo('App\SanitaryResidence\Residence');
    }

    public function bookings() {
        return $this->hasMany('App\SanitaryResidence\Booking');
    }
}
