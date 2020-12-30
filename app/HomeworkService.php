<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HomeworkService extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'country_id', 'name_ar', 'name_en', 'description_ar', 'description_en' , 'price' , 'teacher_commission' ,
    ];



    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function home_work_orders()
    {
        return $this->belongsToMany(HomeWorkOrder::class);
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



}
