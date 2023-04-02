<?php

namespace App\Http\Controllers;

use App\Models\estatus;
use App\Models\inmueble;
use App\Models\pedidos;
use App\Models\propietario;
use App\Models\User;
use App\services\Response;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContratoController extends Controller{

    public function viewNotaEncargo(Request $request, $id, $uuid){
        $data = [];

        return view('contratos.nota-encargo', $data);
    }
}
