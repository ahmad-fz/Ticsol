<?php

namespace App\Ticsol\Components\Schedule\Events;

use App\Ticsol\Components\Models\Schedule;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class ScheduleDeleted implements ShouldBroadcastNow
{
    use SerializesModels;

    private $id;
    private $clientId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($id, $clientId)
    {
        $this->id = $id;
        $this->clientId = $clientId;
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'Client.Update';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'resName' => 'schedule',
            'id' => $this->id,
            'title' => "Scheduled item deleted successfuly.",
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('App.Clients.' . $this->clientId);
    }
}
