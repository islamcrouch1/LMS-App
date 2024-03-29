<?php

namespace App;

use Laratrust\Models\LaratrustRole;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends LaratrustRole
{
    use SoftDeletes;
    public $guarded = [];

    protected $fillable = [
        'name', 'description',
    ];

    public function scopeWhenSearch($query , $search)
    {
        return $query->when($search , function($q) use($search) {
            return $q->where('name' , 'like' , "%$search%");
        });
    }



    public function scopeWhereRoleNot($query , $role_name)
    {
        return $query->whereNotIn('name' , (array)$role_name);
    }
}
