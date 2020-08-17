<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Country;
use App\Stage;


class LearningSystem extends Model
{

    use SoftDeletes;


    protected $fillable = [
        'name_en', 'name_ar', 'description_en','description_ar','image','country',
    ];



    public function scopeWhenSearch($query , $search)
    {
        return $query->when($search , function($q) use($search) {
            return $q->where('name_ar' , 'like' , "%$search%")
            ->orWhere('name_en' , 'like' , "%$search%");
        });
    }

    public function countries()
    {
        return $this->belongsToMany(Country::class);
    }

    public function stages()
    {
        return $this->hasMany(stage::class);
    }
}


