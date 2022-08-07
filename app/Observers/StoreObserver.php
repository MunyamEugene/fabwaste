<?php

namespace App\Observers;

use App\Models\Store;
use App\Models\StoreHistory;

class StoreObserver
{
    /**
     * Handle the Store "created" event.
     *
     * @param  \App\Models\Store  $store
     * @return void
     */
    public function created(Store $store)
    {
        $history = new StoreHistory();
        $history->previousData=0;
        $history->changes= $store->how_many;
        $history->newData= $store->how_many;
        $history->store_id=$store->id;
        $history->save();
    }

    /**
     * Handle the Store "updated" event.
     *
     * @param  \App\Models\Store  $store
     * @return void
     */
    public function updated(Store $store)
    {
        $previous = StoreHistory::orderBy('updated_at', 'DESC')->first();
        if($previous!==null){
            $previous=Store::find($store->id-1);
        }
        $history = new StoreHistory();
        $history->previousData = $previous->newData;
        $history->changes = ($store->how_many-$previous->newData);
        $history->newData = $store->how_many;
        $history->store_id= $store->id;
        $history->save();

    }

    /**
     * Handle the Store "deleted" event.
     *
     * @param  \App\Models\Store  $store
     * @return void
     */
    public function deleted(Store $store)
    {
    }

    /**
     * Handle the Store "restored" event.
     *
     * @param  \App\Models\Store  $store
     * @return void
     */
    public function restored(Store $store)
    {
        //
    }

    /**
     * Handle the Store "force deleted" event.
     *
     * @param  \App\Models\Store  $store
     * @return void
     */
    public function forceDeleted(Store $store)
    {
        //
    }
}
