<?php

namespace App\Listeners;

use App\Events\UserUpdated;

class SendUserUpdateNotification
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
     * @param UserUpdated $event
     *
     * @return void
     */
    public function handle(UserUpdated $event)
    {
        // Access the order using $event->order...

    }
}