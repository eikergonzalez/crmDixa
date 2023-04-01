@extends('layouts.backend')

@section('content')
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    Informe Comercial
                </h3>
            </div>
            <div class="block-content">
                <div class="col-xl-4 mb-4">
                    <input type="text" class="js-datepicker form-control" id="rangofecha" name="rangofecha" data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="mm-yyyy" placeholder="mm-yyyy">
                </div>
            </div>
        </div>
    </div>
@endsection
