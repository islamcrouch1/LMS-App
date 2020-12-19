<?php

namespace App;

use Codebyray\ReviewRateable\Contracts\ReviewRateable;
use Codebyray\ReviewRateable\Traits\ReviewRateable as ReviewRateableTrait;

use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Course;


class Teacher extends Model implements ReviewRateable
{
    use ReviewRateableTrait;

    protected $fillable = [
        'description_ar', 'description_en' , 'study_plan' , 'image','percent', 'path', 'user_id' , 'status' , 'average' ,
    ];

    protected $appends = ['is_favored'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function users()
    {
        return $this->belongsToMany(User::class);
    }


    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function getIsFavoredAttribute()
    {
        if (auth()->user()) {



            return (bool)$this->users()->where('user_id', auth()->user()->id)->count();
        }//end of if

        return false;

    }// end of getIsFavoredAttribute


    public function scopeWhenFavorite($query, $favorite)
    {
        return $query->when($favorite, function ($q) {

            return $q->whereHas('users', function ($qu) {

                return $qu->where('user_id', auth()->user()->id);
            });

        });

    }// end of scopeWhenFavorite
}
