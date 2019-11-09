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

                   <h2>Cuestionario</h2><br/>
                  
                    <button class="btn btn-primary btn-lg" type="button" @click="mostrarDetalle()">
                        <i class="fa fa-plus fa-2x"></i>&nbsp;&nbsp;Agregar cuestionario
                    </button>
                    <button type="button" class="btn btn-success btn-lg" @click="cargarPdf(1,buscar,criterio);">
                            <i class="fa fa-print fa-2x"></i>&nbsp;&nbsp;Reporte PDF
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterio">
                                    <option value="titulo">Cuestionario</option>
                                </select>
                                <input type="text" @keyup.enter="listarCuestionario(1,buscar,criterio);" class="form-control" placeholder="Buscar texto" v-model="buscar">
                                <button type="submit"  @click="listarCuestionario(1,buscar,criterio);" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr class="bg-primary"> 
                                <th>Ver detalle</th>                                  
                                <th>Titulo de cuestionario</th>
                                <th>Eliminar</th>                     
                            </tr>
                        </thead>
                        <tbody>                               
                            <tr v-for="cuestionario in cuestionarios" :key="cuestionario.id">
                                <td>
                                <button type="button" @click="verCuestionario(cuestionario.id)" class="btn btn-warning btn-sm">
                                    <i class="fa fa-eye fa-2x"></i> Ver Detalle
                                </button> &nbsp;
                                </td> 
                                <td v-text="cuestionario.titulo"></td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-md" @click="eliminarCuestionario(cuestionario.id)">
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
                                    <label class="text-uppercase"><strong>Titulo de cuestionario(*)</strong></label>
                                    <input type="text" class="form-control" v-model="titulo" placeholder="">
                                </div>
                            </div>                            

                        </div>
                        <div class="form-group row">

                            <div class="col-md-12">
                                <div v-show="errorCuestionario" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjCuestionario" :key="error" v-text="error">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="form-group row border">

                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Pregunta <span class="text-error" >(*Ingrese Pregunta)</span></label>
                                    <div>
                                        <input type="text" class="form-control" v-model="pregunta" placeholder="Ingrese pregunta">
                                    </div>                                    
                                </div>
                            </div>
                            <div class="col-md-3">                                
                                <div class="form-group">
                                    <label>Tipo de pregunta <span class="text-error">(*Ingrese tipo de pregunta)</span></label>
                                    <select class="form-control" v-model="tipo">
                                          
                                      <!-- el id y nombre asociado en el objeto categoria vienen de los campos
                                      de la tabla categorias de la bd-->
                                      <option disabled selected="selected">Seleccione</option>
                                      <option value="1">Abierta</option>
                                       <option value="2">Cerrada</option>
                                          
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button @click="agregarDetalle()" class="btn btn-primary form-control btnagregar"><i class="fa fa-plus fa-2x"></i> Agregar detalle</button>
                                </div>
                            </div>

                        </div>

                    </div>               

                <br/><br/>
                    <div class="card-body">
                        <div class="form-group row border">

                            <h3>Lista de preguntas del cuestionario</h3>

                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr class="bg-success">
                                            <th>Eliminar</th>
                                            <th>Pregunta</th>
                                            <th>Tipo de pregunta</th>                                            
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayDetalle.length">
                                        <tr v-for="(detalle,index) in arrayDetalle" :key="detalle.id">
                                            <td>
                                                <button @click="eliminarDetalle(index)" type="button" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-times fa-2x"></i>
                                                </button>
                                            </td>
                                            <td v-text="detalle.pregunta">
                                            </td>  
                                            <td v-if="detalle.tipo == 1">
                                                Abierta
                                            </td>
                                            <td v-if="detalle.tipo == 2">
                                                Cerrada
                                            </td>                                    
                                        </tr>                                        
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="6">
                                                No se han agregado preguntas al cuestionario
                                            </td>
                                        </tr>
                                    </tbody>                                    
                                </table>
                            </div>
                        </div>
                    </div>
                        <div class="modal-footer">
                            <button type="button" @click="salir()" class="btn btn-danger"><i class="fa fa-times fa-2x"></i> Cerrar</button>
                            <button type="button" @click="registrarCuestionario()" v-if="tipoAccion==1" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Guardar</button>
                        </div>
                </template>
                <template v-else-if="listado==2">

                    <h2 class="text-center">Detalle de Cuestionario</h2><br/>
             
                       <div class="card-body">
                            <div class="form-group row border">                                

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="text-uppercase"><strong>Titulo del cuestionario</strong></label>
                                        <p v-text="titulo"></p>
                                    </div>
                                </div>                              
                            </div>
                        <div class="form-group row border">
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr class="bg-success">
                                            <th>Pregunta</th>
                                            <th>Tipo de pregunta</th>                                        
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayDetalle.length">
                                        <tr v-for="detalle in arrayDetalle" :key="detalle.id">
                                            <td v-text="detalle.pregunta">
                                            </td>
                                            <td v-if="detalle.tipo == 1">
                                                Abierta
                                            </td>
                                            <td v-else>
                                                Cerrada
                                            </td>                                 
                                        </tr>                                    
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="5">
                                                No se han agregado preguntas al cuestionario
                                            </td>
                                        </tr>
                                    </tbody>                                    
                                </table>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" @click="ocultarDetalle()" class="btn btn-danger"><i class="fa fa-times fa-2x"></i> Cerrar</button>
                                
                            </div>
                        </div>
                    </div>
                </template> 
            </div>
            <!-- Fin ejemplo de tabla Listado -->
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

        @media (min-width: 600px) {
        .btnagregar {
            margin-top: 2rem;
        }
    }
</style>

<script>
    export default {
        data() {
            return {
                cuestionarios: [],
                titulo: "",                 
                cuestionario_id: 0,

                //Preguntas
                pregunta: '',
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
                criterio: 'titulo',
                buscar: '',

                //modal
                modal:0, //0=Modal abierto / 1=Modal cerrado
                tituloModal:'',

                //Errores
                errorCuestionario:0,
                errorMostrarMsjCuestionario:[],
                tipoAccion: 1,

                //Listado
                listado: 1,
                arrayDetalle: [],
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
            listarCuestionario(page, buscar, criterio) {
                let me = this; 
                var url = '/cuestionario?page='+ page + '&buscar=' + buscar + '&criterio=' + criterio;

                axios.get(url).then( function( response ) {                    
                    
                    var respuesta = response.data;
                    me.cuestionarios = respuesta.cuestionarios.data;

                });                               
            },

            cargarPdf(page, buscar, criterio)
            {
                window.open('http://127.0.0.1:8000/cuestionario/listarPdf?page='+ page + '&buscar=' + buscar + '&criterio=' + criterio, '_blank');
            },

            registrarCuestionario(){
                const alerta = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',                    
                  },
                 buttonsStyling: false,
                })

                if(this.validarCuestionario()) {
                    return;
                }

                let me=this;
                axios.post('/cuestionario/registrar', {
                        'titulo':me.titulo,                          
                        'data': me.arrayDetalle                    
                    }).then(function (response) {
                        alerta.fire("Cuestionario registrado exitosamente");
                        me.listado = 1;
                        me.titulo='';
                        me.arrayDetalle= [];
                        me.listarCuestionario(1, '', 'titulo');
                    }).catch(function (error) {
                    // handle error
                    console.log(error);
                    });
            },

            verCuestionario(id){
                let me = this;
                me.listado=2;

                var arrayCuestionarioT=[];
                var arrayDetalle=[];
                var url = '/cuestionario/obtenerCabecera?id=' + id;

                axios.get(url).then( function( response ) {
                    var respuesta = response.data;
                    arrayCuestionarioT = respuesta.cuestionario;

                    me.titulo = arrayCuestionarioT[0]['titulo'];                    
                })
                .catch( function ( error ) {
                    console.log('Error : '+error);
                });

                var urld = '/cuestionario/obtenerDetalles?id=' + id;
                    
                axios.get(urld).then( function( response ) {
                    var respuesta = response.data;
                    me.arrayDetalle = respuesta.detalles;                
                })
                .catch( function ( error ) {
                    console.log(error);
                });
            },

            eliminarCuestionario(id) {
                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                  },
                 buttonsStyling: false,
                })

                swalWithBootstrapButtons.fire({
                  title: '¿Estás seguro de eliminar el Cuestionario?',
                  //type: 'warning',
                  showCancelButton: true,
                  confirmButtonText: '<i class="fa fa-check fa-2x"></i> Aceptar ',
                  cancelButtonText: '<i class="fa fa-times fa-2x"></i> Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {
                        
                    let me=this;
                        axios.delete('/cuestionario/eliminar/'+id).then(function (response) {  
                                //console.log( response );
                                me.listarCuestionario(1, '', 'titulo');
                                swalWithBootstrapButtons.fire(
                                    'Eliminado!',
                                    'Cuestionario eliminado.',
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

            validarCuestionario() {
                this.errorCuestionario=0;
                this.errorMostrarMsjCuestionario=[];

                if(!this.titulo){
                    this.errorMostrarMsjCuestionario.push("(*) El titulo no puede estar vacio");
                }

                if(this.errorMostrarMsjCuestionario.length) this.errorCuestionario=1;
                return this.errorCuestionario;
            },      

            mostrarDetalle() {                
                let me = this;
                this.listado = 0;
                me.cuestionario_id=0;
                me.titulo='';                            
                me.arrayDetalle=[];
            },

            ocultarDetalle() {
                this.listado = 1;   
            },          

            agregarDetalle() {
                if(this.validarDetalle()) {
                    return;
                }

                let me = this;

                me.arrayDetalle.push({ 
                cuestionario_id: me.cuestionario_id,
                pregunta: me.pregunta,
                tipo: me.tipo,                
                });
                me.pregunta = '';
                me.tipo = '';                                             
            },

            eliminarDetalle(index) {                
                let me = this;
                me.arrayDetalle.splice(index, 1);
            },

            validarDetalle() {
                this.errorCuestionario=0;
                this.errorMostrarMsjCuestionario=[];

                if(!this.pregunta){
                    this.errorMostrarMsjCuestionario.push("(*) La pregunta no puede estar vacia");
                }

                if(!this.tipo){
                    this.errorMostrarMsjCuestionario.push("(*) Debe seleccionar tipo de pregunta");
                }

                if(this.errorMostrarMsjCuestionario.length) this.errorCuestionario=1;
                return this.errorCuestionario;

            },

            salir() {
                this.listado = 1;
            },

            //Paginacion
            cambiarPagina(page, buscar, criterio){
                let me = this;
                //Actualiza la pagina actual
                me.pagination.current_page = page;
                me.listarCuestionario(page, buscar, criterio);
            },

        },

        mounted() {
            this.listarCuestionario(1, this.buscar, this.criterio);        
        }
    }
</script>