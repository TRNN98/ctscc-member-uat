<?php

namespace App\Model\admin;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Helpers\LogActivity;

class admin extends Authenticatable
{

    use Notifiable, LogActivity;


    protected $table = 'www_security_user';

    protected $primaryKey = 'seq';
    // protected $primaryKey = 'username';
    // protected $keyType = 'string';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'seq', 'description', 'username', 'password', 'password_sha'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'password_sha'
    ];

    protected static $logAttributes = ['description', 'username'];

    public function getAuthPassword()
    {
        // return $this->password;
        return $this->password_sha;
    }

    public function getPass()
    {
        return admin::all();
    }
}
