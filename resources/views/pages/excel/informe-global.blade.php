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
        <th>Num. Encargos</th>
        <th>Num. Rebajas</th>
        <th>Num. Valoracion</th>
    </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $pedidos }}</td>
            <td>{{ $encargo }}</td>
            <td>{{ $rebaja }}</td>
            <td>{{ $valoracion }}</td>
        </tr>
    </tbody>
</table>