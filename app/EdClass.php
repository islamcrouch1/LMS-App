<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Stage;
use App\Course;

class EdClass extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name_en', 'name_ar', 'stage_id',
    ];
    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function scopeWhenSearch($query , $search)
    {
        return $query->when($search , function($q) use($search) {
            return $q->where('name_ar' , 'like' , "%$search%")
            ->orWhere('name_en' , 'like' , "%$search%");
        });
    }
}
