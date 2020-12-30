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
use App\Exam;

use App\Question;

use App\Address;

use App\Teacher;

use Twilio\Rest\Client;

use App\HomeWorkOrder;

use App\HomeWork;

use App\BankInformation;

use App\Withdraw;

use App\HomeWorkComment;
use App\Report;
use App\Notification;
use App\CourseOrder;
use App\UserLesson;
use App\WalletRequest;


use App\ExamUser;
use App\Monitor;

use App\Wallet;





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
        'name', 'email', 'password','country_id','phone','gender','profile','type','role', 'parent_phone',
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

    protected $withCount = ['teachers'] ;




    public function getNameAttribute($value){
        return ucfirst($value);
    }

    public function wallet_requests()
    {
        return $this->hasMany(WalletRequest::class);
    }

    public function course_orders()
    {
        return $this->hasMany(CourseOrder::class);
    }
    public function user_lessons()
    {
        return $this->hasMany(UserLesson::class);
    }

        public function home_work_orders()
    {
        return $this->hasMany(HomeWorkOrder::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function home_works()
    {
        return $this->hasMany(HomeWork::class);
    }

    public function home_work_comments()
    {
        return $this->hasMany(HomeWorkComment::class);
    }


    public function reports()
    {
        return $this->hasMany(Report::class);
    }



    public function scopeWhenSearch($query , $search)
    {
        return $query->when($search , function($q) use($search) {
            return $q->where('phone' , 'like' , "%$search%")
            ->orWhere('email' , 'like' , "%$search%")
            ->orWhere('name' , 'like' , "%$search%");
        });
    }


    public function scopeWhenCountry($query , $country_id)
    {
        return $query->when($country_id , function($q) use($country_id) {
            return $q->where('country_id' , 'like' , "%$country_id%");
        });
    }


    public function scopeWhenRole($query , $role_id)
    {
        return $query->when($role_id , function($q) use($role_id) {
            return $this->scopeWhereRole($q ,$role_id );
        });
    }


    public function scopeWhenType($query , $type)
    {
        return $query->when($type , function($q) use($type) {
            return $q->where('type' , 'like' , "%$type%");
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

    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    public function monitors()
    {
        return $this->belongsToMany(Monitor::class);
    }

    public function monitor()
    {
        return $this->hasOne(Monitor::class);
    }

    public function bank_information()
    {
        return $this->hasOne(BankInformation::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function exam_user()
    {
        return $this->belongsTo(ExamUser::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }


    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class);
    }

    public function exams()
    {
        return $this->belongsToMany(Exam::class);
    }


    public function withdraws()
    {
        return $this->hasMany(Withdraw::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function hasVerifiedPhone()
    {
        return ! is_null($this->phone_verified_at);
    }

    public function markPhoneAsVerified()
    {
        return $this->forceFill([
            'phone_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }




            public function callToVerify()
            {
                $code = random_int(100000, 999999);

                $this->forceFill([
                    'verification_code' => $code
                ])->save();

                $client = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));

                $client->messages->create(
                    $this->phone, // to
                ["body" => "Your Verification Code Is : {$code}", "from" => "LMS"]
                 );
            }


            public function callToVerifyAdmin()
            {
                $code = random_int(100000, 999999);

                $this->forceFill([
                    'verification_code' => $code
                ])->save();

            }

            // create(
            //     $this->phone,
            //     "+15306658566", // REPLACE WITH YOUR TWILIO NUMBER
            //     ["url" => "http://your-ngrok-url>/build-twiml/{$code}"]
            // );
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
