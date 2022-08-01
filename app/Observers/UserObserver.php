<?php

namespace App\Observers;

use App\Models\User;
use App\Notifications\ApprovalNotification;
use App\Notifications\CollectorNotification;
use App\Notifications\ManufactureNotification;

class UserObserver
{
   
   public function creating(User $user){
    if($user->ismanufacture){
            $user->notify(new ManufactureNotification($user));
        }
   }
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        if($user->iscollector){
            $user->notify(new CollectorNotification());
        }
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        if($user->isapproved){
            $user->notify(new ApprovalNotification());
        }
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
