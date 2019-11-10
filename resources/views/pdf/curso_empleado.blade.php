<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detalle del Curso</title>
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
    <table width="100%">
        <tr>
            <td width="40%">
                <img src="./img/logo-simple.png" style="margin: 15px; height: 80px;">            
            </td>
            <td width="60%">
                <h3 align="left">Cursos</h3>        
            </td>
        </tr>
    </table>      
    <table>
     
                <tr>                    
                    <th>Curso : {{$curso->nombre}}</th>
                </tr>
                <tr>
                    <th>Fecha de inicio : {{$curso->fecini}}</th>
                </tr>
                <tr>
                    <th>Cupos : {{$curso->cupos}}</th> 
                </tr>
                <tr>
                    <th>Duración {{$curso->duracion}}</th>      
                </tr>
                  
    </table>
    <br>
    <div style="height: 20px; text-align: center;">
        <label><b><h3>Empleados asignados</h3></b></label>
    </div>
    <br><hr><br>
    <table class="table table-bordered table-striped table-sm">
        <thead>
            <tr>
                <th>Cédula</th>                
                <th>Nombre</th>                
            </tr>                   
        </thead>
        <tbody>            
            @foreach ($empleados as $empleado)
            <tr>                    
                <td>{{$empleado->cedula}}</td>                
                <td>{{$empleado->nombre}}</td>                
            </tr>
            @endforeach                               
        </tbody>
        </table>
    </div>    
</body>
</html>