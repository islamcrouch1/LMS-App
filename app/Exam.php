<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Lesson;
use App\Course;
use App\Question;
use App\User;
use App\ExamUser;

class Exam extends Model
{
    protected $fillable = [
        'lesson_id' , 'course_id',
    ];


    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function exam_user()
    {
        return $this->belongsToMany(ExamUser::class);
    }

}
