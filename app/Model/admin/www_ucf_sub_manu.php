<?php

namespace App\Model\admin;

use App\Helpers\LogActivity;
use Illuminate\Database\Eloquent\Model;

class www_ucf_sub_manu extends Model
{
    use LogActivity;

    protected $table = 'www_ucf_sub_manu';
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
        'seq', 'manu_id', 'cat_id', 'url', 'status'
    ];

    public function menu()
    {
        return $this->belongsTo('App\Model\admin\www_ucf_manu', 'seq');
    }
}
