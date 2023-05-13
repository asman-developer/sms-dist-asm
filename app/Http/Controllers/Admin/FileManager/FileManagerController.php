<?php

namespace App\Http\Controllers\Admin\FileManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FileManagerController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('pages.filemanager.index');
    }
}
