<?php

namespace App\Model\user;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\member;


class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'sc_confirm_register';

    protected $primaryKey = 'seq';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'membership_no', 'mem_email', 'phone_no', 'operate_date', 'mem_password', 'mem_confirm', 'mem_password_sha' , 'password_reset_status'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'mem_password', 'mem_password_sha'
    ];

    // public function getJWTIdentifier()
    // {
    //     return $this->getKey();
    // }

    // public function getJWTCustomClaims()
    // {
    //     return [];
    // }

    // public function setPasswordAttribute($password)
    // {
    //     if ( !empty($password) ) {
    //         $this->attributes['mem_password'] = md5($password);
    //     }
    // }

    public function getEmailForPasswordReset()
    {
        return $this->mem_email;
    }

    public function getAuthPassword()
    {
        // return $this->mem_password;
        return $this->mem_password_sha;
    }
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new member($token));
    }
}
