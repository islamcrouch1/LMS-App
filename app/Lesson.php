<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Chapter;

class Lesson extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name_en', 'name_ar', 'chapter_id', 'description_ar', 'description_en' , 'path' , 'image','percent',
    ];
    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function scopeWhenSearch($query , $search)
    {
        return $query->when($search , function($q) use($search) {
            return $q->where('name_ar' , 'like' , "%$search%")
            ->orWhere('name_en' , 'like' , "%$search%");
        });
    }
}
