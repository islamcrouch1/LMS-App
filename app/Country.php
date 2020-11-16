<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\LearningSystem;
use App\User;
use App\Address;




class Country extends Model
{
    use SoftDeletes;


    protected $fillable = [
        'name_en', 'name_ar', 'code','currency','image',
    ];



    public function scopeWhenSearch($query , $search)
    {
        return $query->when($search , function($q) use($search) {
            return $q->where('name_ar' , 'like' , "%$search%")
            ->orWhere('name_en' , 'like' , "%$search%");
        });
    }


    public function learning_systems()
    {
        return $this->belongsToMany(LearningSystem::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
