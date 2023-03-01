<?php

namespace App\services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\services\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FilesService {

    public static function uploadFile(Request $request, $fileUpload, $inmuebleId){
        try{
            $extFile = $fileUpload->extension($fileUpload->getClientOriginalName());
            $nameFile =  str_replace($extFile, "", $fileUpload->getClientOriginalName());

            $path = public_path().'/archivos/';
            $path2 = 'archivos/';

            if (!is_dir($path)) {
                File::makeDirectory($path,0777,true);
            }

            $fileUpload->move("$path","$nameFile$extFile");

            return "$path2$nameFile$extFile";
        }catch(\Exception $e){
            DB::rollback();
            Response::status($request,"warning", $e->getMessage(), "uploadFile", true, true);
            return redirect()->back()->withInput($request->all());
        }
    }
}
