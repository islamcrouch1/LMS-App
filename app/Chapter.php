<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Course;
use App\Lesson;



class Chapter extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name_en', 'name_ar', 'course_id',
    ];
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function scopeWhenSearch($query , $search)
    {
        return $query->when($search , function($q) use($search) {
            return $q->where('name_ar' , 'like' , "%$search%")
            ->orWhere('name_en' , 'like' , "%$search%");
        });
    }
}
