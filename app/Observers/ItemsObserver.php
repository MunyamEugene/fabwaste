<?php

namespace App\Observers;

use App\Models\CollectedItem;
use App\Models\History;

class ItemsObserver
{

    
    public function created(CollectedItem $collectedItem)
    {
        $history= new History();
        $history->oldNumber=0;
        $history->newNumber= $collectedItem->quantity;
        $history->remainNumber= $collectedItem->quantity;
        $history->collected_item_id=$collectedItem->id;
        $history->save();
    }


    /**
     * Handle the CollectedItem "updated" event.
     *
     * @param  \App\Models\CollectedItem  $collectedItem
     * @return void
     */
    public function updated(CollectedItem $item)
    {
        $previous=History::orderBy('updated_at','DESC')->first();
        $history = new History();
        $history->oldNumber = $previous->remainNumber;
        $history->newNumber = ($item->quantity-$previous->remainNumber);
        $history->remainNumber = $item->quantity;
        $history->collected_item_id= $item->id;
        $history->save();
    }

    /**
     * Handle the CollectedItem "deleted" event.
     *
     * @param  \App\Models\CollectedItem  $collectedItem
     * @return void
     */
    public function deleted(CollectedItem $item)
    {
        //
    }

    /**
     * Handle the CollectedItem "restored" event.
     *
     * @param  \App\Models\CollectedItem  $collectedItem
     * @return void
     */
    public function restored(CollectedItem $collectedItem)
    {
        //
    }

    /**
     * Handle the CollectedItem "force deleted" event.
     *
     * @param  \App\Models\CollectedItem  $collectedItem
     * @return void
     */
    public function forceDeleted(CollectedItem $collectedItem)
    {
        //
    }
}
