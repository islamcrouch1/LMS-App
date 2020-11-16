<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;

use App\Country;
use App\Order;
use App\post;

use App\Address;


class User extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use LaratrustUserTrait;
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','country_id','phone','gender','profile','type','role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
    ];


    public function getNameAttribute($value){
        return ucfirst($value);
    }



    public function scopeWhenSearch($query , $search)
    {
        return $query->when($search , function($q) use($search) {
            return $q->where('phone' , 'like' , "%$search%")
            ->orWhere('email' , 'like' , "%$search%")
            ->orWhere('name' , 'like' , "%$search%");
        });
    }

    public function scopeWhenRole($query , $role_id)
    {
        return $query->when($role_id , function($q) use($role_id) {
            return $this->scopeWhereRole($q ,$role_id );
        });
    }

    public function scopeWhenCountry($query , $country_id)
    {
        return $query->when($country_id , function($q) use($country_id) {
            return $q->where('country_id' , 'like' , "%$country_id%");
        });
    }

    public function scopeWhereRole($query , $role_name)
    {
        return $query->whereHas('roles' , function($q) use($role_name) {
            return $q->whereIn('name' , (array)$role_name)
            ->orWhereIn('id' , (array)$role_name);
        });
    }

    public function scopeWhereRoleNot($query , $role_name)
    {
        return $query->whereHas('roles' , function($q) use($role_name) {
            return $q->whereNotIn('name' , (array)$role_name)
            ->WhereNotIn('id' , (array)$role_name);
        });
    }


    public function country()
    {
        return $this->belongsTo(Country::class);
    }


    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
