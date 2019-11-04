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

                       <h2>Listado de Empresas</h2><br/>
                      
                        <button class="btn btn-primary btn-lg" type="button" @click="abrirModal('institucion', 'registrar')">
                            <i class="fa fa-plus fa-2x"></i>&nbsp;&nbsp;Agregar Empresa
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                        <option value="nombre">Nombre</option>
                                    </select>
                                    <input type="text" @keyup.enter="listarInstitucion(1,buscar,criterio);" class="form-control" placeholder="Buscar texto" v-model="buscar">
                                    <button type="submit"  @click="listarInstitucion(1,buscar,criterio);" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr class="bg-primary">                                   
                                    <th>Nombre</th>
                                    <th>Telefono</th>
                                    <th>Dirección</th>
                                    <th>Editar</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                               
                                <tr v-for="institucion in instituciones" :key="institucion.id">
                                    
                                    <td v-text="institucion.nombre"></td>
                                    <td v-text="institucion.telefono"></td>
                                    <td v-text="institucion.direccion"></td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-md" @click="abrirModal('institucion', 'actualizar', institucion )">
                                          <i class="fa fa-edit fa-2x"></i> Editar
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
                            
                            <div v-show="errorInstitucion" class="form-group row div-error">
                                
                                <div class="text-center text-error">
                                    
                                    <div v-for="error in errorMostrarMsjInstitucion" :key="error" v-text="error"></div>

                                </div>
                            
                            </div>
                             

                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Empresa</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de empresa">                                       
                                    </div>
                                </div>                                
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Dirección</label>
                                    <div class="col-md-9">
                                    <input type="textarea" v-model="direccion" class="form-control" placeholder="Ingrese dirección">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Telefono</label>
                                    <div class="col-md-9">
                                    <input type="email" v-model="telefono" class="form-control" placeholder="Ingrese telefono">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Tipo de Empresa</label>
                                    <div class="col-md-9">
                                        
                                        <!--la variable idcategoria asociado a v-model la asignamos
                                        en la propiedad data en javascript (ver al final) -->

                                        <select class="form-control" v-model="tipo_id">
                                          
                                          <!-- el id y nombre asociado en el objeto categoria vienen de los campos
                                          de la tabla categorias de la bd-->
                                          <option value="0" disabled>Seleccione</option>
                                          <!--el arrayCategoria es una variable de la data javascript de vue 
                                          y se cargan los registros de la categoria una vez se abra la ventana
                                          modal-->
                                          <option v-for="tipo in arrayTipo" :key="tipo.id" :value="tipo.id" v-text="tipo.nombre"></option>

                                        </select>
                                       
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Rama</label>
                                    <div class="col-md-9">
                                        
                                        <!--la variable idcategoria asociado a v-model la asignamos
                                        en la propiedad data en javascript (ver al final) -->

                                        <select class="form-control" v-model="rama_id">
                                          
                                          <!-- el id y nombre asociado en el objeto categoria vienen de los campos
                                          de la tabla categorias de la bd-->
                                          <option value="0" disabled>Seleccione</option>
                                          <!--el arrayCategoria es una variable de la data javascript de vue 
                                          y se cargan los registros de la categoria una vez se abra la ventana
                                          modal-->
                                          <option v-for="rama in arrayRama" :key="rama.id" :value="rama.id" v-text="rama.titulo"></option>

                                        </select>
                                       
                                    </div>
                                </div>                                
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Estado</label>
                                    <div class="col-md-9">
                                        
                                        <!--la variable idcategoria asociado a v-model la asignamos
                                        en la propiedad data en javascript (ver al final) -->

                                        <select class="form-control" v-model="estado_id">
                                          
                                          <!-- el id y nombre asociado en el objeto categoria vienen de los campos
                                          de la tabla categorias de la bd-->
                                          <option value="0" disabled>Seleccione</option>
                                          <!--el arrayCategoria es una variable de la data javascript de vue 
                                          y se cargan los registros de la categoria una vez se abra la ventana
                                          modal-->
                                          <option v-for="estado in arrayEstado" :key="estado.id" :value="estado.id" v-text="estado.nombre"></option>

                                        </select>
                                       
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" @click="cerrarModal()" class="btn btn-danger"><i class="fa fa-times fa-2x"></i> Cerrar</button>
                            <button type="button" @click="registrarInstitucion()" v-if="tipoAccion==1" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Guardar</button>
                            <button type="button" @click="actualizarInstitucion()" v-if="tipoAccion==2" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Actualizar</button>                           
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
                instituciones: [],
                nombre: "",
                telefono: "",
                direccion: "",

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
                errorInstitucion:0,
                errorMostrarMsjInstitucion:[],
                tipoAccion: '',

                //Ramas
                rama_id: 0,
                arrayRama: [],

                //Tipos
                tipo_id: 0,
                arrayTipo: [],

                //Estados
                estado_id: 0,
                arrayEstado: []
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
            listarInstitucion(page, buscar, criterio) {
                let me = this; 

                var url = '/institucion?page='+ page + '&buscar=' + buscar + '&criterio=' + criterio;
                    
                axios.get(url).then( function( response ) {                  
                    
                    var respuesta = response.data;
                    me.instituciones = respuesta.instituciones.data;
                    
                });                               
            },

            registrarInstitucion(){
                const alerta = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',                    
                  },
                 buttonsStyling: false,
                })

                if(this.validarInstitucion()) {
                    return;
                }
                let me=this;
                axios.post('/institucion/registrar', {
                        'nombre':me.nombre,
                        'telefono':me.telefono,
                        'direccion':me.direccion,
                        'rama_id': me.rama_id,
                        'tipo_id': me.tipo_id,
                        'estado_id': me.estado_id,
                    }).then(function (response) {
                        alerta.fire("Empresa registrada exitosamente");
                        me.cerrarModal();
                        me.listarInstitucion(1, '', 'nombre');
                    }).catch(function (error) {
                    // handle error
                    console.log(error);
                    });
            },

            actualizarInstitucion(){
                const alerta = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',                    
                  },
                 buttonsStyling: false,
                })

                if(this.validarInstitucion()) {
                    return;
                }

                let me=this;
                axios.put('/institucion/actualizar', {
                        'id':me.institucion_id,
                        'nombre':me.nombre,
                        'telefono':me.telefono,
                        'direccion':me.direccion,
                        'rama_id': me.rama_id,
                        'tipo_id': me.tipo_id,
                        'estado_id': me.estado_id,
                    }).then(function (response) {
                        alerta.fire("Empresa actualizada exitosamente");
                        me.cerrarModal();
                        me.listarInstitucion(1, '', 'nombre');
                    }).catch(function (error) {
                    // handle error
                    console.log(error);
                    });
            },

            validarInstitucion() {
                this.errorInstitucion=0;
                this.errorMostrarMsjInstitucion=[];

                if(!this.nombre){
                    this.errorMostrarMsjInstitucion.push("(*) El nombre de la empresa no puede estar vacio");
                }

                if(!this.telefono){
                    this.errorMostrarMsjInstitucion.push("(*) El telefono de la empresa no puede estar vacio");
                }

                if(!this.direccion){
                    this.errorMostrarMsjInstitucion.push("(*) La dirección de la empresa no puede estar vacio");
                }

                if(!this.rama_id){
                    this.errorMostrarMsjInstitucion.push("(*) La rama de la empresa no puede estar vacio");
                }

                if(!this.tipo_id){
                    this.errorMostrarMsjInstitucion.push("(*) El tipo de empresa no puede estar vacio");
                }

                if(!this.estado_id){
                    this.errorMostrarMsjInstitucion.push("(*) Debe seleccionar un estado");
                }

                if(this.errorMostrarMsjInstitucion.length) this.errorInstitucion=1;
                return this.errorInstitucion;
            },      

            //Modal
            abrirModal(modelo, accion, data=[]) {   
                console.log(accion);
                switch(modelo) {
                    case "institucion": {
                        switch(accion){
                            case "registrar":{
                                this.modal = 1;
                                this.tituloModal="Registrar Empresa"
                                this.nombre = "";   
                                this.rama_id=0;
                                this.tipo_id=0; 
                                this.estado_id=0;                             
                                this.tipoAccion = 1;
                                break;
                            }
                            case "actualizar": {
                                this.modal = 1;
                                this.tituloModal = "Editar Empresa";
                                this.tipoAccion=2;
                                this.institucion_id = data["id"];                                
                                this.nombre = data["nombre"];
                                this.telefono = data["telefono"];
                                this.direccion = data["direccion"]; 
                                this.rama_id = data["rama_id"];
                                this.tipo_id = data["tipo_id"];
                                this.estado_id = data["estado_id"];                          
                                break;
                            }
                        }
                    }
                    this.selectRama();
                    this.selectTipo();
                    this.selectEstado();
                }                
            },            

            cerrarModal() { 
                this.modal = 0;
                this.nombre = "";
                this.telefono = "";
                this.direccion = "";
                this.tituloModal = "";
            },

            //Paginacion
            cambiarPagina(page, buscar, criterio){
                let me = this;
                //Actualiza la pagina actual
                me.pagination.current_page = page;
                me.listarInstitucion(page, buscar, criterio);
            },


            //Rama
            selectRama() {
                let me = this;

                var url = '/rama/selectRama';

                axios.get(url).then(function (response) {
                    // handle success
                    console.log(response);
                    var respuesta = response.data;
                    me.arrayRama = respuesta.ramas;                    
                  })
                  .catch(function (error) {
                    // handle error
                    console.log(error);
                  })
                  .finally(function () {
                    // always executed
                  });
            },

            //Tipo
            selectTipo() {
                let me = this;

                var url = '/tipo/selectTipo';

                axios.get(url).then(function (response) {
                    // handle success
                    console.log(response);
                    var respuesta = response.data;
                    me.arrayTipo = respuesta.tipos;                    
                  })
                  .catch(function (error) {
                    // handle error
                    console.log(error);
                  })
                  .finally(function () {
                    // always executed
                  });
            },

            //Estado
            selectEstado() {
                let me = this;

                var url = '/estado/selectEstado';

                axios.get(url).then(function (response) {
                    // handle success
                    console.log(response);
                    var respuesta = response.data;
                    me.arrayEstado = respuesta.estados;
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
            this.listarInstitucion(1, this.buscar, this.criterio);           
        }
    }
</script>

