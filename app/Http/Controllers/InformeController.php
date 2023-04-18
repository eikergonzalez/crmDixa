<?php

namespace App\Http\Controllers;

use app\Models\inmueble;
use app\Models\pedidos;
use app\Models\relacion_inmueble_rebaja;
use App\services\ExportExcelComercial;
use App\services\Response;
use Illuminate\Http\Request;
use App\services\ExportExcelGlobal;
use App\services\ExportExcelPedido;
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
        $data = [];
        $data['desde'] = null;
        $data['hasta'] = null;

        $encargo = DB::table('inmueble')->where('accion','=','6');
        $valoracion = DB::table('inmueble')->where('accion','=','4');
        $rebaja = DB::table('inmueble')
        ->join('relacion_inmueble_rebaja', 'relacion_inmueble_rebaja.inmueble_id', '=', 'inmueble.id');
        $pedidos = DB::table('pedidos');
        
        if(!empty($request->date1) && !empty($request->date2)){
            $desde = Carbon::createFromFormat('d/m/Y', $request->date1)->format('Y-m-d');
            $hasta = Carbon::createFromFormat('d/m/Y', $request->date2)->format('Y-m-d');
            $encargo=$encargo->whereRaw("TO_CHAR(inmueble.created_at, 'yyyy-mm-dd')>='$desde'")
            ->whereRaw("TO_CHAR(inmueble.created_at, 'yyyy-mm-dd')<='$hasta'");

            $valoracion=$valoracion->whereRaw("TO_CHAR(inmueble.created_at, 'yyyy-mm-dd')>='$desde'")
            ->whereRaw("TO_CHAR(inmueble.created_at, 'yyyy-mm-dd')<='$hasta'");

            $rebaja=$rebaja->whereRaw("TO_CHAR(inmueble.created_at, 'yyyy-mm-dd')>='$desde'")
            ->whereRaw("TO_CHAR(inmueble.created_at, 'yyyy-mm-dd')<='$hasta'");

            $rebaja=$rebaja->whereRaw("TO_CHAR(pedidos.created_at, 'yyyy-mm-dd')>='$desde'")
            ->whereRaw("TO_CHAR(pedidos.created_at, 'yyyy-mm-dd')<='$hasta'");

            $data['desde'] = Carbon::parse($desde)->format('d/m/y');
            $data['hasta'] = Carbon::parse($hasta)->format('d/m/y');
        }
        $data['encargo'] = $encargo->count();
        $data['valoracion'] = $valoracion->count();
        $data['rebaja'] = $rebaja->count();
        $data['pedidos'] = $pedidos->count();

        return view('pages.informes.informe-global', $data);
    }

    public function exportGlobal(Request $request){
        try {
            $file = "Informe Global";
                $encargo = DB::table('inmueble')->where('accion','=','6');
                $valoracion = DB::table('inmueble')->where('accion','=','4');
                $rebaja = DB::table('inmueble')
                ->join('relacion_inmueble_rebaja', 'relacion_inmueble_rebaja.inmueble_id', '=', 'inmueble.id');
                $pedidos = DB::table('pedidos');
                
                if(!empty($request->date1) && !empty($request->date2)){
                    $desde = Carbon::createFromFormat('d/m/Y', $request->date1)->format('Y-m-d');
                    $hasta = Carbon::createFromFormat('d/m/Y', $request->date2)->format('Y-m-d');
                    $encargo=$encargo->whereRaw("TO_CHAR(inmueble.created_at, 'yyyy-mm-dd')>='$desde'")
                    ->whereRaw("TO_CHAR(inmueble.created_at, 'yyyy-mm-dd')<='$hasta'");

                    $valoracion=$valoracion->whereRaw("TO_CHAR(inmueble.created_at, 'yyyy-mm-dd')>='$desde'")
                    ->whereRaw("TO_CHAR(inmueble.created_at, 'yyyy-mm-dd')<='$hasta'");

                    $rebaja=$rebaja->whereRaw("TO_CHAR(inmueble.created_at, 'yyyy-mm-dd')>='$desde'")
                    ->whereRaw("TO_CHAR(inmueble.created_at, 'yyyy-mm-dd')<='$hasta'");

                    $rebaja=$rebaja->whereRaw("TO_CHAR(pedidos.created_at, 'yyyy-mm-dd')>='$desde'")
                    ->whereRaw("TO_CHAR(pedidos.created_at, 'yyyy-mm-dd')<='$hasta'");

                    $data['desde'] = Carbon::parse($desde)->format('d/m/y');
                    $data['hasta'] = Carbon::parse($hasta)->format('d/m/y');
                }

                $encargo = $encargo->count();
                $valoracion = $valoracion->count();
                $rebaja = $rebaja->count();
                $pedidos = $pedidos->count();
                
                $data = [
                    "encargo" => $encargo,
                    "valoracion" => $valoracion,
                    "rebaja" => $rebaja,
                    "pedidos" => $pedidos
                ];
            return FacadesExcel::download(new ExportExcelGlobal($data), $file.'.xlsx');
        }catch(\Exception $e){
            return Response::statusJson("error",$e->getMessage(),'downloadPlantilla', null, true, true);
        }
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
            $desde = Carbon::createFromFormat('d/m/Y', $request->date1)->format('Y-m-d');
            $hasta = Carbon::createFromFormat('d/m/Y', $request->date2)->format('Y-m-d');
            $inmuebles=$inmuebles->whereRaw("TO_CHAR(relacion_inmueble_visitas.created_at, 'yyyy-mm-dd')>='$desde'")
            ->whereRaw("TO_CHAR(relacion_inmueble_visitas.created_at, 'yyyy-mm-dd')<='$hasta'");
            $data['desde'] = Carbon::parse($desde)->format('d/m/Y');
            $data['hasta'] = Carbon::parse($hasta)->format('d/m/Y');
        }
        $data['inmueble'] = $inmuebles->get();
     // dd($data);
       return view('pages.informes.informe-inmueble', $data);
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
                 //dd($inmuebles);
            return FacadesExcel::download(new ExportExcel($inmuebles), $file.'.xlsx');
        }catch(\Exception $e){
            return Response::statusJson("error",$e->getMessage(),'downloadPlantilla', null, true, true);
        }
    }

    public function Pedidos(Request $request){
        $data = [];
        $data['desde'] = null;
        $data['hasta'] = null;
        $ofertas= DB::table('ofertas')->selectRaw("ofertas.id as idoferta,
                    TO_CHAR(ofertas.created_at, 'yyyy-mm-dd') as fecha_oferta,
                    ofertas.nota as comentario"
                )
                ->orderBy('ofertas.id','asc');

        if(!empty($request->date1) && !empty($request->date2)){
            $desde = Carbon::createFromFormat('d/m/Y', $request->date1)->format('Y-m-d');
            $hasta = Carbon::createFromFormat('d/m/Y', $request->date2)->format('Y-m-d');
            $ofertas=$ofertas->whereRaw("TO_CHAR(ofertas.created_at, 'yyyy-mm-dd')>='$desde'")
            ->whereRaw("TO_CHAR(ofertas.created_at, 'yyyy-mm-dd')<='$hasta'");
            $data['desde'] = Carbon::parse($desde)->format('d/m/Y');
            $data['hasta'] = Carbon::parse($hasta)->format('d/m/Y');
        }
        $data['oferta'] = $ofertas->get();
        return view('pages.informes.informe-pedidos', $data);
    }

    public function exportPedidos(Request $request){
        try {
            $file = "Informe Pedidos";
            $ofertas= DB::table('ofertas')->selectRaw("ofertas.id as idoferta,
                                    TO_CHAR(ofertas.created_at, 'yyyy-mm-dd') as fecha_oferta,
                                    ofertas.nota as comentario"
                                )
                                ->orderBy('ofertas.id','asc');

                if(!empty($request->date1) && !empty($request->date2)){
                     $desde = Carbon::createFromFormat('d/m/Y', $request->date1)->format('Y-m-d');
                     $hasta = Carbon::createFromFormat('d/m/Y', $request->date2)->format('Y-m-d');
                     $ofertas=$ofertas->whereRaw("TO_CHAR(ofertas.created_at, 'yyyy-mm-dd')>='$desde'")
                     ->whereRaw("TO_CHAR(ofertas.created_at, 'yyyy-mm-dd')<='$hasta'");
                 }

                 $ofertas = $ofertas->get();
            return FacadesExcel::download(new ExportExcelPedido($ofertas), $file.'.xlsx');
        }catch(\Exception $e){
            return Response::statusJson("error",$e->getMessage(),'downloadPlantilla', null, true, true);
        }
    }

    public function Comercial(Request $request){
        $data = [];
        $data['desde'] = null;
        $data['hasta'] = null;
        $ofertas= DB::table('ofertas')->selectRaw("ofertas.id as idoferta,
                    TO_CHAR(ofertas.created_at, 'yyyy-mm-dd') as fecha_oferta,
                    ofertas.nota as comentario"
                )
                ->orderBy('ofertas.id','asc');

        if(!empty($request->date1) && !empty($request->date2)){
            $desde = Carbon::createFromFormat('d/m/Y', $request->date1)->format('Y-m-d');
            $hasta = Carbon::createFromFormat('d/m/Y', $request->date2)->format('Y-m-d');
            $ofertas=$ofertas->whereRaw("TO_CHAR(ofertas.created_at, 'yyyy-mm-dd')>='$desde'")
            ->whereRaw("TO_CHAR(ofertas.created_at, 'yyyy-mm-dd')<='$hasta'");
            $data['desde'] = Carbon::parse($desde)->format('d/m/Y');
            $data['hasta'] = Carbon::parse($hasta)->format('d/m/Y');
        }
        $data['oferta'] = $ofertas->get();
        return view('pages.informes.informe-comercial', $data);
        //return FacadesExcel::download(new InformeExport($request->filtro), 'informe.xlsx');
    }

    public function exportPedidosComercial(Request $request){
        try {
            $file = "Informe Comercial";
            $ofertas= DB::table('ofertas')->selectRaw("ofertas.id as idoferta,
                                    TO_CHAR(ofertas.created_at, 'yyyy-mm-dd') as fecha_oferta,
                                    ofertas.nota as comentario"
                                )
                                ->orderBy('ofertas.id','asc');

                if(!empty($request->date1) && !empty($request->date2)){
                     $desde = Carbon::createFromFormat('d/m/Y', $request->date1)->format('Y-m-d');
                     $hasta = Carbon::createFromFormat('d/m/Y', $request->date2)->format('Y-m-d');
                     $ofertas=$ofertas->whereRaw("TO_CHAR(ofertas.created_at, 'yyyy-mm-dd')>='$desde'")
                     ->whereRaw("TO_CHAR(ofertas.created_at, 'yyyy-mm-dd')<='$hasta'");
                 }

                 $ofertas = $ofertas->get();
            return FacadesExcel::download(new ExportExcelComercial($ofertas), $file.'.xlsx');
        }catch(\Exception $e){
            return Response::statusJson("error",$e->getMessage(),'downloadPlantilla', null, true, true);
        }
    }

}
