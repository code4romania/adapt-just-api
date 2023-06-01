<?php

namespace App\Listeners;

use App\Events\UserCreatedEvent;
use App\Models\User;
use App\Notifications\SetUpPasswordNotification;
use Illuminate\Events\Dispatcher;

class UserEventSubscriber
{

    /**
     * Handle user create events.
     */
    public function handleCreate($event)
    {
        if ($event->user instanceof User) {
            $event->user->notify(new SetUpPasswordNotification());
        }
    }


    /**
     * Register the listeners for the subscriber.
     *
     * @param Dispatcher $events
     * @return void
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(UserCreatedEvent::class, [UserEventSubscriber::class, 'handleCreate'] );
    }
}
