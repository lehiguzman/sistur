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

                           <h2>Cursos</h2><br/>
                          
                            <button class="btn btn-primary btn-lg" type="button" @click="mostrarDetalle()">
                                <i class="fa fa-plus fa-2x"></i>&nbsp;&nbsp;Nuevo curso
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
                                        <option value="nombre">Curso</option>
                                    </select>
                                    <input type="text" @keyup.enter="listarCurso(1,buscar,criterio);" class="form-control" placeholder="Buscar texto" v-model="buscar">
                                    <button type="submit"  @click="listarCurso(1,buscar,criterio);" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr class="bg-primary">                                                         
                                    <th>Ver detalle</th>
                                    <th>Curso</th>
                                    <th>Fecha de inicio</th>
                                    <th>cupos</th>
                                    <th>Descripción</th>                                     
                                    <th>Eliminar</th>                                    
                                </tr>
                            </thead>
                            <tbody>                               
                                <tr v-for="curso in cursos" :key="curso.id">
                                    <td>
                                    <button type="button" @click="verCurso(curso.id)" class="btn btn-warning btn-sm">
                                        <i class="fa fa-eye fa-2x"></i> Ver Detalle
                                    </button> &nbsp;
                                    </td>      
                                    <td v-text="curso.nombre"></td>
                                    <td v-text="curso.fecini"></td> 
                                    <td v-text="curso.cupos"></td>
                                    <td v-text="curso.descripcion"></td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-md" @click="eliminarCurso(curso.id)">
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
                
                <!-- Fin ejemplo de tabla Listado -->
            
                <template v-else-if="listado==0">
                    <span><strong>(*) Campo obligatorio</strong></span><br/>                     

                    <h3 class="text-center">LLenar el formulario</h3>

                     <div class="card-body">

                        <div class="form-group row border">

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="text-uppercase"><strong>Nombre del Curso(*)</strong></label>
                                    <input type="text" class="form-control" v-model="nombre" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="text-uppercase"><strong>Fecha de inicio(*)</strong></label>
                                    <datepicker bootstrap-styling v-model="fecini" :format="formatoFecha" placeholder="Fecha de inicio"></datepicker>
                                </div>
                            </div>                           

                            <div class="col-md-8">
                                <label class="text-uppercase"><strong>Duración del Curso(*)</strong></label>
                                <input type="text" class="form-control" v-model="duracion">
                            </div>
                            
                            <div class="col-md-8">
                                <label class="text-uppercase"><strong>Cupos del Curso(*)</strong></label>
                                <input type="text" class="form-control" v-model="cupos">
                            </div>

                            <div class="col-md-8">
                                <label class="text-uppercase"><strong>Descripción del Curso(*)</strong></label>
                                <input type="text" class="form-control" v-model="descripcion">
                            </div>
                                 
                        </div>
                        <div class="form-group row">

                            <div class="col-md-12">
                                <div v-show="errorCurso" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjCurso" :key="error" v-text="error">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="form-group row border">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Contenido <span class="text-error" >(*Ingrese Contenido)</span></label>
                                    <div class="form-inline">
                                        <input type="text" class="form-control" v-model="contenido" placeholder="Ingrese contenido">                                        
                                    </div>                                    
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Descripción del contenido <span class="text-error">(*Ingrese descripción)</span></label>
                                    <input type="text" step="any" class="form-control" v-model="descripcionCont" placeholder="Ingrese descripción del contenido">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button @click="agregarDetalle()" class="btn btn-primary form-control btnagregar"><i class="fa fa-plus fa-2x"></i> Agregar </button>
                                </div>
                            </div>

                        </div>

                    </div>
                

                <br/><br/>
                    <div class="card-body">
                        <div class="form-group row border">

                            <h3>Lista de Contenidos del Curso</h3>

                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr class="bg-success">
                                            <th>Eliminar</th>
                                            <th>Contenido</th>
                                            <th>Descripción</th>                                            
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayDetalle.length">
                                        <tr v-for="(detalle,index) in arrayDetalle" :key="detalle.id">
                                            <td>
                                                <button @click="eliminarDetalle(index)" type="button" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-times fa-2x"></i>
                                                </button>
                                            </td>
                                            <td v-text="detalle.contenido">
                                            </td>  
                                            <td v-text="detalle.descripcion">
                                            </td>                                        
                                        </tr>                                        
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="6">
                                                No se han agregado contenidos al curso
                                            </td>
                                        </tr>
                                    </tbody>                                    
                                </table>
                            </div>
                        </div>
                    </div>
                        <div class="modal-footer">
                            <button type="button" @click="salir()" class="btn btn-danger"><i class="fa fa-times fa-2x"></i> Cerrar</button>
                            <button type="button" @click="registrarCurso()" v-if="tipoAccion==1" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Guardar</button>
                        </div>
                    </template>
                    <template v-else-if="listado==2">

                    <h2 class="text-center">Detalle de Curso</h2><br/>
             
                       <div class="card-body">
                            <div class="form-group row border">                                

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="text-uppercase"><strong>Nombre</strong></label>
                                        <p v-text="nombre"></p>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="text-uppercase"><strong>Fecha de inicio</strong></label>
                                        <p v-text="fecini"></p>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="text-uppercase"><strong>Duración</strong></label>
                                        <p v-text="duracion"></p>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                     <div class="form-group">
                                        <label class="text-uppercase"><strong>Cupos</strong></label>
                                        <p v-text="cupos"></p>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="text-uppercase"><strong>Descripción</strong></label>
                                        <p v-text="descripcion"></p>
                                    </div>
                                </div>

                        </div>
                    <div class="form-group row border">
                        <div class="table-responsive col-md-12">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr class="bg-success">
                                        <th>Contenido</th>
                                        <th>Descripcion</th>                                        
                                    </tr>
                                </thead>
                                <tbody v-if="arrayDetalle.length">
                                    <tr v-for="detalle in arrayDetalle" :key="detalle.id">
                                        <td v-text="detalle.contenido">
                                        </td>
                                        <td v-text="detalle.descripcion">
                                        </td>                                        
                                    </tr>                                    
                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <td colspan="5">
                                            No se han agregado contenidos
                                        </td>
                                    </tr>
                                </tbody>                                    
                            </table>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <button type="button" @click="ocultarDetalle()" class="btn btn-danger"><i class="fa fa-times fa-2x"></i> Cerrar</button>                            
                        </div>                        
                    </div>
                 </div>
                </template> 
            </div>
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
    import Datepicker from 'vuejs-datepicker';
    import moment from 'moment';

    export default {
        data() {
            return {
                cursos: [],
                nombre: "", 
                fecini: "",
                duracion: "",
                cupos: "",                 
                descripcion: "", 
                curso_id: 0,

                //Contenidos
                contenido: "",
                descripcionCont: "",            

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
                errorCurso:0,
                errorMostrarMsjCurso:[],
                tipoAccion: 1,

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
            listarCurso(page, buscar, criterio) {
                let me = this; 
                var url = '/curso?page='+ page + '&buscar=' + buscar + '&criterio=' + criterio;                

                axios.get(url).then( function( response ) {                    
                    
                    var respuesta = response.data;
                    me.cursos = respuesta.cursos.data;

                });                               
            },

            cargarPdf(page, buscar, criterio)
            {
                window.open('http://127.0.0.1:8000/curso/listarPdf?page='+ page + '&buscar=' + buscar + '&criterio=' + criterio, '_blank');
            },

            registrarCurso(){
                const alerta = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',                    
                  },
                 buttonsStyling: false,
                })

                if(this.validarCurso()) {
                    return;
                }

                let me=this;
                let fecini = moment( me.fecini ).format("YYYY-MM-DD");

                axios.post('/curso/registrar', {
                        'nombre':me.nombre,
                        'fecini':fecini,
                        'duracion':me.duracion,
                        'cupos':me.cupos,
                        'descripcion':me.descripcion,
                        'data': me.arrayDetalle 
                    }).then(function (response) { 
                        me.listado = 1;                       
                        me.nombre= '';
                        me.fecini= '';
                        me.duracion= 0;
                        me.cupos= 0;
                        me.descripcion= '';
                        me.arrayDetalle= [];
                        alerta.fire("Curso registrado exitosamente");
                        me.listarCurso(1, '', 'nombre');
                    }).catch(function (error) {
                    // handle error
                    console.log(error);
                    });
            },            

            verCurso(id){
                let me = this;
                me.listado=2;

                var arrayCursoT=[];
                var arrayDetalle=[];
                var url = '/curso/obtenerCabecera?id=' + id;

                axios.get(url).then( function( response ) {
                    var respuesta = response.data;
                    arrayCursoT = respuesta.curso;

                    me.nombre = arrayCursoT[0]['nombre'];
                    me.fecini = arrayCursoT[0]['fecini'];
                    me.duracion = arrayCursoT[0]['duracion'];
                    me.descripcion = arrayCursoT[0]['descripcion'];
                    me.cupos = arrayCursoT[0]['cupos'];
                })
                .catch( function ( error ) {
                    console.log('Error : '+error);
                });

                var urld = '/curso/obtenerDetalles?id=' + id;
                    
                axios.get(urld).then( function( response ) {
                    var respuesta = response.data;
                    me.arrayDetalle = respuesta.detalles;                
                })
                .catch( function ( error ) {
                    console.log(error);
                });
            },

            eliminarCurso(id) {
                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                  },
                 buttonsStyling: false,
                })

                swalWithBootstrapButtons.fire({
                  title: '¿Estás seguro de eliminar el Curso?',
                  //type: 'warning',
                  showCancelButton: true,
                  confirmButtonText: '<i class="fa fa-check fa-2x"></i> Aceptar',
                  cancelButtonText: '<i class="fa fa-times fa-2x"></i> Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {
                        
                    let me=this;
                        axios.delete('/curso/eliminar/'+id).then(function (response) {  
                                //console.log( response );
                                me.listarCurso(1, '', 'nombre');
                                swalWithBootstrapButtons.fire(
                                    'Eliminado!',
                                    'Curso eliminado.',
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

            validarCurso() {
                this.errorCurso=0;
                this.errorMostrarMsjCurso=[];

                if(!this.nombre){
                    this.errorMostrarMsjCurso.push("(*) El nombre no puede estar vacio");
                }

                if(!this.fecini){
                    this.errorMostrarMsjCurso.push("(*) La fecha de inicio no puede estar vacio");
                }

                if(!this.duracion){
                    this.errorMostrarMsjCurso.push("(*) La duración no puede estar vacia");
                }

                if(!this.cupos){
                    this.errorMostrarMsjCurso.push("(*) El cupo no puede estar vacio");
                }

                if(this.errorMostrarMsjCurso.length) this.errorCurso=1;
                return this.errorCurso;
            },          

            mostrarDetalle() {                
                let me = this;
                this.listado = 0;
                me.curso_id=0;
                me.nombre='';
                me.fecini='';
                me.duracion=0.0;
                me.descripcion='';               
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
                console.log("adasdas");
                me.arrayDetalle.push({ 
                curso_id: me.curso_id,
                contenido: me.contenido,
                descripcion: me.descripcionCont,                
                });
                me.contenido= '';
                me.descripcionCont = '';                                             
            },

            validarDetalle() {
                this.errorCurso=0;
                this.errorMostrarMsjCurso=[];

                if(!this.contenido){
                    this.errorMostrarMsjCurso.push("(*) El contenido no puede estar vacio");
                }

                if(!this.descripcionCont){
                    this.errorMostrarMsjCurso.push("(*) La descripcion del contenido no puede estar vacia");
                }

                if(this.errorMostrarMsjCurso.length) this.errorCurso=1;
                return this.errorCurso;

            },

            eliminarDetalle(index) {                
                let me = this;
                me.arrayDetalle.splice(index, 1);
            }, 

            salir() {
                this.listado = 1;
            },

            //Paginacion
            cambiarPagina(page, buscar, criterio){
                let me = this;
                //Actualiza la pagina actual
                me.pagination.current_page = page;
                me.listarCurso(page, buscar, criterio);
            },
        },

        mounted() {
            this.listarCurso(1, this.buscar, this.criterio);        
        }
    }
</script>