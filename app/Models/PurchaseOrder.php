<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $fillable = [
        'client_id',
        'order_creation_date',
        'required_delivery_date',
        'order_consecutive',
        'observations',
        'delivery_address',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'purchase_order_product', 'purchase_order_id', 'product_id')
                    ->withPivot('quantity', 'price'); // Incluyendo cantidad y precio en la tabla pivote
    }
}
