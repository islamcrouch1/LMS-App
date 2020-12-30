<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Wallet;

class WalletRequest extends Model
{
    protected $fillable = [
        'user_id', 'wallet_id', 'status' , 'request_ar' , 'waller_en' , 'balance' , 'request_en', 'orderid' ,
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wallet()
    {
        return $this->belongsTo(User::class);
    }
}
