<style>
   .tit{
       text-align:center;
       font-weight:bold;
   }
</style>
<table>
    <thead>
    <tr>
        <th>#</th>
        <th>Fecha Visita</th>
        <th>Observacion</th>
    </tr>
    </thead>
    <tbody>
    @foreach($config as $columna)
        <tr>
            <td>{{ $columna->idvisita }}</td>
            <td>{{ $columna->fecha_visita }}</td>
            <td>{{ $columna->observacion }}</td>
        </tr>
    @endforeach
    </tbody>
</table>