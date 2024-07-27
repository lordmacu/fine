<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'client_name',
        'nit',
        'client_type',
        'payment_type',
        'email',
    ];

    public function observation()
    {
        return $this->hasOne(ClientObservation::class);
    }
}
