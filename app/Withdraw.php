<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Country;

class Withdraw extends Model
{
    protected $fillable = [
        'user_id', 'amount', 'amount', 'code', 'status' , 'country_id', 'user_name',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }


    public function scopeWhenSearch($query , $search)
    {
        return $query->when($search , function($q) use($search) {
            return $q->Where('user_name' , 'like' , "%$search%");
        });
    }


    public function scopeWhenCountry($query , $country_id)
    {
        return $query->when($country_id , function($q) use($country_id) {
            return $q->where('country_id' , 'like' , "%$country_id%");
        });
    }

    public function scopeWhenStatus($query , $status)
    {
        return $query->when($status , function($q) use($status) {
            return $q->where('Status' , 'like' , "%$status%");
        });
    }

}
