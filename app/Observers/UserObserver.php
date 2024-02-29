<?php

namespace App\Observers;

use App\Models\Profile;
use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        Profile::create(
            [
                'user_id' => $user->id,
            ]
        );
    }
//    public function creating(User $user): void
//    {
//        Profile::create(['user_id' => $user->id]);
//    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }
    public function updating(User $user): void
    {

    }
    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {

        $user->profile()->delete();
    }

    public function deleting(User $user): void
    {

        $user->profile()->delete();
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
