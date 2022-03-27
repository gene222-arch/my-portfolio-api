<?php 
namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadService 
{
    public function upload(Request $request, string $key, string $directory = 'images'): string
    {
        $path = '';
        
        if ($request->hasFile($key))
        {
            $file = $request->file($key);

            $originalFilename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $fileName = pathinfo($originalFilename, PATHINFO_FILENAME);

            $newFileName = $fileName .'-'. time() . ".${extension}";
            $path = $directory . $newFileName;

            $path = $file->storeAs($directory, $newFileName, 's3');
        }

        return Storage::disk('s3')->url($path);
    }
}