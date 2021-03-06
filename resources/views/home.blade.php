<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema Compras-Ventas con Laravel y Vue Js- webtraining-it.com">
    <meta name="keyword" content="Sistema Compras-Ventas con Laravel y Vue Js">
    <title>SIRHTUR</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js">    
    <!-- Icons -->
    <link href="css/plantilla.css" rel="stylesheet">   
    <link href="{{ asset('css/estilos.css') }}" rel="stylesheet"> 
</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
<div id="app">    
    <header class="app-header navbar">
        <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">
          <span class="navbar-toggler-icon"></span>
        </button>
        <!--PONER LOGO-->
        <!--<a class="navbar-brand" href="#"></a>-->
        <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
          <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="nav navbar-nav d-md-down-none">
            <li class="nav-item px-3">
                <a class="nav-link" href="#">Panel Administrativo</a>
            </li>           
        </ul>
        <ul class="nav navbar-nav ml-auto">

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <img src="img/usuario/{{ Auth::user()->imagen }}" class="img-avatar" alt="">
                    <img src="#" class="img-avatar" alt="">
                    <span class="d-md-down-none">{{ Auth::user()->nombre }} </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header text-center">
                        <strong>Cuenta</strong>
                    </div>
                    <a class="dropdown-item" href="{{ route('logout') }}" 
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-lock"></i> Cerrar sesi??n</a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </header>

    <div class="app-body">

            @if(Auth::user()->rol == 1)
                @include('plantilla.sidebarAdministrador')
            @elseif(Auth::user()->rol == 2)
                @include('plantilla.sidebarGerente')
            @elseif(Auth::user()->rol == 3)
                @include('plantilla.sidebarEmpleado')
            @elseif(Auth::user()->rol == 4)
                @include('plantilla.sidebarCliente')            
            @else

            @endif
       
        <!-- Contenido Principal -->

       @yield('contenido')

        <!-- /Fin del contenido principal -->
    </div>       
</div> <!-- Fin app -->
    <footer class="app-footer">
        <span><a><b><i>SIRHTUR</i></b></a> &copy; 2019</span>        
    </footer>

    <!-- Bootstrap and necessary plugins -->
    <script src="js/app.js"></script>
    <script src="js/plantilla.js"></script>
</body>
</html>