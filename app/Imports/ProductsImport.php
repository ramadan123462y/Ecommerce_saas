<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductsImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Product([
            'name' => $row[1],
            'slug' => $row[2],
            'original_price' => $row[3],
            'selling_price' => $row[4],
            'description' => $row[5],
            'small_description' => $row[6],
            'quantity' => $row[7],
            'trending' => !isset($row[8]) ? 0 : 1,
            'status' => $row[9],
            'meta_title' => $row[10],
            'meta_keyword' => $row[11],
            'meta_descreption' => $row[12],
            'store_id' => $row[13],
            'categorie_id' => $row[14],
        ]);
    }
}
