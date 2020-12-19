<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Chapter;
use App\UserLesson;
use App\Exam;


class Lesson extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name_en', 'name_ar', 'chapter_id', 'description_ar', 'description_en' , 'path' , 'image','percent', 'country_id', 'type' , 'lesson_file' ,
    ];
    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function exam()
    {
        return $this->hasOne(Exam::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function user_lessons()
    {
        return $this->hasMany(UserLesson::class);
    }

    public function scopeWhenSearch($query , $search)
    {
        return $query->when($search , function($q) use($search) {
            return $q->where('name_ar' , 'like' , "%$search%")
            ->orWhere('name_en' , 'like' , "%$search%");
        });
    }
}
