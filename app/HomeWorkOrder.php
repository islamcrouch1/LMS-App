<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Course;
use App\User;
use App\HomwWork;

class HomeWorkOrder extends Model
{

    protected $fillable = [
        'user_id', 'teacher_id', 'course_id', 'quantity', 'total_price' , 'orderid' , 'status', 'country_id' , 'user_name' , 'teacher_name', 'wallet_balance' ,
    ];



    public function course()
    {
        return $this->belongsTo(Course::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function home_works()
    {
        return $this->hasMany(HomeWork::class);
    }

    public function homework_services()
    {
        return $this->belongsToMany(HomeworkService::class);
    }


    public function country()
    {
        return $this->belongsTo(Country::class);
    }


    public function scopeWhenSearch($query , $search)
    {
        return $query->when($search , function($q) use($search) {
            return $q->Where('user_name' , 'like' , "%$search%")
            ->orWhere('teacher_name' , 'like' , "%$search%");
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
