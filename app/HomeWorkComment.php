<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\HomeWork;
use App\User;



class HomeWorkComment extends Model
{


    protected $fillable = [
        'user_id', 'home_work_id', 'message', 'comment_file' , 'comment_image',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function home_work()
    {
        return $this->belongsTo(HomeWork::class);
    }
}
