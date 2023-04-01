<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel;
use app\Models\inmueble;
use InformeExport;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;

class InformeController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.informes.informe-global');
    }
    
    public function Global(Request $request)
    {
        return view('pages.informes.informe-global');
        //return FacadesExcel::download(new InformeExport($request->filtro), 'informe.xlsx');
    }

    public function Comercial(Request $request)
    {
        return view('pages.informes.informe-comercial');
        //return FacadesExcel::download(new InformeExport($request->filtro), 'informe.xlsx');
    }

    public function Inmueble(Request $request)
    {
        return view('pages.informes.informe-inmueble');
        //return FacadesExcel::download(new InformeExport($request->filtro), 'informe.xlsx');
    }

    public function Pedidos(Request $request)
    {
        return view('pages.informes.informe-pedidos');
        //return FacadesExcel::download(new InformeExport($request->filtro), 'informe.xlsx');
    }
}
