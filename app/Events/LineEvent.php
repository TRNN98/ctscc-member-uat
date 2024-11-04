<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Model\admin\www_ucf_category;
use App\Notifications\LineNotification;
use Illuminate\Support\Facades\Notification;

class LineEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $category;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($category)
    {
        // dd($category);
        $this->category = $category;
    }

    // public function log()
    // {
    //     app('log')->info($this->category);

    //     $this->category->notify(new LineNotification('testset'));

    //     // Notification::send($category, new LineNotification('testset'));
    // }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('notification');
    }

    public function broadcastWith()
    {
        return [
            'title' => $this->category["category"],
            'body'  => $this->category["description"],
        ];
    }
}
