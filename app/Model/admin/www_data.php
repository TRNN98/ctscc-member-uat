<?php

namespace App\Model\admin;

use App\Helpers\LogActivity;
use Illuminate\Database\Eloquent\Model;

class www_data extends Model
{
    use LogActivity;

    protected $table = 'www_data';
    protected $primaryKey = 'No';
    public $timestamps = false;

    protected static $logAttributes = ['*'];

    protected static $logOnlyDirty = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'No',
        'Category',
        'Question',
        'Note',
        'Name',
        'Namer',
        'IP',
        'Email',
        'Reply',
        'ReplayDate',
        'Date',
        'nphoto',
        'ndata',
        'pageview',
        'nmedia',
        'DataDisable',
        'DataSort',
    ];
}
