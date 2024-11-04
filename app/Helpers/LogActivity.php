<?php

namespace App\Helpers;

use Request;
use Jenssegers\Agent\Agent;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Support\Facades\Auth;

trait LogActivity
{
    use LogsActivity;

    public function tapActivity(Activity $activity, string $eventName)
    {
        $agent = new Agent();
        $device = $agent->device();
        $platform = $agent->platform();
        $browser = $agent->browser();
        $browser_ver = $agent->version($browser);
        $platform_ver = $agent->version($platform);
        $client_name  = $device . " " . $browser . " " . $browser_ver . " on " . $platform . " " . $platform_ver;

        $activity->url = Request::fullUrl();
        $activity->method = Request::method();
        $activity->ip = Request::ip();
        $activity->agent = $client_name;
        // $activity->agent = Request::header('user-agent');
        $activity->user_id = Auth::guard('admin')->check() ? Auth::guard('admin')->user()->seq : null;
    }
}
