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
                                    <select class="form-control" v-model="detalle.tendencia">
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

            registrarRama(){
                const alerta = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',                    
                  },
                 buttonsStyling: false,
                })

                if(this.validarRama()) {
                    return;
                }
                let me=this;
                axios.post('/rama/registrar', {
                        'titulo':me.titulo,
                        'descripcion':me.descripcion,
                    }).then(function (response) {
                        alerta.fire("Rama registrada exitosamente");
                        me.cerrarModal();
                        me.listarEncuesta(1, '', 'titulo');
                    }).catch(function (error) {
                    // handle error
                    console.log(error);
                    });
            },

            actualizarRama(){
                const alerta = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',                    
                  },
                 buttonsStyling: false,
                })

                if(this.validarRama()) {
                    return;
                }

                let me=this;
                axios.put('/rama/actualizar', {
                        'id':me.rama_id,
                        'titulo':me.titulo,
                        'descripcion':me.descripcion,
                    }).then(function (response) {
                        alerta.fire("Rama registrada exitosamente");
                        me.cerrarModal();
                        me.listarEncuesta(1, '', 'titulo');
                    }).catch(function (error) {
                    // handle error
                    console.log(error);
                    });
            },

            eliminarRama(id) {
                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                  },
                 buttonsStyling: false,
                })

                swalWithBootstrapButtons.fire({
                  title: '¿Estás seguro de eliminar la rama?',
                  //type: 'warning',
                  showCancelButton: true,
                  confirmButtonText: '<i class="fa fa-check fa-2x"></i> Aceptar',
                  cancelButtonText: '<i class="fa fa-times fa-2x"></i> Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {
                        
                    let me=this;
                        axios.delete('/rama/eliminar/'+id).then(function (response) {  
                                //console.log( response );
                                me.listarEncuesta(1, '', 'titulo');
                                swalWithBootstrapButtons.fire(
                                    'Eliminado!',
                                    'Rama eliminada.',
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

            validarRama() {
                this.errorRama=0;
                this.errorMostrarMsjRama=[];

                if(!this.titulo){
                    this.errorMostrarMsjRama.push("(*) El titulo no puede estar vacio");
                }

                if(this.errorMostrarMsjRama.length) this.errorRama=1;
                return this.errorRama;
            },      

            //Modal
            abrirModal(modelo, accion, data=[]) {                   
                switch(modelo) {
                    case "rama": {
                        switch(accion){
                            case "registrar":{
                                this.modal = 1;
                                this.tituloModal="Registrar rama";
                                this.tipoAccion = 1;
                                this.titulo = "";                                
                                break;
                            }
                            case "actualizar": {
                                this.modal = 1;
                                this.tituloModal = "Editar rama";
                                this.tipoAccion=2;
                                this.rama_id = data["id"];
                                this.titulo = data["titulo"];
                                this.descripcion = data["descripcion"];                                 
                                break;
                            }                         
                        }
                    }
                }                
            },            

            cerrarModal() { 
                this.modal = 0;
                this.titulo = "";   
                this.descripcion = "";                
                this.tituloModal = "";
            },

            //Paginacion
            cambiarPagina(page, buscar, criterio){
                let me = this;
                //Actualiza la pagina actual
                me.pagination.current_page = page;
                me.listarEncuesta(page, buscar, criterio);
            },

        },

        mounted() {
            this.listarEncuesta(1, this.buscar, this.criterio);        
        }
    }
</script>