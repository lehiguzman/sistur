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

                       <h2>Tipo de nominas</h2><br/>
                      
                        <button class="btn btn-primary btn-lg" type="button" @click="abrirModal('tipoNomina', 'registrar')">
                            <i class="fa fa-plus fa-2x"></i>&nbsp;&nbsp;Agregar tipo de nomina
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                        <option value="nombre">Nombre</option>
                                    </select>
                                    <input type="text" @keyup.enter="listarTipoNomina(1,buscar,criterio);" class="form-control" placeholder="Buscar texto" v-model="buscar">
                                    <button type="submit"  @click="listarTipoNomina(1,buscar,criterio);" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr class="bg-primary">                                   
                                    <th>Nombre</th>                                    
                                    <th>Editar</th>
                                    <th>Eliminar</th>                                   
                                </tr>
                            </thead>
                            <tbody>                               
                                <tr v-for="tipoNomina in tipoNominas" :key="tipoNomina.id">
                                    
                                    <td v-text="tipoNomina.nombre"></td>                                     
                                        <button type="button" class="btn btn-info btn-md" @click="abrirModal( 'tipoNomina', 'actualizar', tipoNomina )">
                                          <i class="fa fa-edit fa-2x"></i> Editar
                                        </button> &nbsp;
                                    </td>                               
                                    <td>
                                        <button type="button" class="btn btn-danger btn-md" @click="eliminarTipoNomina(tipoNomina.id)">
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
                            
                            <div v-show="errorTipoNomina" class="form-group row div-error">
                                
                                <div class="text-center text-error">
                                    
                                    <div v-for="error in errorMostrarMsjTipoNomina" :key="error" v-text="error"></div>

                                </div>
                            
                            </div>
                             

                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de nomina">
                                    </div>
                                </div>                                                      
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" @click="cerrarModal()" class="btn btn-danger"><i class="fa fa-times fa-2x"></i> Cerrar</button>
                            <button type="button" @click="registrarTipoNomina()" v-if="tipoAccion==1" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Guardar</button>
                            <button type="button" @click="actualizarTipoNomina()" v-if="tipoAccion==2" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Actualizar</button>                           
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
                tipoNominas: [],
                nombre: "",                 
                tipoNomina_id: 0,               

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
                errorTipoNomina:0,
                errorMostrarMsjTipoNomina:[],
                tipoAccion: '',
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
            listarTipoNomina(page, buscar, criterio) {
                let me = this; 
                var url = '/tipoNomina?page='+ page + '&buscar=' + buscar + '&criterio=' + criterio;

                axios.get(url).then( function( response ) {                    
                    
                    var respuesta = response.data;
                    me.tipoNominas = respuesta.tipoNominas.data;

                });                               
            },

            registrarTipoNomina(){
                const alerta = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',                    
                  },
                 buttonsStyling: false,
                })

                if(this.validarTipoNomina()) {
                    return;
                }

                let me=this;
                axios.post('/tipoNomina/registrar', {
                        'nombre':me.nombre 
                    }).then(function (response) {
                        alerta.fire("Tipo de nomina registrado exitosamente");
                        me.cerrarModal();
                        me.listarTipoNomina(1, '', 'nombre');
                    }).catch(function (error) {
                    // handle error
                    console.log(error);
                    });
            },

            actualizarTipoNomina(){
                const alerta = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',                    
                  },
                 buttonsStyling: false,
                })

                if(this.validarTipoNomina()) {
                    return;
                }

                let me=this;
                axios.put('/tipoNomina/actualizar', {
                        'id':me.tipoNomina_id,
                        'nombre':me.nombre                        
                    }).then(function (response) {
                        alerta.fire("Tipo de nomina editado exitosamente");
                        me.cerrarModal();
                        me.listarTipoNomina(1, '', 'nombre');
                    }).catch(function (error) {
                    // handle error
                    console.log(error);
                    });
            },

            eliminarTipoNomina(id) {
                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                  },
                 buttonsStyling: false,
                })

                swalWithBootstrapButtons.fire({
                  title: '¿Estás seguro de eliminar el Tipo de nomina?',
                  //type: 'warning',
                  showCancelButton: true,
                  confirmButtonText: '<i class="fa fa-check fa-2x"></i> Aceptar',
                  cancelButtonText: '<i class="fa fa-times fa-2x"></i> Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {
                        
                    let me=this;
                        axios.delete('/tipoNomina/eliminar/'+id).then(function (response) {  
                                //console.log( response );
                                me.listarTipoNomina(1, '', 'nombre');
                                swalWithBootstrapButtons.fire(
                                    'Eliminado!',
                                    'Tipo de nomina eliminado.',
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

            validarTipoNomina() {
                this.errorTipoNomina=0;
                this.errorMostrarMsjTipoNomina=[];

                if(!this.nombre){
                    this.errorMostrarMsjTipoNomina.push("(*) El nombre no puede estar vacio");
                }

                if(this.errorMostrarMsjTipoNomina.length) this.errorTipoNomina=1;
                return this.errorTipoNomina;
            },      

            //Modal
            abrirModal(modelo, accion, data=[]) {                   
                switch(modelo) {
                    case "tipoNomina": {
                        switch(accion){
                            case "registrar":{
                                this.modal = 1;
                                this.tituloModal="Registrar tipo de nomina";
                                this.tipoAccion = 1;
                                this.nombre = "";                               
                                break;
                            }
                            case "actualizar": {
                                this.modal = 1;
                                this.tituloModal = "Editar tipo de nomina";
                                this.tipoAccion=2;
                                this.tipoNomina_id = data["id"];
                                this.nombre = data["nombre"];
                                break;
                            }                         
                        }
                    }
                }                
            },            

            cerrarModal() { 
                this.modal = 0;
                this.nombre = "";                       
                this.tituloModal = "";
            },

            //Paginacion
            cambiarPagina(page, buscar, criterio){
                let me = this;
                //Actualiza la pagina actual
                me.pagination.current_page = page;
                me.listarTipoNomina(page, buscar, criterio);
            },

        },

        mounted() {
            this.listarTipoNomina(1, this.buscar, this.criterio);        
        }
    }
</script>