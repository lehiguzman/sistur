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

                       <h2>Objetivos</h2><br/>
                      
                        <button class="btn btn-primary btn-lg" type="button" @click="mostrarDetalle()">
                            <i class="fa fa-plus fa-2x"></i>&nbsp;&nbsp;Nuevo objetivo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                        <option value="titulo">Objetivo</option>
                                    </select>
                                    <input type="text" @keyup.enter="listarObjetivo(1,buscar,criterio);" class="form-control" placeholder="Buscar texto" v-model="buscar">
                                    <button type="submit"  @click="listarObjetivo(1,buscar,criterio);" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr class="bg-primary">                                   
                                    <th>Objetivo</th>
                                    <th>Descripción</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>                               
                                <tr v-for="objetivo in objetivos" :key="objetivo.id">
                                    
                                    <td v-text="objetivo.titulo"></td> 
                                    <td v-text="objetivo.descripcion"></td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-md" @click="eliminarObjetivo(objetivo.id)">
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
                    </template>
                    <template v-else-if="listado==0">
                        <span><strong>(*) Campo obligatorio</strong></span><br/>                     

                        <h3 class="text-center">LLenar el formulario</h3>

                    <div class="card-body">

                        <div class="form-group row border">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="text-uppercase"><strong>Titulo del objetivo(*)</strong></label>
                                    <input type="text" class="form-control" v-model="titulo" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="text-uppercase"><strong>descripción(*)</strong></label>
                                    <input type="text" class="form-control" v-model="descripcion" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div v-show="errorObjetivo" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjObjetivo" :key="error" v-text="error">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row border">                            
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button @click="abrirModal('etapa', 'registrar')" class="btn btn-primary form-control btnagregar"><i class="fa fa-plus fa-2x"></i> Agregar etapa</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row border">

                            <h3>Lista de Etapas del Objetivo</h3>

                            <div class="table-responsive col-md-10">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr class="bg-success">
                                            <th>Eliminar</th>
                                            <th>Etapa</th>
                                            <th>Descripción</th>
                                            <th>Fecha de inicio</th>
                                            <th>Fecha de finalización</th>
                                            <th>Estatuss</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayDetalle.length">
                                        <tr v-for="(detalle,index) in arrayDetalle" :key="detalle.id">
                                            <td>
                                                <button @click="eliminarDetalle(index)" type="button" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-times fa-2x"></i>
                                                </button>
                                            </td>
                                            <td v-text="detalle.titulo">
                                            </td>  
                                            <td v-text="detalle.descripcion">
                                            </td>
                                            <td v-text="detalle.fecini">
                                            </td>
                                            <td v-text="detalle.fecfin">
                                            </td>
                                            <td v-if="detalle.estatus == 1">
                                                Activo
                                            </td>
                                            <td v-else>
                                                Inactivo
                                            </td>
                                        </tr>                                        
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="6">
                                                No se han agregado etapas al objetivo
                                            </td>
                                        </tr>
                                    </tbody>                                    
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="salir()" class="btn btn-danger"><i class="fa fa-times fa-2x"></i> Cerrar</button>
                        <button type="button" @click="registrarObjetivo()" v-if="tipoAccion==1" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Guardar</button>
                    </div>
                    </template>                    
                </div>                
            </div>   
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
                            
                            <div v-show="errorEtapa" class="form-group row div-error">
                                
                                <div class="text-center text-error">
                                    
                                    <div v-for="error in errorMostrarMsjEtapa" :key="error" v-text="error"></div>

                                </div>
                            
                            </div>                            

                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre de la Etapa</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="tituloEtapa" class="form-control" placeholder="Nombre de Etapa">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Descripción</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="descripcionEtapa" class="form-control" placeholder="Descripción de la etapa">
                                    </div>
                                </div>  
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Fecha de inicio</label>
                                    <div class="col-md-9">
                                        <datepicker bootstrap-styling v-model="fecini" :format="formatoFecha" placeholder="Fecha de inicio"></datepicker>
                                    </div>
                                </div> 
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Fecha de finalización</label>
                                    <div class="col-md-9">
                                        <datepicker bootstrap-styling v-model="fecfin" :format="formatoFecha" placeholder="Fecha de finalización"></datepicker>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Estatus</label>
                                    <div class="col-md-9">
                                        
                                        <!--la variable idcategoria asociado a v-model la asignamos
                                        en la propiedad data en javascript (ver al final) -->

                                        <select class="form-control" v-model="estatus">
                                          
                                          <!-- el id y nombre asociado en el objeto categoria vienen de los campos
                                          de la tabla categorias de la bd-->
                                          <option disabled selected="selected">Seleccione</option>
                                          <option value="1">Activo</option>
                                           <option value="0">Inactivo</option>
                                          
                                        </select>
                                       
                                    </div>
                                </div>  
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" @click="cerrarModal()" class="btn btn-danger"><i class="fa fa-times fa-2x"></i> Cerrar</button>
                            <button type="button" @click="agregarDetalle()" v-if="tipoAccion==1" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Agregar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>                
                <!-- Fin Template condicionado -->
                  
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

        @media (min-width: 600px) {
        .btnagregar {
            margin-top: 2rem;
        }
    }
</style>

<script>
    import Datepicker from 'vuejs-datepicker';
    import moment from 'moment';

    export default {
        data() {
            return {
                objetivos: [],
                titulo: "", 
                descripcion: "", 
                objetivo_id: 0,

                //Etapas
                tituloEtapa: '',
                descripcionEtapa: '',
                fecini: '',
                fecfin: '',
                estatus: '',           

                //por defecto
                pagination: {
                    'total' : 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from' : 0,
                    'to' : 0,
                },
                criterio: 'titulo',
                buscar: '',

                //modal
                modal:0, //0=Modal abierto / 1=Modal cerrado
                tituloModal:'',

                //Errores
                errorObjetivo:0,
                errorMostrarMsjObjetivo:[],
                errorEtapa:0,
                errorMostrarMsjEtapa:[],
                tipoAccion: '',

                //Listado
                listado: 1,
                arrayDetalle: [],
            }            
        },

        components: {
            Datepicker
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

            formatoFecha(date) {
                
                return moment(date).format('DD/MM/YYYY');

            },

            //Modulo
            listarObjetivo(page, buscar, criterio) {
                let me = this; 
                var url = '/objetivo?page='+ page + '&buscar=' + buscar + '&criterio=' + criterio;

                axios.get(url).then( function( response ) {                    
                    
                    var respuesta = response.data;
                    me.objetivos = respuesta.objetivos.data;

                });                               
            },

            registrarObjetivo(){
                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',                    
                  },
                 buttonsStyling: false,
                })

                if(this.validarObjetivo()) {
                    return;
                }
                let me=this;  
                
                axios.post('/objetivo/registrar', {
                        'titulo':me.titulo,
                        'descripcion':me.descripcion,
                        'data': me.arrayDetalle
                    }).then(function (response) {    
                        swalWithBootstrapButtons.fire(
                            'Objetivo agregado exitosamente',
                            );
                        me.listado = 1;
                        me.titulo = '';
                        me.descripcion = '';
                        me.arrayDetalle = [];                    
                        me.listarObjetivo(1, '', 'titulo');
                    }).catch(function (error) {
                    // handle error
                    console.log(error);
                    });
            },           

            eliminarObjetivo(id) {
                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                  },
                 buttonsStyling: false,
                })

                swalWithBootstrapButtons.fire({
                  title: '¿Estás seguro de eliminar el Objetivo?',
                  //type: 'warning',
                  showCancelButton: true,
                  confirmButtonText: '<i class="fa fa-check fa-2x"></i> Aceptar',
                  cancelButtonText: '<i class="fa fa-times fa-2x"></i> Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {
                        
                    let me=this;
                        axios.delete('/objetivo/eliminar/'+id).then(function (response) {  
                                //console.log( response );
                                me.listarObjetivo(1, '', 'titulo');
                                swalWithBootstrapButtons.fire(
                                    'Eliminado!',
                                    'Objetivo eliminado.',
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

            validarObjetivo() {
                this.errorObjetivo=0;
                this.errorMostrarMsjObjetivo=[];

                if(!this.titulo){
                    this.errorMostrarMsjObjetivo.push("(*) El titulo no puede estar vacio");
                }                

                if(!this.descripcion){
                    this.errorMostrarMsjObjetivo.push("(*) La descripción no puede estar vacia");
                }

                if(this.errorMostrarMsjObjetivo.length) this.errorObjetivo=1;
                return this.errorObjetivo;
            },

            mostrarDetalle() {                
                let me = this;
                this.listado = 0;
                me.objetivo_id=0;
                me.nombre='';
                me.descripcion='';               
                me.fecini='';
                me.fecfin='';
                me.estatus='';
            },

            salir() {
            
                this.listarObjetivo(1, this.buscar, this.criterio);
                
                this.listado = 1;
            },

            ocultarDetalle() {
                this.listado = 1;   
            }, 

            agregarDetalle() {
                if(this.validarEtapa()) {
                    return;
                }
                let me = this; 
                let fecini = moment( me.fecini ).format("YYYY-MM-DD");
                let fecfin = moment( me.fecfin ).format("YYYY-MM-DD");           

                me.arrayDetalle.push({                 
                    titulo: me.tituloEtapa,
                    descripcion: me.descripcionEtapa,
                    fecini: fecini,
                    fecfin: fecfin,
                    estatus: me.estatus,
                });
                me.tituloEtapa= '';
                me.descripcionEtapa = '';
                me.fecini = '';
                me.fecfin = '';
                me.estatus = '';
                this.cerrarModal();
            },

            validarEtapa() {
                this.errorEtapa=0;
                this.errorMostrarMsjEtapa=[];

                if(!this.tituloEtapa){
                    this.errorMostrarMsjEtapa.push("(*) El titulo no puede estar vacio");
                }                

                if(!this.descripcionEtapa){
                    this.errorMostrarMsjEtapa.push("(*) La descripción no puede estar vacia");
                }

                 if(!this.fecini){
                    this.errorMostrarMsjEtapa.push("(*) La fecha de inicio no puede estar vacia");
                }

                 if(!this.fecfin){
                    this.errorMostrarMsjEtapa.push("(*) La fecha de finalización no puede estar vacia");
                }

                 if(!this.estatus){
                    this.errorMostrarMsjEtapa.push("(*) Debe seleccionar un estatus");
                }

                if(this.errorMostrarMsjEtapa.length) this.errorEtapa=1;
                return this.errorEtapa;
            },

            eliminarDetalle(index) {                
                let me = this;
                me.arrayDetalle.splice(index, 1);
            },   

            //Modal
            abrirModal(modelo, accion, data=[]) {                   
                switch(modelo) {
                    case "etapa": {
                        switch(accion){
                            case "registrar":{
                                this.modal = 1;
                                this.tituloModal="Registrar etapa";
                                this.tipoAccion = 1;                                
                                break;
                            }                                              
                        }
                    }
                }                
            },            

            cerrarModal() { 
                this.modal = 0;                                               
            },

            //Paginacion
            cambiarPagina(page, buscar, criterio){
                let me = this;
                //Actualiza la pagina actual
                me.pagination.current_page = page;
                me.listarObjetivo(page, buscar, criterio);
            },

        },

        mounted() {
            this.listarObjetivo(1, this.buscar, this.criterio);        
        }
    }
</script>