<?php

namespace App\Model\member\api;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
// use App\Notifications\member;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Member extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $table = 'sc_confirm_register';

    protected $primaryKey = 'seq';

    public $timestamps = false;

    public function MemRegis()
    {
        return $this->belongsTo('App\Model\member\SmMemMembershipRegistered', 'membership_no' , 'membership_no');
    }

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'membership_no','mem_email','mem_password_sha','mem_confirm','operate_date','phone_no','mem_password',
        'terms_and_conditions_approve', 'password_reset_status'
     ];
    /**
     * The attributes that should be hidden for arrays.
    *
    * @var array
    */
    protected $hidden = [
        'mem_password','mem_password_sha','mem_confirm'
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
    *
    * @return mixed
    */
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

    public function getAuthPassword()
    {
        return $this->mem_password_sha;
    }

}
