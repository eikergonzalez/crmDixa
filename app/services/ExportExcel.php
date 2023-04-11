<?php

namespace App\services;


use Illuminate\Support\Facades\DB;
use App\services\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use app\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportExcel implements FromView, ShouldAutoSize
{
    protected $model= "";

    public function __construct($model){
        $this->model = $model;
    }

    public function view(): View{
        return view('pages.excel.informe-inmueble', ['config' => $this->model]);
    }
}