<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Category;
use App\Order;
use App\Cart;



class Product extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name_en', 'name_ar', 'image', 'description_ar' , 'description_en' , 'type' , 'purchase_price' , 'sale_price' , 'category_id' , 'stock' , 'down_link' ,
    ];

    protected $appends = ['profit_percent'];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    public function carts()
    {
        return $this->belongsToMany(Cart::class);
    }



    public function scopeWhenSearch($query , $search)
    {
        return $query->when($search , function($q) use($search) {
            return $q->where('name_ar' , 'like' , "%$search%")
            ->orWhere('name_en' , 'like' , "%$search%");
        });
    }

    public function getProfitPercentAttribute(){
        $profit = $this->sale_price - $this->purchase_price ;
        $profit_percent = $profit * 100 / $this->purchase_price ;
        return number_format($profit_percent , 2) ;
    }




    public function scopeWhenCategory($query , $category_id)
    {
        return $query->when($category_id , function($q) use($category_id) {
            return $q->where('category_id' , 'like' , "%$category_id%");
        });
    }



}
