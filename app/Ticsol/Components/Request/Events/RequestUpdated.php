<?php

namespace App\Ticsol\Components\Request\Events;

use App\Ticsol\Components\Models\Request as RequestModel;;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class RequestUpdated implements ShouldBroadcast
{
    use SerializesModels;

    public $request;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(RequestModel $request)
    {
        $this->request = $request;
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'User.Update';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'resName' => 'request',
            'event' => 'request_updated',
            'type' => $this->request->type,
            'id' => $this->request->id,
            'assigned_id' => $this->request->assigned_id,
            'title' => $this->request->id
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        if ($this->request->assigned_id != null) {
            return [
                new PrivateChannel('App.Users.' . $this->request->user_id),
                new PrivateChannel('App.Users.' . $this->request->assigned_id),
            ];
        } else {
            return [
                new PrivateChannel('App.Users.' . $this->request->user_id)
            ];
        }        
    }
}
