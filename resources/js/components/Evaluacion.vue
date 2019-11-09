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

                       <h2>Evaluación de encuestas</h2><br/>
                        
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                        <option value="titulo">Titulo</option>
                                    </select>
                                    <input type="text" @keyup.enter="listarEncuesta(1,buscar,criterio);" class="form-control" placeholder="Buscar texto" v-model="buscar">
                                    <button type="submit"  @click="listarEncuesta(1,buscar,criterio);" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr class="bg-primary">                                   
                                    <th>Titulo de encuesta</th>                                    
                                    <th>Evaluar</th>                                    
                                </tr>
                            </thead>
                            <tbody>                               
                                <tr v-for="encuesta in encuestas" :key="encuesta.id">
                                    
                                    <td v-text="encuesta.titulo"></td>                                     
                                    <td>
                                        <button type="button" class="btn btn-info btn-md" @click="verPreguntas( encuesta.id )">
                                          <i class="fa fa-edit fa-2x"></i> Evaluar
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
                
                <template v-if="listado==2">
                    <!-- Listado de preguntas que pertenecen a la encuesta -->
                    <div class="card-header">

                       <h2> Preguntas de Encuesta <p v-text="titulo"></p> </h2><br/>
                        
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr class="bg-secondary">                                   
                                <th>Pregunta</th>                                    
                                <th>Evaluar respuestas</th>                                    
                            </tr>
                        </thead>
                        <tbody>                               
                            <tr v-for="detalle in arrayDetalle" :key="detalle.id">
                                
                                <td v-text="detalle.pregunta"></td>                                     
                                <td>
                                    <button type="button" class="btn btn-info btn-md" @click="listarRespuestas( detalle.id, detalle.pregunta )">
                                      <i class="fa fa-edit fa-2x"></i> Evaluar respuestas
                                    </button> &nbsp;
                                </td>
                                   
                            </tr>                               
                        </tbody>
                    </table>
                </template>
                <template v-if="listado==3">
                    <!-- Listado de preguntas que pertenecen a la encuesta -->
                    <div class="card-header">

                       <h2> Respuestas de pregunta <p v-text="pregunta"></p> </h2><br/>
                        
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr class="bg-secondary">                                   
                                <th>Respuesta</th>                                    
                                <th>Asignar tendencia</th>                                    
                            </tr>
                        </thead>
                        <tbody v-if="arrayRespuestas.length">                               
                            <tr v-for="respuesta in arrayRespuestas" :key="respuesta.id">
                                
                                <td v-text="respuesta.respuesta"></td>                                     
                                <td>
                                    <select class="form-control" v-model="respuesta.tendencia">
                                        <option disabled selected="selected">Seleccione</option>
                                        <option value="1">Positiva</option>
                                        <option value="0">Negativa</option>
                                    </select>
                                </td>
                                   
                            </tr>                               
                        </tbody>
                        <tbody v-else>
                            <tr>
                                <td colspan="6">
                                    No hay respuestas registradas
                                </td>
                            </tr>
                        </tbody>
                         <div class="modal-footer">
                            <button type="button" @click="salir()" class="btn btn-danger"><i class="fa fa-times fa-2x"></i> Cerrar</button>
                            <button type="button" @click="registrarEvaluacion()" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Guardar</button>
                        </div> 
                    </table>
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
</style>

<script>
    export default {
        data() {
            return {
                encuestas: [],
                titulo: "",        

                arrayDetalle: [],       
                arrayRespuestas: [],
                
                pregunta: "",
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
                errorRama:0,
                errorMostrarMsjRama:[],
                tipoAccion: '',

                listado: 1,
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
            listarEncuesta(page, buscar, criterio) {
                let me = this; 
                var url = '/cuestionario?page='+ page + '&buscar=' + buscar + '&criterio=' + criterio;

                axios.get(url).then( function( response ) {
                        console.log( response.data );
                    var respuesta = response.data;
                    me.encuestas = respuesta.cuestionarios.data;

                });                               
            },

            verPreguntas( id ) {

                let me = this;
                this.listado = 2;

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
                    console.log(response.data);
                    var respuesta = response.data;
                    me.arrayDetalle = respuesta.detalles;                
                })
                .catch( function ( error ) {
                    console.log(error);
                });                

            },

            listarRespuestas( id, pregunta ) {

                let me = this;
                
                this.pregunta = pregunta;
                this.listado = 3;

                var urld = '/cuestionario/obtenerRespuestas?id=' + id;
                    
                axios.get(urld).then( function( response ) {
                    
                    var respuesta = response.data;
                    me.arrayRespuestas = respuesta.respuestas;                

                })
                .catch( function ( error ) {
                    console.log(error);
                });      

                console.log( id );
            },            

            salir() {
            
                this.listarEncuesta(1, this.buscar, this.criterio);
                
                this.listado = 1;
            },            
            
            registrarEvaluacion() { 
                const alerta = Swal.mixin({
                      customClass: {
                        confirmButton: 'btn btn-success',                    
                      },
                     buttonsStyling: false,
                    })

            let me = this;

                if(me.arrayDetalle.length > 0) {
                    axios.post('/cuestionario/registrarEvaluacion', {
                       'data': me.arrayRespuestas 
                    }).then(function (response) { 
                        me.listado = 1;                       
                        me.arrayRespuestas= [];
                        alerta.fire("Evaluaciòn registrada exitosamente");
                        me.listarEncuesta(1, '', 'nombre');
                    }).catch(function (error) {
                    // handle error
                    alerta.fire("Debe evaluar al menos una pregunta");
                    console.log("Error de Datos : ", error);
                    });
                } else {
                    alerta.fire(
                        'Error!',
                        'No existen preguntas por evaluar',
                        'error'
                    );                            
                }           
            },
        },

        mounted() {
            this.listarEncuesta(1, this.buscar, this.criterio);        
        }
    }
</script>