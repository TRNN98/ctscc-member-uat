<?php

namespace App\Model\admin;

use App\Helpers\LogActivity;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Notifications\Notifiable;

class www_mobile_send_msg extends Model
{
    use LogActivity;


    protected $table = 'www_mobile_send_msg';
    protected $primaryKey = 'seq';
    public $timestamps = false;

    protected static $logAttributes = ['*'];

    protected static $logOnlyDirty = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'seq', 'title', 'message', 'member_ref', 'operate_date', 'status_confirm', "status", "publish_status"
    ];

    // protected $dispatchesEvents = [
    //     'deleted' => \App\Events\LineEvent::class,
    // ];

}
