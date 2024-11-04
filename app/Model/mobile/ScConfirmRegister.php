<?php

namespace App\Model\mobile;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class ScConfirmRegister extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'sc_confirm_register';

    protected $primaryKey = 'seq';

    public $timestamps = false;

    public function MemRegis()
    {
        return $this->belongsTo('App\Model\member\SmMemMembershipRegistered', 'membership_no', 'membership_no');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'membership_no', 'mem_email', 'mem_confirm', 'operate_date', 'phone_no', 'mem_password','mem_password_sha'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'mem_password', 'mem_password_sha'
    ];

    /**
     * Find the user instance for the given username.
     *
     * @param  string  $username
     * @return \App\User
     */
    public function findForPassport($username)
    {
        return $this->where('membership_no', $username)->first();
    }

    /**
     * Validate the password of the user for the Passport password grant.
     *
     * @param  string  $password
     * @return bool
     */
    public function validateForPassportPasswordGrant($password)
    {
        $envsecret = config('auth.SECRET_AUTH');
        $plain = hash_hmac('sha256', $password, $envsecret);

        return $plain === $this->mem_password_sha ? true : false;

        // return md5($password) === $this->mem_password ? true : false;
    }

    public function getAuthPassword()
    {
        return $this->mem_password_sha;
    }
}
