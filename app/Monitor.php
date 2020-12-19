<?php

namespace App;

use App\User;
use App\Country;
use App\Course;

use Illuminate\Database\Eloquent\Model;

class Monitor extends Model
{
    protected $fillable = [
        'user_id' ,
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function countries()
    {
        return $this->belongsToMany(Country::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(User::class);
    }

}
