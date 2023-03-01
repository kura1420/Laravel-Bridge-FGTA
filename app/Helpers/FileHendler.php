<?php

namespace App\Helpers;

use Illuminate\Http\Request;

class FileHendler 
{
    
    public static function upload(Request $request, $file): object
    {
        $data = [];

        $filename = $request->{$file}->getClientOriginalName();
        $type = $request->{$file}->getMimeType();
        $size = $request->{$file}->getSize();
        $base64 = "data:{$type};base64," . base64_encode(file_get_contents($request->file($file)));
        
        $getimagesize = getimagesize($request->{$file});

        if ($getimagesize) {
            $height = $getimagesize[0];
            $width = $getimagesize[1];

            $data['data'] = $base64;
            $data['height'] = $height;
            $data['name'] = $filename;
            $data['size'] = $size;
            $data['type'] = $type;
            $data['width'] = $width;
        } else {
            $data['data'] = $base64;
            $data['name'] = $filename;
            $data['size'] = $size;
            $data['type'] = $type;
        }

        return (object) [
            'filename' => $filename,
            'data' => $data
        ];
    }

}
