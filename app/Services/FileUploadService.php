<?php 
namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadService 
{
    public function upload(Request $request, string $key, string $directory = ''): string
    {
        $path = '';
        
        if ($request->hasFile($key))
        {
            $file = $request->file($key);

            $originalFilename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $fileName = pathinfo($originalFilename, PATHINFO_FILENAME);

            $path = $directory . $fileName .'-'. time() . ".${extension}";
            
            Storage::disk('s3')->put($path, $file);
        }

        return Storage::disk('s3')->url($path);
    }
}