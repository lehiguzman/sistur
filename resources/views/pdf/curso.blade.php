<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Curso</title>
    <style>
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-size: 0.875rem;
            font-weight: normal;
            line-height: 1.5;
            color: #151b1e;           
        }
        .table {
            display: table;
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
            border-collapse: collapse;
        }
        .table-bordered {
            border: 1px solid #c2cfd6;
        }
        thead {
            display: table-header-group;
            vertical-align: middle;
            border-color: inherit;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
        .table th, .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #c2cfd6;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #c2cfd6;
        }
        .table-bordered thead th, .table-bordered thead td {
            border-bottom-width: 2px;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #c2cfd6;
        }
        th, td {
            display: table-cell;
            vertical-align: inherit;
        }
        th {
            font-weight: bold;
            text-align: -internal-center;
            text-align: left;
        }
        tbody {
            display: table-row-group;
            vertical-align: middle;
            border-color: inherit;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            
        }
        .izquierda{
            float:left;
        }
        .derecha{
            float:right;
        }
    </style>
</head>
<body>
    <div>
        <h3> Cursos <span class="derecha">{{now()}}</span></h3>
    </div>
    <table>
     @foreach ($curso as $a)
                <tr>                    
                    <th>Curso : {{$a->nombre}}</th>
                </tr>
                <tr>
                    <th>Fecha de inicio : {{$a->fecini}}</th>
                </tr>
                <tr>
                    <th>Cupos : {{$a->cupos}}</th> 
                </tr>
                <tr>
                    <th>Duración {{$a->duracion}}</th>      
                </tr>
                @endforeach  
    </table>
    <br>
    <div style="height: 20px; text-align: center;">
        <label><b><h3>Contenidos</h3></b></label>
    </div>
    <br><hr><br>
    <table class="table table-bordered table-striped table-sm">
        <thead>
            <tr>
                <th>contenido</th>
                <th>Descripción</th>
            </tr>                   
        </thead>
        <tbody>            
            @foreach ($detalles as $detalle)
            <tr>                    
                <td>{{$detalle->contenido}}</td>
                <td>{{$detalle->descripcion}}</td>                    
            </tr>
            @endforeach                               
        </tbody>
        </table>
    </div>    
</body>
</html>