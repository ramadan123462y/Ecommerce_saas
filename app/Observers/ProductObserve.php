<?php

namespace App\Observers;

use App\Http\Traits\FileTrait;
use App\Models\Product;

class ProductObserve
{

    public function deleted(Product $product): void
    {
        $result = FileTrait::delete_file(public_path("storage/Images/Products/$product->file_name"));
    }

}
