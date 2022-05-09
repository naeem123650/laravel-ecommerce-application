<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait Uploadable
{
    public function uploadOne(UploadedFile $file,$folder,$disk = 'public',$fileName = null)
    {
        $nameOfFile = !is_null($fileName) ? $fileName : Str::random(25);

        $fileNameWithExtension = $nameOfFile.".".$file->getClientOriginalExtension();

        return $file->storeAs($folder,$fileNameWithExtension,$disk);

        // return $fileNameWithExtension;
    }

    public function deleteOne($path,$disk = 'public')
    {
        Storage::disk($disk)->delete($path);
    }
}
