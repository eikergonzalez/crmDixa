<?php

namespace App\services;

use Illuminate\Support\Facades\File;


class FilesUpload {


    public static function UploadFile($file, $folder){

        if(!$file){
            return 'https://via.placeholder.com/250';
        }

        $path = public_path().'/empresas/'.$folder;
        $path2 = 'empresas/'.$folder;

        if (!is_dir($path)) {
            File::makeDirectory($path,0777,true);
        }

        $faker = \Faker\Factory::create();
        $uuid = $faker->uuid();

        $extension = $file->extension($file->getClientOriginalName());
        $file->move("$path2/", "$uuid.$extension");

        return "$path2/$uuid.$extension";
    }

    public static function DeleteFile($file){
        File::delete([$file]);
        return true;
    }
}
