<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

use App\WalletRequest;

class Wallet extends Model
{
    protected $fillable = [
        'user_id', 'balance',
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wallet_requests()
    {
        return $this->hasMany(WalletRequest::class);
    }


}
