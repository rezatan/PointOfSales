<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetails extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['stock', 'purchase'];
    
    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
    
}
