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

                       <h2>Tipos de Empresas</h2><br/>
                      
                        <button class="btn btn-primary btn-lg" type="button" @click="abrirModal('tipo', 'registrar')">
                            <i class="fa fa-plus fa-2x"></i>&nbsp;&nbsp;Agregar Tipo de empresa
                        </button>
                    </div>
                    <div class="card-body">                        
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr class="bg-primary">                                   
                                    <th>Tipo</th>                                    
                                    <th>Editar</th> 
                                    <th>Eliminar</th>                                    
                                </tr>
                            </thead>
                            <tbody>                               
                                <tr v-for="tipo in tipos" :key="tipo.id">
                                    
                                    <td v-text="tipo.nombre"></td>                                   
                                    <td>
                                        <button type="button" class="btn btn-info btn-md" @click="abrirModal('tipo', 'actualizar', tipo )">
                                          <i class="fa fa-edit fa-2x"></i> Editar
                                        </button> &nbsp;
                                    </td>                               
                                    <td>
                                        <button type="button" class="btn btn-danger btn-md" @click="eliminarTipo(tipo.id)">
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
                            
                            <div v-show="errorTipo" class="form-group row div-error">
                                
                                <div class="text-center text-error">
                                    
                                    <div v-for="error in errorMostrarMsjTipo" :key="error" v-text="error"></div>

                                </div>
                            
                            </div>
                             

                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Tipo de empresa</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Tipo de empresa">                                       
                                    </div>
                                </div>                                
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" @click="cerrarModal()" class="btn btn-danger"><i class="fa fa-times fa-2x"></i> Cerrar</button>
                            <button type="button" @click="registrarTipo()" v-if="tipoAccion==1" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Guardar</button>
                            <button type="button" @click="actualizarTipo()" v-if="tipoAccion==2" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Actualizar</button>                           
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
                tipos: [],
                nombre: "", 
                tipo_id: 0,               

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
                errorTipo:0,
                errorMostrarMsjTipo:[],
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
            listarTipo(page, buscar, criterio) {
                let me = this; 
                var url = '/tipo';

                axios.get(url).then( function( response ) {                    
                    me.tipos = response.data;
                });                               
            },

            registrarTipo(){
                if(this.validarTipo()) {
                    return;
                }
                let me=this;
                axios.post('/tipo/registrar', {
                        'nombre':me.nombre,
                    }).then(function (response) {
                        me.cerrarModal();
                        me.listarTipo(1, '', 'nombre');
                    }).catch(function (error) {
                    // handle error
                    console.log(error);
                    });
            },

            actualizarTipo(){
                if(this.validarTipo()) {
                    return;
                }
                let me=this;
                axios.put('/tipo/actualizar', {
                        'id':me.tipo_id,
                        'nombre':me.nombre,                        
                    }).then(function (response) {
                        //console.log( response );
                        me.cerrarModal();
                        me.listarTipo(1, '', 'nombre');
                    }).catch(function (error) {
                    // handle error
                    console.log(error);
                    });
            },

            eliminarTipo(id) {
                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                  },
                 buttonsStyling: false,
                })

                swalWithBootstrapButtons.fire({
                  title: '¿Estás seguro de eliminar el tipo de empresa?',
                  //type: 'warning',
                  showCancelButton: true,
                  confirmButtonText: '<i class="fa fa-check fa-2x"></i> Aceptar',
                  cancelButtonText: '<i class="fa fa-times fa-2x"></i> Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {
                        
                    let me=this;
                        axios.delete('/tipo/eliminar/'+id).then(function (response) {  
                                //console.log( response );
                                me.listarTipo(1, '', 'nombre');
                                swalWithBootstrapButtons.fire(
                                    'Eliminado!',
                                    'Tipo de Empresa eliminada.',
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

            validarTipo() {
                this.errorTipo=0;
                this.errorMostrarMsjTipo=[];

                if(!this.nombre){
                    this.errorMostrarMsjTipo.push("(*) El tipo de empresa no puede estar vacio");
                }

                if(this.errorMostrarMsjTipo.length) this.errorTipo=1;
                return this.errorTipo;
            },      

            //Modal
            abrirModal(modelo, accion, data=[]) {                   
                switch(modelo) {
                    case "tipo": {
                        switch(accion){
                            case "registrar":{
                                this.modal = 1;
                                this.tituloModal="Registrar Tipo de empresa";
                                this.tipoAccion = 1;
                                this.nombre = "";                                
                                break;
                            }
                            case "actualizar": {
                                this.modal = 1;
                                this.tituloModal = "Editar Tipo de empresa";
                                this.tipoAccion=2;
                                this.tipo_id = data["id"];
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
                me.listarTipo(page, buscar, criterio);
            },

        },

        mounted() {
            this.listarTipo(1, this.buscar, this.criterio);           
        }
    }
</script>