<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


use App\User;
use App\Product;
use App\Address;

class Order extends Model
{

    use SoftDeletes;


    protected $fillable = [
        'total_price', 'address_id' , 'status' ,
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }


    public function scopeWhenSearch($query , $search)
    {
        return $query->when($search , function($q) use($search) {
            return $q->where('id' , 'like' , "%$search%")
            ->orWhere('total_price' , 'like' , "%$search%");
        });
    }


    public function scopeWhenUser($query , $request)
    {

        return $query->when($request , function($q) use($request) {
            return $q->where('name' , 'like' , "%$request%");
        });
    }
}
