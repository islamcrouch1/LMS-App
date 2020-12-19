<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use User\User;
use User\Lesson;


class UserLesson extends Model
{

    protected $fillable = [
        'user_id', 'lesson_id', 'watched', 'course_id' ,
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }


}
