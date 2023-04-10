<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel;
use app\Models\inmueble;
use app\Models\visitas;
use app\Models\pedidos;
use app\Models\propietario;
use InformeExport;
use App\services\Response;
use Illuminate\Support\Facades\DB;
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

    public function Comercial(Request $request, $date1, $date2)
    {
        $data = [];
        return view('pages.informes.informe-comercial', $data);
        //return FacadesExcel::download(new InformeExport($request->filtro), 'informe.xlsx');
    }

    public function Inmueble(Request $request){    
      
       return view('pages.informes.informe-inmueble');
    }

    public function Pedidos(Request $request)
    {
        return view('pages.informes.informe-pedidos');
        //return FacadesExcel::download(new InformeExport($request->filtro), 'informe.xlsx');
    }

    public function getInformeInmueble(Request $request, $date1){
        $data = [];
        try{
            $data['propietarios'] = (new propietario())
                ->selectRaw("propietario.id as propietarioId, 
                    propietario.nombre, 
                    propietario.apellido, 
                    propietario.telefono, 
                    propietario.email as correo,
                    ri.visitas_id as idvisita,
                    TO_CHAR(ri.created_at, 'yyyy-mm-dd') as fecha_visita,
                    inmueble.observacion as observacion"
                )
                ->join('relacion_propietario_inmueble', 'relacion_propietario_inmueble.propietario_id','=','propietario.id')
                ->join('inmueble', 'inmueble.id','=','relacion_propietario_inmueble.inmueble_id')
                ->join('tipo_solicitud', 'tipo_solicitud.id','=','inmueble.tipo_solicitud')
                ->join('estatus', 'estatus.id','=','inmueble.accion')
                ->join('tipo_inmueble', 'tipo_inmueble.id','=','inmueble.tipo_inmueble')
                ->join('relacion_inmueble_visitas ri', 'ri.inmueble_id', '=', 'inmueble_id')
                ->where('inmueble.created_at','=', $date1)
                ->first();
        dd($data);

        return Response::statusJson("success",'Exito!','getInformeInmueble', $data);
        }catch(\Exception $e){
            DB::rollback();
            return Response::statusJson("warning", $e->getMessage(), "getInformeInmueble", true, true);
        }
    }
}
