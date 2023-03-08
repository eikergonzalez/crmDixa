<?php

namespace App\services;


use Illuminate\Support\Facades\DB;
use App\services\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FilesService {

    public static function uploadFile(Request $request, $fileUpload){
        $extFile = $fileUpload->extension($fileUpload->getClientOriginalName());
        $nameFile =  str_replace($extFile, "", $fileUpload->getClientOriginalName()).$request->uuid;

        $path = public_path().'/archivos/';
        $path2 = 'archivos/';

        if (!is_dir($path)) {
            File::makeDirectory($path,0777,true);
        }

        if(File::exists("$path2$nameFile.$extFile")){
            throw new \Exception("Ya existe un archivo con el mismo nombre", 400);
        }

        $fileUpload->move("$path","$nameFile.$extFile");

        return [ "path" => "$path2$nameFile.$extFile", "name" => "$nameFile"];
    }

    public static function deleteFile($file){
        if(File::exists($file)){
            File::delete($file);
        }
        return true;
    }
}
