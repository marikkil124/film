<?php

namespace App\Observers;

use App\Models\Promocode;

class PromocodeObserver
{
    /**
     * Handle the Promocode "created" event.
     */
    public function created(Promocode $promocode): void
    {
        //
    }

    /**
     * Handle the Promocode "updated" event.
     */
    public function updated(Promocode $promocode): void
    {
        //
    }

    /**
     * Handle the Promocode "deleted" event.
     */
    public function deleted(Promocode $promocode): void
    {
        //
    }

    /**
     * Handle the Promocode "restored" event.
     */
    public function restored(Promocode $promocode): void
    {
        //
    }

    /**
     * Handle the Promocode "force deleted" event.
     */
    public function forceDeleted(Promocode $promocode): void
    {
        //
    }
}
