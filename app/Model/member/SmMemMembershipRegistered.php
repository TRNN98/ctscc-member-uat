<?php

namespace App\Model\member;

use Illuminate\Database\Eloquent\Model;

class SmMemMembershipRegistered extends Model
{
    protected $table = 'sm_mem_m_membership_registered';

    protected $primaryKey = 'MEMBERSHIP_NO';

    public $timestamps = false;

}
