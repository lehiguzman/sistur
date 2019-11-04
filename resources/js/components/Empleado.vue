<template>
    <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="/">SISTEMA DE CALIDAD DE TURISMO</a></li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <template v-if="listado==1">
                    <div class="card-header">

                       <h2>Empleados</h2><br/>
                      
                        <button class="btn btn-primary btn-lg" type="button" @click="abrirModal('empleado', 'registrar')">
                            <i class="fa fa-plus fa-2x"></i>&nbsp;&nbsp;Agregar empleado
                        </button>
                        <button class="btn btn-primary btn-lg" type="button" @click="abrirCursos()">
                            <i class="fa fa-plus fa-2x"></i>&nbsp;&nbsp;Asignar curso a empleados
                        </button>
                        <button class="btn btn-primary btn-lg" type="button" @click="abrirObjetivos()">
                            <i class="fa fa-plus fa-2x"></i>&nbsp;&nbsp;Asignar objetivo a empleados
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                        <option value="nombre">Nombre</option>
                                    </select>
                                    <input type="text" @keyup.enter="listarEmpleado(1,buscar,criterio);" class="form-control" placeholder="Buscar texto" v-model="buscar">
                                    <button type="submit"  @click="listarEmpleado(1,buscar,criterio);" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr class="bg-primary">                                   
                                    <th>Cedula</th>
                                    <th>Nombre</th>
                                    <th>Telefono</th>
                                    <th>Email</th>
                                    <th>Editar</th>
                                    <th>Eliminar</th>                     
                                </tr>
                            </thead>
                            <tbody>                               
                                <tr v-for="empleado in empleados" :key="empleado.id">
                                    
                                    <td v-text="empleado.cedula"></td> 
                                    <td v-text="empleado.nombre"></td>
                                    <td v-text="empleado.telefono"></td>
                                    <td v-text="empleado.email"></td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-md" @click="abrirModal( 'empleado', 'actualizar', empleado )">
                                          <i class="fa fa-edit fa-2x"></i> Editar
                                        </button> &nbsp;
                                    </td>                               
                                    <td>
                                        <button type="button" class="btn btn-danger btn-md" @click="eliminarEmpleado(empleado.id)">
                                          <i class="fa fa-cut fa-2x"></i> Eliminar
                                        </button> &nbsp;
                                    </td>     
                                </tr>                               
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a  class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1, buscar, criterio)">Anterior</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'actived' : '']" >
                                    <a class="page-link" href="#" @click.prevent = "cambiarPagina(page, buscar, criterio)"  v-text="page"></a>
                                </li>                               
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1, buscar, criterio)">Siguiente</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </template> <!-- Fin listado de empleados -->
                <template v-if="listado==2"> <!-- Incio de Asignacion cursos a empleados -->
                    <span><strong>(*) Campo obligatorio</strong></span><br/>                     

                    <h3 class="text-center">LLenar el formulario</h3>

                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Curso</label>
                            <div class="col-md-9">
                                
                                <!--la variable idcategoria asociado a v-model la asignamos
                                en la propiedad data en javascript (ver al final) -->

                                <select class="form-control" v-model="curso_id" @change="selectEmpleados(curso_id)">
                                  
                                  <!-- el id y nombre asociado en el objeto categoria vienen de los campos
                                  de la tabla categorias de la bd-->
                                  <option value="0" disabled>Seleccione</option>
                                  <!--el arrayCategoria es una variable de la data javascript de vue 
                                  y se cargan los registros de la categoria una vez se abra la ventana
                                  modal-->
                                  <option v-for="curso in arrayCurso" :key="curso.id" :value="curso.id" v-text="curso.nombre"></option>

                                </select>                               
                            </div>
                        </div>
                        <div class="form-group row">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr class="bg-primary">                                   
                                        <th>Cedula</th>
                                        <th>Nombre</th>
                                        <th>Telefono</th>
                                        <th>Seleccionar</th>                                                   
                                    </tr>
                                </thead>
                                <tbody v-if="empleados.length">
                                    <tr v-for="(empleado, index) in empleados" :key="empleado.id">
                                        <td v-text="empleado.cedula"></td> 
                                        <td v-text="empleado.nombre"></td>
                                        <td v-text="empleado.telefono"></td>
                                        <td>
                                            <input type="checkbox" :value="empleado.id" v-model="checkEmpleado" >
                                        </td>
                                    </tr>                                    
                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <td colspan="6">
                                            No se ha seleccionado empleado
                                        </td>
                                    </tr>
                                </tbody> 
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="salir()" class="btn btn-danger"><i class="fa fa-times fa-2x"></i> Cerrar</button>
                        <button type="button" @click="registrarCursoEmpleados()" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Guardar</button>
                    </div>                   
                </template> <!-- Fin de Asignacion cursos a empleados -->
                <template v-if="listado==3"> <!-- Incio de Asignacion cursos a empleados -->
                    <span><strong>(*) Campo obligatorio</strong></span><br/>                     

                    <h3 class="text-center">LLenar el formulario</h3>

                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Objetivo</label>
                            <div class="col-md-9">
                                
                                <!--la variable idcategoria asociado a v-model la asignamos
                                en la propiedad data en javascript (ver al final) -->

                                <select class="form-control" v-model="objetivo_id" @change="selectObjetivoEmpleado()">
                                  
                                  <!-- el id y nombre asociado en el objeto categoria vienen de los campos
                                  de la tabla categorias de la bd-->
                                  <option value="0" disabled>Seleccione</option>
                                  <!--el arrayCategoria es una variable de la data javascript de vue 
                                  y se cargan los registros de la categoria una vez se abra la ventana
                                  modal-->
                                  <option v-for="objetivo in arrayObjetivo" :key="objetivo.id" :value="objetivo.id" v-text="objetivo.titulo"></option>

                                </select>                               
                            </div>
                        </div>
                        <div class="form-group row">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr class="bg-primary">                                   
                                        <th>Cedula</th>
                                        <th>Nombre</th>
                                        <th>Telefono</th>
                                        <th>Seleccionar</th>                                                   
                                    </tr>
                                </thead>
                                <tbody v-if="empleados.length">
                                    <tr v-for="(empleado, index) in empleados" :key="empleado.id">
                                        <td v-text="empleado.cedula"></td> 
                                        <td v-text="empleado.nombre"></td>
                                        <td v-text="empleado.telefono"></td>
                                        <td>
                                            <input type="checkbox" :value="empleado.id" v-model="checkEmpleado" >
                                        </td>
                                    </tr>                                    
                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <td colspan="6">
                                            No se ha seleccionado objetivo
                                        </td>
                                    </tr>
                                </tbody> 
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="salir()" class="btn btn-danger"><i class="fa fa-times fa-2x"></i> Cerrar</button>
                        <button type="button" @click="registrarObjetivoEmpleados()" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Guardar</button>
                    </div>                   
                </template> <!-- Fin de Asignacion objetivos a empleados -->
                </div>              
            </div>
               <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" :class="{ 'mostrar':modal }" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" @click="cerrarModal()" class="close" aria-label="Close">
                              <span aria-hidden="true" >×</span>
                            </button>
                        </div>
                       
                        <div class="modal-body">
                            
                            <div v-show="errorEmpleado" class="form-group row div-error">
                                
                                <div class="text-center text-error">
                                    
                                    <div v-for="error in errorMostrarMsjEmpleado" :key="error" v-text="error"></div>

                                </div>
                            
                            </div>
                             

                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Cedula</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="cedula" class="form-control" placeholder="Cedula del Empleado">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre del empleado">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Correo Electrónico</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="email" class="form-control" placeholder="Correo del empleado">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Telefono movil</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="movil" class="form-control" placeholder="Telefono movil del empleado">
                                    </div>
                                </div> 
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Telefono Local</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="telefono" class="form-control" placeholder="Telefono local del empleado">
                                    </div>
                                </div>                                
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Dirección</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="direccion" class="form-control" placeholder="Dirección del empleado">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">salario</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="salario" class="form-control" placeholder="Salario del empleado">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Fecha de ingreso</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="fecing" class="form-control" placeholder="Fecha de ingreso del empleado">
                                    </div>
                                </div> 
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Fecha de egreso</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="fecegr" class="form-control" placeholder="Fecha de egreso del empleado">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Cargo</label>
                                    <div class="col-md-9">
                                        
                                        <!--la variable idcategoria asociado a v-model la asignamos
                                        en la propiedad data en javascript (ver al final) -->

                                        <select class="form-control" v-model="cargo_id">
                                          
                                          <!-- el id y nombre asociado en el objeto categoria vienen de los campos
                                          de la tabla categorias de la bd-->
                                          <option value="0" disabled>Seleccione</option>
                                          <!--el arrayCategoria es una variable de la data javascript de vue 
                                          y se cargan los registros de la categoria una vez se abra la ventana
                                          modal-->
                                          <option v-for="cargo in arrayCargo" :key="cargo.id" :value="cargo.id" v-text="cargo.titulo"></option>

                                        </select>
                                       
                                    </div>
                                </div>                                                                 
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" @click="cerrarModal()" class="btn btn-danger"><i class="fa fa-times fa-2x"></i> Cerrar</button>
                            <button type="button" @click="registrarEmpleado()" v-if="tipoAccion==1" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Guardar</button>
                            <button type="button" @click="actualizarEmpleado()" v-if="tipoAccion==2" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Actualizar</button>                           
                        </div>
                    </div>
                    <!-- /.modal-content -->                    
                </div>                
                <!-- /.modal-dialog -->
            </div>
        </main>
</template>

<!-- Estilos del modal -->
<style type="text/css">
        .modal-content {
            width: 100% !important;
            position: absolute !important;
        }

        .mostrar {
            display: list-item !important;
            opacity: 1 !important;
            position: absolute !important;
            background-color: #3c29297a !important;
        }

        .div-error{
            display: flex;
            justify-content: center;
        }

        .text-error{
            color: red !important;
            font-weight: bold;
            font-size: 20px;
        }
</style>

<script>
    export default {
        data() {
            return {
                empleados: [],
                cedula: "",
                nombre: "",
                email: "", 
                telefono: "",
                movil: "",
                direccion: "", 
                salario: 0,
                fecing: "",
                fecegr: "",

                //por defecto
                pagination: {
                    'total' : 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from' : 0,
                    'to' : 0,
                },
                criterio: 'nombre',
                buscar: '',
                listado: 1,                

                //modal
                modal:0, //0=Modal abierto / 1=Modal cerrado
                tituloModal:'',

                //Errores
                errorEmpleado:0,
                errorMostrarMsjEmpleado:[],
                tipoAccion: '',
                checkEmpleado: [],

                //Cargos
                cargo_id: 0,
                arrayCargo: [],

                //Instituciones
                institucion_id: 0,
                arrayInstitucion: [],

                //Modulo asignacion de cursos a empleados
                curso_id: 0,
                arrayCurso: [],
                arrayCursoEmpleado: [],

                //Modulo asignacion de objetivos a empleados
                objetivo_id: 0,
                arrayObjetivo: [],
                arrayObjetivoEmpleado: []
            }            
        },

        computed: {
            pagesNumber: function(){
                if(!this.pagination.to){
                    return [];
                }

                var from = this.pagination.current_page - this.offset;
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if(to >= this.pagination.last_page){                    
                    to = this.pagination.last_page;
                } 

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            }
        },

        methods: {
            //Modulo
            listarEmpleado(page, buscar, criterio) {
                let me = this; 
                var url = '/empleado?page='+ page + '&buscar=' + buscar + '&criterio=' + criterio;

                axios.get(url).then( function( response ) {                    
                    
                    var respuesta = response.data;
                    me.empleados = respuesta.empleados.data;

                });                               
            },

            registrarEmpleado(){
                const alerta = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',                    
                  },
                 buttonsStyling: false,
                })

                if(this.validarEmpleado()) {
                    return;
                }
                let me=this;
                axios.post('/empleado/registrar', {
                        'cedula':me.cedula,
                        'nombre':me.nombre,
                        'email':me.email,
                        'telefono':me.telefono,
                        'movil':me.movil,
                        'direccion':me.direccion,
                        'salario':me.salario,
                        'fecing':me.fecing,
                        'fecegr':me.fecegr,
                        'cargo_id':me.cargo_id,
                        'institucion_id':5//me.institucion_id,
                    }).then(function (response) {
                        alerta.fire("Empleado registrada exitosamente");
                        me.cerrarModal();
                        me.listarEmpleado(1, '', 'nombre');
                    }).catch(function (error) {
                    // handle error
                    console.log(error);
                    });
            },

            actualizarEmpleado(){
                const alerta = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',                    
                  },
                 buttonsStyling: false,
                })

                if(this.validarEmpleado()) {
                    return;
                }
                let me=this;
                axios.put('/empleado/actualizar', {
                        'id':me.empleado_id,
                        'cedula':me.cedula,
                        'nombre':me.nombre,
                        'email':me.email,
                        'telefono':me.telefono,
                        'movil':me.movil,
                        'direccion':me.direccion,
                        'salario':me.salario,
                        'fecing':me.fecing,
                        'fecegr':me.fecegr,
                        'cargo_id':me.cargo_id,
                        'institucion_id': 5//me.institucion_id,
                    }).then(function (response) {
                        alerta.fire("Empleado editado exitosamente");
                        me.cerrarModal();
                        me.listarEmpleado(1, '', 'nombre');
                    }).catch(function (error) {
                    // handle error
                    console.log(error);
                    });
            },

            eliminarEmpleado(id) {
                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                  },
                 buttonsStyling: false,
                })

                swalWithBootstrapButtons.fire({
                  title: '¿Estás seguro de eliminar el Empleado?',
                  //type: 'warning',
                  showCancelButton: true,
                  confirmButtonText: '<i class="fa fa-check fa-2x"></i> Aceptar',
                  cancelButtonText: '<i class="fa fa-times fa-2x"></i> Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {
                        
                    let me=this;
                        axios.delete('/empleado/eliminar/'+id).then(function (response) {  
                                //console.log( response );
                                me.listarEmpleado(1, '', 'nombre');
                                swalWithBootstrapButtons.fire(
                                    'Eliminado!',
                                    'Empleado eliminado.',
                                    'success'
                                )
                            }).catch(function (error) {
                            // handle error
                            console.log(error);
                            });                    
                  } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                  ) {                    
                  }
                })
            },

            validarEmpleado() {
                this.errorEmpleado=0;
                this.errorMostrarMsjEmpleado=[];

                if(!this.cedula){
                    this.errorMostrarMsjEmpleado.push("(*) La cedula no puede estar vacia");
                }

                if(!this.nombre){
                    this.errorMostrarMsjEmpleado.push("(*) El nombre no puede estar vacio");
                }

                if(!this.email){
                    this.errorMostrarMsjEmpleado.push("(*) El correo no puede estar vacio");
                }

                if(!this.telefono){
                    this.errorMostrarMsjEmpleado.push("(*) El telefono movil no puede estar vacio");
                }                

                if(!this.cargo_id){
                    this.errorMostrarMsjEmpleado.push("(*) Debe seleccionar un cargo");
                }

                if(this.errorMostrarMsjEmpleado.length) this.errorEmpleado=1;
                return this.errorEmpleado;
            },

            //Cargo
            selectCargo() {
                let me = this;

                var url = '/cargo/selectCargo';

                axios.get(url).then(function (response) {
                    // handle success
                    console.log(response);
                    var respuesta = response.data;
                    me.arrayCargo = respuesta.cargos;  
                    console.log(me.arrayCargo);
                  })
                  .catch(function (error) {
                    // handle error
                    console.log(error);
                  })
                  .finally(function () {
                    // always executed
                  });
            },  

            //Modal
            abrirModal(modelo, accion, data=[]) {                   
                switch(modelo) {
                    case "empleado": {
                        switch(accion){
                            case "registrar":{
                                this.modal = 1;
                                this.tituloModal="Registrar empleado";
                                this.tipoAccion = 1;
                                this.cedula = "";
                                this.nombre = "";
                                this.email = "";
                                this.telefono = "";
                                this.movil = "";                                
                                this.direccion = "";
                                this.salario = 0;
                                this.fecing = "";
                                this.fecegr = "";
                                this.cargo_id = 0;
                                this.institucion_id = 0;                               
                                break;
                            }
                            case "actualizar": {
                                this.modal = 1;
                                this.tituloModal = "Editar empleado";
                                this.tipoAccion=2;
                                this.empleado_id = data["id"];
                                this.cedula = data["cedula"];
                                this.nombre = data["nombre"];
                                this.email = data["email"];
                                this.telefono = data["telefono"];
                                this.movil = data["movil"];                                
                                this.direccion = data["direccion"];
                                this.salario = data["salario"];
                                this.fecing = data["fecing"];
                                this.fecegr = data["fecegr"];
                                this.cargo_id = data["cargo_id"];
                                this.institucion_id = data["institucion_id"];
                                break;
                            }                         
                        }
                    }
                    this.selectCargo();
                }                
            },            

            cerrarModal() { 
                this.modal = 0;
                this.cedula = "";
                this.nombre = "";
                this.email = "";
                this.telefono = "";
                this.movil = "";                                
                this.direccion = "";
                this.salario = 0;
                this.fecing = "";
                this.fecegr = "";
                this.cargo_id = 0;
                this.institucion_id = 0;                 
                this.tituloModal = "";
            },

            //Paginacion
            cambiarPagina(page, buscar, criterio){
                let me = this;
                //Actualiza la pagina actual
                me.pagination.current_page = page;
                me.listarEmpleado(page, buscar, criterio);
            },

            salir() {
                this.listarEmpleado(1, this.buscar, this.criterio);
                //this.curso_id= 0;
                this.listado = 1;
            },

/////////////////Funciones de modulo de Asignacion de cursos a empleados ///////////////////
            abrirCursos() {
                this.empleados = []; 
                this.checkEmpleado = [];               
                this.listado = 2;
                this.selectCurso();                
            },

            listarCursoEmpleado() {
                let me = this;

                var url = '/curso/selectCursoEmpleado/'+me.curso_id;
                    
                axios.get(url).then(function (response) {
                    // handle success  
                    
                    var respuesta = response.data;
                    me.empleados = respuesta.empleados;   
                    console.log("Empleado : ", me.empleados);
                  })
                  .catch(function (error) {
                    // handle error
                    console.log(error);
                  })
                  .finally(function () {
                    // always executed
                  });

            },

            registrarCursoEmpleados() {
                const alerta = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',                    
                  },
                 buttonsStyling: false,
                })

                let me = this;
                let empleadosCheck = me.checkEmpleado.length;

                if(empleadosCheck > 0) {
                    console.log("Checks : "+me.checkEmpleado.length);
                    var url = '/curso/registrarCursoEmpleado';
                
                    axios.post(url, {
                        'id':me.curso_id,
                        data: me.checkEmpleado,
                    }).then(function (response) {                        
                        console.log(response);
                        Swal.fire(                       
                            'Curso asignado con exito!'                        
                            )
                        me.salir();
                    }).catch(function (error) {
                    // handle error
                    console.log(error);
                    });
                } else {
                    alerta.fire(
                        'Error!',
                        'Debe seleccionar al menos un empleado',
                        'error'
                    );                            
                }                
            },           

            //Curso
            selectCurso() {
                let me = this;

                var url = '/curso/selectCurso';

                axios.get(url).then(function (response) {
                    // handle success   
                    console.log(response)                 
                    var respuesta = response.data;
                    me.arrayCurso = respuesta.cursos;                      
                  })
                  .catch(function (error) {
                    // handle error
                    console.log(error);
                  })
                  .finally(function () {
                    // always executed
                  });
            },  

            selectEmpleados(curso_id) {
                this.listarCursoEmpleado();
            },
            
////////////////////////////////////////////////////////////////////////////////////////////
/////////////////Funciones de modulo de Asignacion de objetivos a empleados ///////////////////
        abrirObjetivos() {
                this.empleados = [];                
                this.checkEmpleado = [];
                this.listado = 3;
                this.selectObjetivo();                
            },

        listarObjetivoEmpleado() {
                let me = this;

                var url = '/objetivo/selectObjetivoEmpleado/'+me.objetivo_id;

                axios.get(url).then(function (response) {
                    // handle success                    
                    var respuesta = response.data;
                    me.empleados = respuesta.empleados;                      
                  })
                  .catch(function (error) {
                    // handle error
                    console.log(error);
                  })
                  .finally(function () {
                    // always executed
                  });

        },

        registrarObjetivoEmpleados() {
                 const alerta = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',                    
                  },
                 buttonsStyling: false,
                })

                let me = this;
                let empleadosCheck = me.checkEmpleado.length;

                if(empleadosCheck > 0) {
                    console.log("Checks : "+me.checkEmpleado.length);
                    var url = '/objetivo/registrarObjetivoEmpleado';
                
                    axios.post(url, {
                        'id':me.objetivo_id,
                        data: me.checkEmpleado,
                    }).then(function (response) {                        
                        console.log(response);
                        Swal.fire(                       
                            'Objetivo asignado con exito!'                        
                            )
                        me.salir();
                    }).catch(function (error) {
                    // handle error
                    console.log(error);
                    });
                } else {
                    alerta.fire(
                        'Error!',
                        'Debe seleccionar al menos un empleado',
                        'error'
                    );                            
                }                
            },

        selectObjetivo() {
                let me = this;

                var url = '/objetivo/selectObjetivo';

                axios.get(url).then(function (response) {
                    // handle success                    
                    var respuesta = response.data;
                    me.arrayObjetivo = respuesta.objetivos;                      
                  })
                  .catch(function (error) {
                    // handle error
                    console.log(error);
                  })
                  .finally(function () {
                    // always executed
                  });                  
            },  
        selectObjetivoEmpleado() {
            this.listarObjetivoEmpleado();
        }
////////////////////////////////////////////////////////////////////////////////////////////
        },

        mounted() {            
            this.listarEmpleado(1, this.buscar, this.criterio);        
        }
    }
</script>