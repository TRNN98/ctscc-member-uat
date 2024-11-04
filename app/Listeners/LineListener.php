<?php

namespace App\Listeners;

use App\Events\LineEvent;
use App\Helpers\LineNotify;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;

class LineListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  LineEvent  $event
     * @return void
     */
    public function handle(LineEvent $event)
    {
        $line = new LineNotify();
        $replyData = new TextMessageBuilder('testsetset');
        $res = $line->broadcast($replyData);

        if ($line->send($res)) {
            app('log')->info('sent line : success');
        }
        //
        // $event->category;
    }
}
