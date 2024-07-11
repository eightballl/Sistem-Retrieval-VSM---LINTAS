<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        function removeSymbols($string) {
            // Menghapus semua karakter kecuali huruf, angka, dan spasi
            return preg_replace("/[^a-zA-Z0-9 ]/", "", $string);
        }
    }
}
