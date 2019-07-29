<?php

namespace App\Listeners;

use App\Events\BirdRegistered;

class BirdTell
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
     * @param BirdRegistered $event
     * @return void
     */
    public function handle(BirdRegistered $event)
    {
        var_dump('this is black magic!');
    }
}
