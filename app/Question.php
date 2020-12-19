<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Exam;
use App\User;

class Question extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'exam_id', 'question', 'answer1', 'answer2' , 'answer3', 'answer4' , 'true_answer' ,'answer_time' ,
    ];


    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }


    public function scopeWhenSearch($query , $search)
    {
        return $query->when($search , function($q) use($search) {
            return $q->where('question' , 'like' , "%$search%");
        });
    }

}
