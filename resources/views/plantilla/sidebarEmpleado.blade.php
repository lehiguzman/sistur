<div class="sidebar">
    <nav class="sidebar-nav" style="background-color: #9FD5E4;">
        <ul class="nav">
            <li @click="menu=0" class="nav-item">
                <a class="nav-link active" href="#"><i class="icon-speedometer"></i><font color="#372FB4"> Dashboard</font></a>
            </li>
            <li class="nav-title">
                <font color="#372FB4">Menú</font>
            </li>            

            <li @click="menu=6" class="nav-item">
                <a class="nav-link" href="#"><i class="fa fa-building"></i><font color="#372FB4">Empleados</font></a>
            </li> 

            <li @click="menu=7" class="nav-item">
                <a class="nav-link" href="#"><i class="fa fa-times-circle"></i><font color="#372FB4">Ausencias</font></a>
            </li>  

            <li @click="menu=8" class="nav-item">
                <a class="nav-link" href="#"><i class="fa fa-bullseye"></i><font color="#372FB4">Objetivos</a>
            </li>  

            <li @click="menu=9" class="nav-item">
                <a class="nav-link" href="#"><i class="fa fa-book"></i><font color="#372FB4">Cursos</font></a>
            </li> 

            <li @click="menu=10" class="nav-item">
                <a class="nav-link" href="#"><i class="fa fa-list-ol"></i><font color="#372FB4">Cuestionarios</font></a>
            </li>                            
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>