<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderProduct extends Model
{
    protected $fillable = [
        'purchase_order_id',
        'product_name',
        'price',
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }
}
