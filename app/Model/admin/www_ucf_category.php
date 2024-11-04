<?php

namespace App\Model\admin;

use App\Helpers\LogActivity;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Notifications\Notifiable;

class www_ucf_category extends Model
{
    use LogActivity;


    protected $table = 'www_ucf_category';
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
        'seq', 'category', 'description', 'hyper_link', 'type', 'status', "content_type"
    ];

    // protected $dispatchesEvents = [
    //     'deleted' => \App\Events\LineEvent::class,
    // ];

}
