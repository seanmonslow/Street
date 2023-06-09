<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File;
use App\Services\CsvService;

class FileUploadController extends Controller
{
    public function __invoke(Request $request, CsvService $csvService)
    {   
        $request->validate([
            'attachment' => [
                'required',
                File::types(['csv']),
            ],
        ]);
        
        return view('home', ['people' => $csvService->parseCsvFile($request->file('attachment'))]);
    }
}
