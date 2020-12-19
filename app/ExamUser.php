<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Exam;
use App\User;

class ExamUser extends Model
{
    protected $fillable = [
        'user_id' , 'exam_id', 'result' ,
    ];


    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }



    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
