<?php

namespace App\Http\Controllers\Vivienda;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\tablaXImport;
use Exception;

use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EmapacopsaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
 
}
