<?php

namespace App\Listeners;

use App\Repositories\OrderRepository;

class ChangeOrderListener
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        app(OrderRepository::class)->recalculateAmountOfTheOrder($event->order);
    }
}
