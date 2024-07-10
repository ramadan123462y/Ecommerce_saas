<?php

namespace App\Observers;

use App\Http\Traits\FileTrait;
use App\Models\Categorie;

class CategorieObserve
{

    public function forceDeleted(Categorie $categorie): void
    {
        $result = FileTrait::delete_file(public_path("storage/Images/Categories/$categorie->file_name"));
    }
}
