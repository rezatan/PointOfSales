<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        if (! $product->code) {
            $product->code = 'P' . str_pad($product->id, 5, '0', STR_PAD_LEFT);
        }
        $product->save();
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updating(Product $product): void
    {
        if (! $product->code) {
            $product->code = 'P' . str_pad($product->id, 5, '0', STR_PAD_LEFT);
        }
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        //
    }
}
