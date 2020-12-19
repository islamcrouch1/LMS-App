<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

class BankInformation extends Model
{

    protected $fillable = [
        'user_id' , 'image1' , 'image2' , 'code' , 'full_name' , 'bank_account_number' , 'bank_name' ,
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }



}
