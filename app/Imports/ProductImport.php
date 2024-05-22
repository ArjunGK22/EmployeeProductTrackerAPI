<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Throwable;

class ProductImport implements ToModel, WithHeadingRow, SkipsOnError
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {

        return new Product([
            'productname' => $row['name'],
            'price' => $row['price'],
            'quantity' => $row['quantity'],
        ]);
        
    }

    public function onError(Throwable $e)
    {
        
    }
}
