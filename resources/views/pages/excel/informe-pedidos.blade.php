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
        <th>Fecha Oferta</th>
        <th>Comentario</th>
    </tr>
    </thead>
    <tbody>
    @foreach($config as $columna)
        <tr>
            <td>{{ $columna->idoferta }}</td>
            <td>{{ $columna->fecha_oferta }}</td>
            <td>{{ $columna->comentario }}</td>
        </tr>
    @endforeach
    </tbody>
</table>