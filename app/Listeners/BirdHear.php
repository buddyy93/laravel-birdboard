<?php

namespace App\Listeners;

use App\Events\BirdRegistered;

class BirdHear
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
        var_dump('i heard it');
    }
}
