<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Storage;

trait FileTrait
{


    public static function save_file($file_name, $request, $folder, $disk)
    {

        $file = $request->file($file_name);
        $file->storeAs($folder, $file->getClientOriginalName(), 'Images');
        return true;
    }


    public static function delete_file($path)
    {

        if (is_file($path)) {
            unlink($path);
            return true;
        } else {

            return false;
        }
    }
}
