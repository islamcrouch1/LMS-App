<?php

namespace App;

use Codebyray\ReviewRateable\Contracts\ReviewRateable;
use Codebyray\ReviewRateable\Traits\ReviewRateable as ReviewRateableTrait;

use Illuminate\Database\Eloquent\Model;

use App\HomeWorkOrder;
use App\Course;
use App\User;
use App\HomeWorkComment;
use App\Country;



class HomeWork extends Model implements ReviewRateable
{

    use ReviewRateableTrait;

    protected $fillable = [
        'user_id', 'teacher_id', 'course_id', 'home_work_order_id' , 'student_note', 'teacher_note' , 'student_image' ,'teacher_image' , 'student_file' , 'teacher_file' , 'status', 'homework_title', 'recieve_time', 'country_id' , 'user_name' , 'teacher_name'
    ];




    public function home_work_comments()
    {
        return $this->hasMany(HomeWorkComment::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function home_work_order()
    {
        return $this->belongsTo(HomeWorkOrder::class);
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

    public function scopeWhenCourse($query , $course_id)
    {
        return $query->when($course_id , function($q) use($course_id) {
            return $q->where('course_id' , 'like' , "%$course_id%");
        });
    }



}
