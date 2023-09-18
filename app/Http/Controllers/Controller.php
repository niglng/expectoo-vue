<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    public function loadJSON($filename) {
        $path = storage_path() . "/$filename";
        if (!File::exists($path)) {
            throw new Exception("File not found, enter the correct path");
        }
    
        $jsonData = File::get($path); // string

        // Convert json to array
        return json_decode($jsonData, true);
    
    }

}
