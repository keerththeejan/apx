<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServiceUploadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'image_file' => ['required','image','mimes:jpg,jpeg,png,webp,svg','max:4096'],
        ]);

        $file = $request->file('image_file');
        if (!$file || !$file->isValid()) {
            return response()->json(['error' => 'Invalid file'], 422);
        }

        $dir = public_path('uploads/services');
        if (!is_dir($dir)) { @mkdir($dir, 0775, true); }
        $ext = $file->getClientOriginalExtension() ?: 'png';
        $name = 'service_'.date('Ymd_His').'_'.substr(bin2hex(random_bytes(4)),0,8).'.'.$ext;
        $file->move($dir, $name);
        $publicUrl = '/uploads/services/'.$name;

        return response()->json(['url' => $publicUrl]);
    }
}
