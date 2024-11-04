<?php

namespace App\Model\admin;

use App\Helpers\LogActivity;
use Illuminate\Database\Eloquent\Model;

class www_data_img extends Model
{
    use LogActivity;
    //
    protected $table = 'www_data_img';
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
        'seq',
        'No',
        'path_img',
    ];
}
