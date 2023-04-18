<style>
   .tit{
       text-align:center;
       font-weight:bold;
   }
</style>
<table>
    <thead>
    <tr>
        <th>Num. Pedidos</th>
        <th>Num. Rebajas</th>
        <th>Num. Valoracion</th>
        <th>Num. Pisos Ofertados</th>
        <th>Num. Encargos</th>


    </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $pedidos }}</td>
            <td>{{ $rebaja }}</td>
            <td>{{ $valoracion }}</td>
            <td>{{ $ofertas }}</td>
            <td>{{ $encargo }}</td>


        </tr>
    </tbody>
</table>