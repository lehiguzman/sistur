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

                       <h2>Encuesta</h2><br/>                      
                        
                    </div>
                    <div class="card-body">                       
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr class="bg-primary">                                   
                                    <th>Titulo</th>                                    
                                    <th>Opción</th>                                    
                                </tr>
                            </thead>
                            <tbody>                               
                                <tr v-for="cuestionario in cuestionarios" :key="cuestionario.id">
                                    <td v-text="cuestionario.titulo"></td>                                     
                                    <td>
                                        <button type="button" class="btn btn-info btn-md" @click="responder(cuestionario.id)">
                                          <i class="fa fa-edit fa-2x"></i> Responder
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
                    

                    <h3 class="text-center">Encuesta al cliente</h3>

                     <div class="card-body">                        
                        
                        <div class="form-group row border">

                            <div class="col-md-8">
                                <div class="form-group">
                                     <label class="text-uppercase"><strong>Titulo del cuestionario</strong></label>
                                        <p v-text="titulo"></p>
                                </div>
                            </div>                            

                        </div>

                        <div class="form-group row border">

                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr class="bg-primary">                                   
                                        <th>Pregunta</th>                                    
                                        <th>Respuesta</th>                                    
                                    </tr>
                                </thead>
                                <tbody>                               
                                    <tr v-for="detalle in arrayDetalle" :key="detalle.id">
                                        <td v-text="detalle.pregunta"></td>                                     
                                        <td v-if="detalle.tipo == 1">
                                            <textarea class="form-control" v-model="detalle.respuesta" placeholder="Ingrese respuesta"></textarea>
                                        </td>
                                        <td v-else>
                                            <select class="form-control" v-model="detalle.respuesta">
                                                <option disabled selected="selected">Seleccione</option>
                                                <option value="Si">Si</option>
                                                <option value="No">No</option>
                                            </select>
                                        </td>                                                                   
                                    </tr>                               
                                </tbody>
                                 <div class="modal-footer">
                                    <button type="button" @click="salir()" class="btn btn-danger"><i class="fa fa-times fa-2x"></i> Cerrar</button>
                                    <button type="button" @click="registrarEncuesta()" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Guardar</button>
                                </div> 
                            </table>

                        </div>

                        <!-- <div class="form-group row">

                            <div class="col-md-12">
                                <div v-show="errorCurso" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjCurso" :key="error" v-text="error">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div> -->

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
</style>

<script>
    export default {
        data() {
            return {
                cuestionarios: [],
                titulo: "",

                respuesta: [],
                

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

                //Errores
                errorCargo:0,
                errorMostrarMsjCargo:[],
                tipoAccion: '',

                listado: 1,
                arrayDetalle: []
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
            listarEncuesta() {
                let me = this; 
                var url = '/cuestionario/listarEncuesta';

                axios.get(url).then( function( response ) {                    
                        
                    var respuesta = response.data;
                    me.cuestionarios = respuesta.cuestionarios;
                        console.log("Encuestas : ", me.cuestionarios);

                });                               
            },

            responder(id) {                
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

            registrarEncuesta(){
                let me = this;
                console.log( "Detalle : ", me.arrayDetalle[1].id );
                
                const alerta = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',                    
                  },
                 buttonsStyling: false,
                })

               /* if(this.validarCargo()) {
                    return;
                } */
                
                if(me.arrayDetalle.length > 0) {
                    axios.post('/cuestionario/registrarEncuesta', {                        
                        'data': me.arrayDetalle 
                    }).then(function (response) { 
                        me.listado = 1;                       
                        me.tipoNomina= '';
                        me.fecini= '';
                        me.fecfin= '';                        
                        me.arrayDetalle= [];
                        alerta.fire("Encuesta registrada exitosamente");
                        me.listarEncuesta(1, '', 'nombre');
                    }).catch(function (error) {
                    // handle error
                    alerta.fire("Debe responder al menos 1 pregunta");
                    console.log("Error de Datos : ", error);
                    });
                } else {
                    alerta.fire(
                        'Error!',
                        'No existen preguntas',
                        'error'
                    );                            
                }              
            },     

            salir() {
                this.listado = 1;
                this.listarEncuesta();              
            },
           
        },

        mounted() {
            this.listarEncuesta();        
        }
    }
</script>