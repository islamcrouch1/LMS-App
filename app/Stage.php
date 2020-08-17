<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\LearningSystem;
use App\EdClass;

class Stage extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name_en', 'name_ar', 'learning_system_id',
    ];
    public function learning_system()
    {
        return $this->belongsTo(LearningSystem::class);
    }

    public function ed_classes()
    {
        return $this->hasMany(EdClass::class);
    }

    public function scopeWhenSearch($query , $search)
    {
        return $query->when($search , function($q) use($search) {
            return $q->where('name_ar' , 'like' , "%$search%")
            ->orWhere('name_en' , 'like' , "%$search%");
        });
    }
}
