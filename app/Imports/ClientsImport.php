<?php

namespace App\Imports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ClientsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Client([
            'client_name' => $row['client_name'],
            'nit' => $row['nit'],
            'client_type' => $row['client_type'],
            'payment_type' => $row['payment_type'],
            'email' => $row['email'],
        ]);
    }
}
