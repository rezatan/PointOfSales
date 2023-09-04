<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function purchase()
    {
        return $this->hasMany(Purchase::class);
    }
}
