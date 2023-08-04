<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileAccessController extends Controller
{
    public function download($fileName)
    {
        // filename should be a relative path inside storage/app to your file like 'userfiles/report1253.pdf'
        return Storage::download($fileName);
    }

    public function exemptionServe($fileName)
    {
        $filepath = Storage::disk("exemption")->path($fileName);
        return response()->file($filepath);
    }
}
