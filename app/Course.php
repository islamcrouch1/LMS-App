<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\EdClass;
use App\Chapter;


class Course extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name_en', 'name_ar', 'ed_class_id', 'image', 'description_ar' , 'description_en' ,
    ];
    public function ed_class()
    {
        return $this->belongsTo(EdClass::class);
    }


    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    public function scopeWhenSearch($query , $search)
    {
        return $query->when($search , function($q) use($search) {
            return $q->where('name_ar' , 'like' , "%$search%")
            ->orWhere('name_en' , 'like' , "%$search%");
        });
    }
}
