<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

class LogController extends Controller
{
    public function getLogs(Request $request) {
        Log::debug("ok3");
        $date = Carbon::now();
        if (isset($request->date)) {
            $date = Carbon::createFromFormat('Y-m-d', $request->get('date'));
        }
        $filePath = storage_path("logs/laravel-{$date->format('Y-m-d')}.log");
        $data = [];
    
        if (File::exists($filePath)) {
            $data = [
                'lastModified' => Carbon::parse(File::lastModified($filePath)),
                'size' => File::size($filePath),
                'file' => File::get($filePath),
            ];
        }
        return view('logs', compact('date', 'data'));
    }
}
