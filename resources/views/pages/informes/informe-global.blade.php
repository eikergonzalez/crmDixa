@extends('layouts.backend')

@section('content')
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    Informe Global
                </h3>
            </div>
            <div class="block-content">
                <div class="form-group">
                        <label for="mes">Mes:</label>
                        <select name="mes" id="mes" class="form-control">
                            <option value="">-- Seleccione un mes --</option>
                            <option value="01" {{ request('mes') == '01' ? 'selected' : '' }}>Enero</option>
                            <option value="02" {{ request('mes') == '02' ? 'selected' : '' }}>Febrero</option>
                            <option value="03" {{ request('mes') == '03' ? 'selected' : '' }}>Marzo</option>
                            <option value="04" {{ request('mes') == '04' ? 'selected' : '' }}>Abril</option>
                            <option value="05" {{ request('mes') == '05' ? 'selected' : '' }}>Mayo</option>
                            <option value="06" {{ request('mes') == '06' ? 'selected' : '' }}>Junio</option>
                            <option value="07" {{ request('mes') == '07' ? 'selected' : '' }}>Julio</option>
                            <option value="08" {{ request('mes') == '08' ? 'selected' : '' }}>Agosto</option>
                            <option value="09" {{ request('mes') == '09' ? 'selected' : '' }}>Septiembre</option>
                            <option value="10" {{ request('mes') == '10' ? 'selected' : '' }}>Octubre</option>
                            <option value="11" {{ request('mes') == '11' ? 'selected' : '' }}>Noviembre</option>
                            <option value="12" {{ request('mes') == '12' ? 'selected' : '' }}>Diciembre</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="anio">Año:</label>
                        <input type="text" name="anio" id="anio" class="form-control" value="{{ request('anio') }}">
                    </div>
                    <br>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </div>
                    <br>
                    <br>
                </div>
            </div>
        </div>
    </div>

@endsection
