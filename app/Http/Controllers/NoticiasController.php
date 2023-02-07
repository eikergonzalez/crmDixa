<?php

namespace App\Http\Controllers;

use App\Models\noticias;
use App\services\Response;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class NoticiasController extends Controller{

    public function index(){
        $data = []; 
        $noticias = (new noticias());

       // dd($data);
        return view('pages.noticias', $data);
    }
}