<?php

namespace App\Basket;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class HelpBasket extends Model
{
    use SoftDeletes;
    //
    protected $fillable = [
        'run','dv','other_identification',
        'name','fathers_family','mothers_family',
        'street_type','address','number','department',
        'telephone',
        'latitude','longitude',
        'photo', 'photoid',
        'observations',
        'commune_id',
        'institution_id'
    ];

    public function commune() {
        return $this->belongsTo('App\Commune');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function institution() {
        return $this->belongsTo('\App\HelpBasket\Institution');
    }

    public function scopeSearch($query, $search)
    {
        if ($search) {
            $query->where('name','LIKE', '%'.$search.'%')
                ->orWhere('fathers_family','LIKE', '%'.$search.'%')
                ->orWhere('mothers_family','LIKE', '%'.$search.'%')
                ->orWhere('run','LIKE', '%'.$search.'%')
                ->orWhere('other_identification','LIKE', '%'.$search.'%');
        }
    }

    function getFullNameAttribute(){
        return mb_strtoupper($this->name . ' ' . $this->fathers_family . ' ' . $this->mothers_family);
    }

    function getIdentifierAttribute() {
        if(isset($this->run) and isset($this->dv)) {
            return $this->run . '-' . $this->dv;
        }
        else  {
            return $this->other_identification;
        }
    }
}
