<?php

namespace App\Model\member;

use Illuminate\Database\Eloquent\Model;

class www_memregis_logs extends Model
{
    //
    protected $table = 'www_memregis_logs';

    protected $primaryKey = 'seq';

    public $timestamps = false;


    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'Y-n-j H:i:s';

    const CREATED_AT = 'operate_date';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'membership_no', 'step', 'operate_date', 'type',
        'complete_status', 'agent', 'IP', 'password_sha', 'password', 'SESSION_TOKEN', "error_response", "error_code", "device"
    ];
}
