<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cashier extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
