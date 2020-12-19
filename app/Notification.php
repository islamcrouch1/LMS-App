<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

class Notification extends Model
{


    protected $fillable = [
        'user_id', 'user_name', 'user_image', 'title_ar', 'body_ar' , 'date', 'url', 'title_en','body_en','status',
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
