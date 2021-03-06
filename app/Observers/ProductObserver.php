<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function created(Product $product)
    {
        //
    }



    public function updating()
    {
        if(auth()->user()->cannot('create update products')) return false;
    }



    /**
     * Handle the Product "updated" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function updated(Product $product)
    {
        //
    }



    public function deleting(Product $product)
    {
        if(auth()->user()->cannot('delete products')) return false;

        // Geçmişte veya aktif bir iş emri varsa
        if($product->workorders()->exists()) return false;

        // herhangi bir sevk emri ile gittiyse
        if($product->dispatchProducts()->exists()) return false;

        // stok giriş çıkış hareketi olduysa
        if($product->stockmoves()->exists()) return false;
    }



    /**
     * Handle the Product "deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function deleted(Product $product)
    {
        //
    }


    


    /**
     * Handle the Product "restored" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function restored(Product $product)
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function forceDeleted(Product $product)
    {
        //
    }
}
