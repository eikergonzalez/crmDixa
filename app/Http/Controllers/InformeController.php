<?php

namespace App\Http\Controllers;

use app\Models\inmueble;
use App\services\Response;
use Illuminate\Http\Request;
use App\services\ExportExcel;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;
use Illuminate\Support\Facades\DB;



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
        $data = [];
        return view('pages.informes.informe-comercial', $data);
        //return FacadesExcel::download(new InformeExport($request->filtro), 'informe.xlsx');
    }

    public function Inmueble(Request $request){  
        $data = [];
        $data['desde'] = null;
        $data['hasta'] = null;
        $inmuebles= DB::table('inmueble')->selectRaw("relacion_inmueble_visitas.visitas_id as idvisita,
                    TO_CHAR(relacion_inmueble_visitas.created_at, 'yyyy-mm-dd') as fecha_visita,
                    inmueble.observacion as observacion"
                )
                ->join('relacion_inmueble_visitas', 'relacion_inmueble_visitas.inmueble_id', '=', 'inmueble.id')
                ->orderBy('relacion_inmueble_visitas.visitas_id','asc');

        if(!empty($request->date1) && !empty($request->date2)){
           // dd($request->date1, $request->date2);
            $desde = Carbon::createFromFormat('d/m/Y', $request->date1)->format('Y-m-d');
            $hasta = Carbon::createFromFormat('d/m/Y', $request->date2)->format('Y-m-d');
            $inmuebles=$inmuebles->whereRaw("TO_CHAR(relacion_inmueble_visitas.created_at, 'yyyy-mm-dd')>='$desde'")
            ->whereRaw("TO_CHAR(relacion_inmueble_visitas.created_at, 'yyyy-mm-dd')<='$hasta'");
            $data['desde'] = Carbon::parse($desde)->format('d/m/y');
            $data['hasta'] = Carbon::parse($hasta)->format('d/m/y');
        }
        $data['inmueble'] = $inmuebles->get();
     // dd($data);
       return view('pages.informes.informe-inmueble', $data);
    }

    public function Pedidos(Request $request)
    {
        return view('pages.informes.informe-pedidos');
        //return FacadesExcel::download(new InformeExport($request->filtro), 'informe.xlsx');
    }



    public function exportInmueble(Request $request){
        try {
            $file = "Informe Inmueble";
            $inmuebles= DB::table('inmueble')->selectRaw("relacion_inmueble_visitas.visitas_id as idvisita,
                    TO_CHAR(relacion_inmueble_visitas.created_at, 'yyyy-mm-dd') as fecha_visita,
                    inmueble.observacion as observacion"
                )
                ->join('relacion_inmueble_visitas', 'relacion_inmueble_visitas.inmueble_id', '=', 'inmueble.id')
                ->orderBy('relacion_inmueble_visitas.visitas_id','asc');

                if(!empty($request->date1) && !empty($request->date2)){
                     $desde = Carbon::createFromFormat('d/m/Y', $request->date1)->format('Y-m-d');
                     $hasta = Carbon::createFromFormat('d/m/Y', $request->date2)->format('Y-m-d');
                     $inmuebles=$inmuebles->whereRaw("TO_CHAR(relacion_inmueble_visitas.created_at, 'yyyy-mm-dd')>='$desde'")
                     ->whereRaw("TO_CHAR(relacion_inmueble_visitas.created_at, 'yyyy-mm-dd')<='$hasta'");
                 }

                 $inmuebles = $inmuebles->get();
                 dd($inmuebles);
            return FacadesExcel::download(new ExportExcel($inmuebles), $file.'.xlsx');
        }catch(\Exception $e){
            return Response::statusJson("error",$e->getMessage(),'downloadPlantilla', null, true, true);
        }
    }
}
