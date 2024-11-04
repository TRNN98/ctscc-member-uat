<?php

namespace App\Model\admin;

use App\Helpers\LogActivity;
use Illuminate\Database\Eloquent\Model;

class www_ucf_manu extends Model
{
    use LogActivity;

    protected $table = 'www_ucf_manu';
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
        'seq', 'manu_name', 'url', 'is_parent', 'status'
    ];

    // protected $dispatchesEvents = [
    //     'deleted' => \App\Events\LineEvent::class,
    // ];

    public function submenu()
    {
        return $this->hasMany('App\Model\admin\www_ucf_sub_manu' , 'manu_id');
    }
}
