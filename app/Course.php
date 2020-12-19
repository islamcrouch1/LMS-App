<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\EdClass;
use App\Chapter;
use App\Country;
use App\User;
use App\HomeWorkOrder;
use App\Teacher;
use App\CourseOrder;
use App\Exam;
use App\Monitor;





class Course extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name_en', 'name_ar', 'ed_class_id', 'image', 'description_ar' , 'description_en' , 'country_id', 'teacher_commission' , 'homework_price', 'course_price', 'status',
    ];
    public function ed_class()
    {
        return $this->belongsTo(EdClass::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class);
    }


    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    public function home_work_orders()
    {
        return $this->hasMany(HomeWorkOrder::class);
    }

    public function course_orders()
    {
        return $this->hasMany(CourseOrder::class);
    }

    public function home_works()
    {
        return $this->hasMany(HomeWork::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function exam()
    {
        return $this->hasOne(Exam::class);
    }

    public function monitors()
    {
        return $this->belongsToMany(Monitor::class);
    }

    public function scopeWhenSearch($query , $search)
    {
        return $query->when($search , function($q) use($search) {
            return $q->where('name_ar' , 'like' , "%$search%")
            ->orWhere('name_en' , 'like' , "%$search%");
        });
    }
}
