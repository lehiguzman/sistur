<template>
    <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="/">SISTEMA DE CALIDAD DE TURISMO</a></li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">

                       <h2>Ausencia</h2><br/>
                      
                        <button class="btn btn-primary btn-lg" type="button" @click="abrirModal('ausencia', 'registrar')">
                            <i class="fa fa-plus fa-2x"></i>&nbsp;&nbsp;Agregar ausencia
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                        <option value="nombre">Nombre</option>
                                    </select>
                                    <input type="text" @keyup.enter="listarAusencia(1,buscar,criterio);" class="form-control" placeholder="Buscar texto" v-model="buscar">
                                    <button type="submit"  @click="listarAusencia(1,buscar,criterio);" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr class="bg-primary">                                   
                                    <th>Empleado</th>
                                    <th>Fecha ausencia</th>
                                    <th>Tipo de ausencia</th>
                                    <th>Editar</th> 
                                    <th>Eliminar</th>                    
                                </tr>
                            </thead>
                            <tbody>                               
                                <tr v-for="ausencia in ausencias" :key="ausencia.id">
                                    
                                    <td v-text="ausencia.nombre"></td> 
                                    <td v-text="ausencia.fecfal"></td>                                  
                                    <td v-if="ausencia.tipo == 1">Medio dia</td>
                                    <td v-if="ausencia.tipo == 2">Dia completo</td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-md" @click="abrirModal( 'ausencia', 'actualizar', ausencia )">
                                          <i class="fa fa-edit fa-2x"></i> Editar
                                        </button> &nbsp;
                                    </td>                               
                                    <td>
                                        <button type="button" class="btn btn-danger btn-md" @click="eliminarAusencia(ausencia.id)">
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
                </div>
                <!-- Fin ejemplo de tabla Listado -->
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
                            
                            <div v-show="errorAusencia" class="form-group row div-error">
                                
                                <div class="text-center text-error">
                                    
                                    <div v-for="error in errorMostrarMsjAusencia" :key="error" v-text="error"></div>

                                </div>
                            
                            </div>
                             

                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Empleado</label>
                                    <div class="col-md-9">
                                        
                                        <!--la variable idcategoria asociado a v-model la asignamos
                                        en la propiedad data en javascript (ver al final) -->

                                        <select class="form-control" v-model="empleado_id">
                                          
                                          <!-- el id y nombre asociado en el objeto categoria vienen de los campos
                                          de la tabla categorias de la bd-->
                                          <option value="0" disabled>Seleccione</option>
                                          <!--el arrayCategoria es una variable de la data javascript de vue 
                                          y se cargan los registros de la categoria una vez se abra la ventana
                                          modal-->
                                          <option v-for="empleado in arrayEmpleado" :key="empleado.id" :value="empleado.id" v-text="empleado.nombre"></option>

                                        </select>
                                       
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Fecha</label>
                                    <div class="col-md-9">
                                        <datepicker bootstrap-styling v-model="fecfal" :format="formatoFecha" placeholder="Fecha de la ausencia"></datepicker>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Tipo de ausencia</label>
                                    <div class="col-md-9">
                                        
                                        <!--la variable idcategoria asociado a v-model la asignamos
                                        en la propiedad data en javascript (ver al final) -->

                                        <select class="form-control" v-model="tipo">
                                          
                                          <!-- el id y nombre asociado en el objeto categoria vienen de los campos
                                          de la tabla categorias de la bd-->
                                          <option value="0" disabled>Seleccione</option>
                                          <option value="1">Medio dia</option>
                                           <option value="2">Dia completo</option>
                                          
                                        </select>
                                       
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Observacion </label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="observacion" class="form-control" placeholder="Observación">
                                    </div>
                                </div>                            
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" @click="cerrarModal()" class="btn btn-danger"><i class="fa fa-times fa-2x"></i> Cerrar</button>
                            <button type="button" @click="registrarAusencia()" v-if="tipoAccion==1" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Guardar</button>
                            <button type="button" @click="actualizarAusencia()" v-if="tipoAccion==2" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Actualizar</button>                           
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
    import Datepicker from 'vuejs-datepicker';
    import moment from 'moment';

    export default {
        data() {
            return {
                ausencias: [],
                fecfal: "",                 
                observacion: "",
                ausencia_id: 0,    
                tipo: 0,           

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

                //modal
                modal:0, //0=Modal abierto / 1=Modal cerrado
                tituloModal:'',

                //Errores
                errorAusencia:0,
                errorMostrarMsjAusencia:[],
                tipoAccion: '',

                //Empleados
                empleado_id: 0,
                arrayEmpleado: [],
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

        components: {
            Datepicker
        },

        methods: {

            formatoFecha(date) {
                
                return moment(date).format('DD/MM/YYYY');

            },

            //Modulo
            listarAusencia(page, buscar, criterio) {
                let me = this; 
                var url = '/ausencia?page='+ page + '&buscar=' + buscar + '&criterio=' + criterio;

                axios.get(url).then( function( response ) {                    
                    
                    var respuesta = response.data;
                    me.ausencias = respuesta.ausencias.data;
                    
                });                               
            },

            registrarAusencia(){
                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',                    
                  },
                 buttonsStyling: false,
                })

                if(this.validarAusencia()) {
                    return;
                }
                let me=this;
                let fecfal = moment( me.fecfal ).format("YYYY-MM-DD");
                axios.post('/ausencia/registrar', {
                        'fecfal':fecfal,
                        'tipo':me.tipo,
                        'observacion':me.observacion,
                        'empleado_id':me.empleado_id,
                    }).then(function (response) {
                        swalWithBootstrapButtons.fire(                                    
                                    'Ausencia registrada exitosamente.'                                    
                                )
                        me.cerrarModal();
                        me.listarAusencia(1, '', 'nombre');
                    }).catch(function (error) {
                    // handle error
                    console.log(error);
                    });
            },

            actualizarAusencia(){
                if(this.validarAusencia()) {
                    return;
                }
                let me=this;
                let fecfal = moment( me.fecfal ).format("YYYY-MM-DD");

                axios.put('/ausencia/actualizar', {
                        'id':me.ausencia_id,
                        'fecfal':fecfal,
                        'tipo':me.tipo,                        
                        'observacion':me.observacion,
                        'empleado_id':me.empleado_id,
                    }).then(function (response) {
                        //console.log( response );
                        me.cerrarModal();
                        me.listarAusencia(1, '', 'nombre');
                    }).catch(function (error) {
                    // handle error
                    console.log(error);
                    });
            },

            eliminarAusencia(id) {
                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                  },
                 buttonsStyling: false,
                })

                swalWithBootstrapButtons.fire({
                  title: '¿Estás seguro de eliminar la ausencia?',
                  //type: 'warning',
                  showCancelButton: true,
                  confirmButtonText: '<i class="fa fa-check fa-2x"></i> Aceptar',
                  cancelButtonText: '<i class="fa fa-times fa-2x"></i> Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {
                        
                    let me=this;
                        axios.delete('/ausencia/eliminar/'+id).then(function (response) {  
                                console.log( response );
                                me.listarAusencia(1, '', 'nombre');
                                swalWithBootstrapButtons.fire(
                                    'Eliminado!',
                                    'Ausencia eliminada.',
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

            validarAusencia() {
                this.errorAusencia=0;
                this.errorMostrarMsjAusencia=[];

                if(!this.empleado_id){
                    this.errorMostrarMsjAusencia.push("(*) debe seleccionar un empleado");
                }

                if(!this.fecfal){
                    this.errorMostrarMsjAusencia.push("(*) La fecha no puede estar vacia");
                }

                if(!this.tipo){
                    this.errorMostrarMsjAusencia.push("(*) Debe seleccionar un tipo de ausencia");
                }

                if(this.errorMostrarMsjAusencia.length) this.errorAusencia=1;
                return this.errorAusencia;
            },      

            //Modal
            abrirModal(modelo, accion, data=[]) {                   
                switch(modelo) {
                    case "ausencia": {
                        switch(accion){
                            case "registrar":{
                                this.modal = 1;
                                this.tituloModal="Registrar ausencia";
                                this.tipoAccion = 1;
                                this.fecfal = "";                                
                                this.tipo = "";                                
                                this.observacion = "";                                
                                this.empleado_id = "";                                
                                break;
                            }
                            case "actualizar": {
                                this.modal = 1;
                                this.tituloModal = "Editar ausencia";
                                this.tipoAccion=2;
                                this.ausencia_id = data["id"];
                                this.fecfal = data["fecfal"];
                                this.tipo = data["tipo"];                                
                                this.observacion = data["observacion"];                                 
                                this.empleado_id = data["empleado_id"];
                                break;
                            }                         
                        }
                        this.selectEmpleado();
                    }
                }                
            },            

            cerrarModal() { 
                this.modal = 0;
                this.fecfal = "";                
                this.tipo = 0;                
                this.observacion = "";                
                this.empleado_id = 0;                
                this.tituloModal = "";
            },            

            //Paginacion
            cambiarPagina(page, buscar, criterio){
                let me = this;
                //Actualiza la pagina actual
                me.pagination.current_page = page;
                me.listarAusencia(page, buscar, criterio);
            },

            //Empleado
            selectEmpleado() {
                let me = this;

                var url = '/empleado/selectEmpleado';

                axios.get(url).then(function (response) {
                    // handle success
                    console.log("respuesta : ", response);
                    var respuesta = response.data;
                    me.arrayEmpleado = respuesta.empleados;                    
                  })
                  .catch(function (error) {
                    // handle error
                    console.log(error);
                  })
                  .finally(function () {
                    // always executed
                  });
            },

        },

        mounted() {
            this.listarAusencia(1, this.buscar, this.criterio);        
        }
    }
</script>