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

                           <h2>Nominas</h2><br/>
                          
                            <button class="btn btn-primary btn-lg" type="button" @click="mostrarDetalle()">
                                <i class="fa fa-plus fa-2x"></i>&nbsp;&nbsp;Nueva nomina
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
                                        <option value="nombre">Tipo de Nomina</option>
                                        <option value="fecini">Fecha desde</option>
                                        <option value="fecfin">Fecha hasta</option>
                                    </select>
                                    <input type="text" @keyup.enter="listarNomina(1,buscar,criterio);" class="form-control" placeholder="Buscar texto" v-model="buscar">
                                    <button type="submit"  @click="listarNomina(1,buscar,criterio);" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr class="bg-primary">                                                         
                                    <th>Ver detalle</th>
                                    <th>Tipo nomina</th>
                                    <th>Periodo Desde</th>
                                    <th>Periodo Hasta</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>                               
                                <tr v-for="nomina in nominas" :key="nomina.id">
                                    <td>
                                    <button type="button" @click="verNomina(nomina.id)" class="btn btn-warning btn-sm">
                                        <i class="fa fa-eye fa-2x"></i> Ver Detalle
                                    </button> &nbsp;
                                    </td>      
                                    <td v-text="nomina.nombre"></td>
                                    <td v-text="nomina.fecini"></td> 
                                    <td v-text="nomina.fecfin"></td>                                    
                                    <td>
                                        <button type="button" class="btn btn-danger btn-md" @click="eliminarNomina(nomina.id)">
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
                                    <label class="text-uppercase"><strong>Tipo de Nomina(*)</strong></label>
                                    <select class="form-control" v-model="tiponomina_id" @change="listarNominaEmpleado()">
                                          
                                          <!-- el id y nombre asociado en el objeto categoria vienen de los campos
                                          de la tabla categorias de la bd-->
                                          <option value="0" disabled>Seleccione</option>
                                          <!--el arrayCategoria es una variable de la data javascript de vue 
                                          y se cargan los registros de la categoria una vez se abra la ventana
                                          modal-->
                                          <option v-for="tipoNomina in arrayTipoNomina" :key="tipoNomina.id" :value="tipoNomina.id" v-text="tipoNomina.nombre"></option>

                                    </select>                                   
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="text-uppercase"><strong>Periodo desde : (*)</strong></label>
                                    <datepicker bootstrap-styling v-model="fecini" :format="formatoFecha" placeholder="Fecha de inicio"></datepicker>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="text-uppercase"><strong>Periodo hasta : (*)</strong></label>
                                    <datepicker bootstrap-styling v-model="fecfin" :format="formatoFecha" placeholder="Fecha de inicio"></datepicker>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="col-md-12">
                        <div v-show="errorTipoNomina" class="form-group row div-error">
                            <div class="text-center text-error">
                                <div v-for="error in errorMostrarMsjTipoNomina" :key="error" v-text="error">
                                </div>
                            </div>
                        </div>
                    </div>             

                <br/><br/>
                    <div class="form-group row border">
                        <div class="table-responsive col-md-12">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr class="bg-success">
                                        <th>Empleado</th>
                                        <th>Monto Salario</th>
                                        <th>Monto Deducciones</th>
                                        <th>Neto a cobrar</th>
                                    </tr>
                                </thead>
                                <tbody v-if="arrayDetalle.length">
                                    <tr v-for="(detalle, index) in arrayDetalle" :key="detalle.id">
                                        <td v-text="detalle.nombre">
                                        </td>
                                        <td>
                                            <input type="number" @blur="verificaNeto(index)" class="form-control" v-model="detalle.salario">
                                        </td>    
                                        <td>
                                            <input type="number" class="form-control"  value="0" v-model="detalle.monded" placeholder="0" @blur="verificaNeto(index)">
                                        </td>  
                                        <td v-if="detalle.monded>0">
                                            {{ neto = detalle.salario-detalle.monded}}
                                        </td>
                                        <td v-else>
                                            {{detalle.salario}}
                                        </td>                                        
                                    </tr>                                    
                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <td colspan="5">
                                            No se han agregado empleados
                                        </td>
                                    </tr>
                                </tbody>                                    
                                </table>
                            </div>
                        </div>
                    
                    <div class="modal-footer">
                        <button type="button" @click="salir()" class="btn btn-danger"><i class="fa fa-times fa-2x"></i> Cerrar</button>
                        <button type="button" @click="registrarNomina()" v-if="tipoAccion==1" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Guardar</button>
                    </div>
                </template>
                <template v-else-if="listado==2">

                    <h2 class="text-center">Detalle de Nomina</h2><br/>
             
                   <div class="card-body">
                        <div class="form-group row border">                                

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="text-uppercase"><strong>Tipo de Nomina</strong></label>
                                    <p v-text="nombreNomina"></p>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="text-uppercase"><strong>Fecha desde : </strong></label>
                                    <p v-text="fecini"></p>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="text-uppercase"><strong>Fecha hasta : </strong></label>
                                    <p v-text="fecini"></p>
                                </div>
                            </div>
                        </div>                                                
                    </div>
                    <div class="form-group row border">
                        <div class="table-responsive col-md-12">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr class="bg-success">
                                        <th>Empleado</th>
                                        <th>Monto Salario</th>
                                        <th>Monto Deducciones</th>
                                        <th>Monto neto a cobrar</th>
                                    </tr>
                                </thead>
                                <tbody v-if="arrayDetalle.length">
                                    <tr v-for="detalle in arrayDetalle" :key="detalle.id">
                                        <td v-text="detalle.nombre">
                                        </td>
                                        <td v-text="detalle.monsal">
                                        </td>
                                        <td v-text="detalle.monded">
                                        </td>
                                        <td>
                                            {{detalle.monsal-detalle.monded}}
                                        </td>                     
                                    </tr>                                    
                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <td colspan="5">
                                            No se han agregado empleados
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
                tiponomina_id: 0,
                arrayTipoNomina: [],
                fecini: "",
                fecfin: "", 
                nombreNomina:"", 

                monsal: 0,
                monded: 0,
                neto: 0,               

                nominas: [],                     

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

            verificaNeto(index) {

            console.log(index);
                if(this.neto < 0) {
                    this.arrayDetalle[index].monded = 0;    
                }
                if(!this.arrayDetalle[index].monded) {
                   this.arrayDetalle[index].monded = 0;                    
                }                
            },

            //Tipo de nomina
            selectTipoNomina() {
                let me = this;

                var url = '/tipoNomina/selectTipoNomina';

                axios.get(url).then(function (response) {
                    // handle success                    
                    var respuesta = response.data;
                    me.arrayTipoNomina = respuesta.tipoNominas;  
                    console.log(me.arrayTipoNomina);
                  })
                  .catch(function (error) {
                    // handle error
                    console.log(error);
                  })
                  .finally(function () {
                    // always executed
                  });
            },  

            //Modulo
            listarNomina(page, buscar, criterio) {
                let me = this; 

                var url = '/nomina?page='+ page + '&buscar=' + buscar + '&criterio=' + criterio;                

                axios.get(url).then( function( response ) {                    
                    
                    var respuesta = response.data;
                    me.nominas = respuesta.nominas.data;
                    console.log("Nominas : ", me.nominas);

                });                               
            },

            cargarPdf(page, buscar, criterio)
            {
                window.open('http://127.0.0.1:8000/nomina/listarPdf?page='+ page + '&buscar=' + buscar + '&criterio=' + criterio, '_blank');
            },

            registrarNomina(){
                const alerta = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',                    
                  },
                 buttonsStyling: false,
                })

                if(this.validarNomina()) {
                    return;
                }

                let me=this;
                let fecini = moment( me.fecini ).format("YYYY-MM-DD");
                let fecfin = moment( me.fecfin ).format("YYYY-MM-DD");

                console.log( "Detalle : ", me.arrayDetalle.length );

                

                if(me.arrayDetalle.length > 0) {
                    axios.post('/nomina/registrar', {
                        'tiponomina_id':me.tiponomina_id,
                        'fecini':fecini,
                        'fecfin':fecfin,
                        'data': me.arrayDetalle 
                    }).then(function (response) { 
                        me.listado = 1;                       
                        me.tipoNomina= '';
                        me.fecini= '';
                        me.fecfin= '';                        
                        me.arrayDetalle= [];
                        alerta.fire("Nomina registrada exitosamente");
                        me.listarNomina(1, '', 'nombre');
                    }).catch(function (error) {
                    // handle error
                    alerta.fire("Debe asignar salario al menos a un empleado");
                    console.log("Error de Datos : ", error);
                    });
                } else {
                    alerta.fire(
                        'Error!',
                        'No existen empleados con este tipo de nomina',
                        'error'
                    );                            
                }                    
            },

            eliminarNomina(id) {
                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                  },
                 buttonsStyling: false,
                })

                swalWithBootstrapButtons.fire({
                  title: '¿Estás seguro de eliminar la Nomina?',
                  //type: 'warning',
                  showCancelButton: true,
                  confirmButtonText: '<i class="fa fa-check fa-2x"></i> Aceptar',
                  cancelButtonText: '<i class="fa fa-times fa-2x"></i> Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {
                        
                    let me=this;
                        axios.delete('/nomina/eliminar/'+id).then(function (response) {  
                                //console.log( response );
                                me.listarNomina(1, '', 'nombre');
                                swalWithBootstrapButtons.fire(
                                    'Eliminado!',
                                    'Nomina eliminada.',
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

            verNomina(id){
                let me = this;
                me.listado=2;

                var arrayNominaT=[];                
                var arrayDetalle=[];
                var url = '/nomina/obtenerCabecera?id=' + id;

                axios.get(url).then( function( response ) {
                    var respuesta = response.data;
                    arrayNominaT = respuesta.nomina;
                    
                    var res = respuesta.nombre;

                    me.nombreNomina = res.nombre;
                    me.fecini = arrayNominaT.fecini;
                    me.fecfin = arrayNominaT.fecfin;
                })
                .catch( function ( error ) {
                    console.log('Error : '+error);
                });

                var urld = '/nomina/obtenerDetalles?id=' + id;
                    
                axios.get(urld).then( function( response ) {
                    var respuesta = response.data;
                    me.arrayDetalle = respuesta.detalles;                
                })
                .catch( function ( error ) {
                    console.log(error);
                });
            },

            listarNominaEmpleado() {
                let me = this;

                var url = '/nomina/selectNominaEmpleado/'+me.tiponomina_id;
                    
                axios.get(url).then(function (response) {
                    // handle success                   
                    var respuesta = response.data; 
                    console.log("Respuesta : ", respuesta); 
                    me.arrayDetalle = respuesta.empleados;   

                  })
                  .catch(function (error) {
                    // handle error
                    console.log(error);
                  })
                  .finally(function () {
                    // always executed
                  });
            },

            validarNomina() {
                this.errorTipoNomina=0;
                this.errorMostrarMsjTipoNomina=[];

                if(!this.tiponomina_id){
                    this.errorMostrarMsjTipoNomina.push("(*) Debe seleccionar un tipo de nomina");
                }

                if(!this.fecini){
                    this.errorMostrarMsjTipoNomina.push("(*) Debe indicar Periodo desde");
                }

                if(!this.fecfin){
                    this.errorMostrarMsjTipoNomina.push("(*) Debe indicar Periodo hasta");
                }                

                if(this.errorMostrarMsjTipoNomina.length) this.errorTipoNomina=1;
                return this.errorTipoNomina;
            },          

            mostrarDetalle() {                
                let me = this;
                this.listado = 0;
                this.selectTipoNomina();                              
                me.arrayDetalle=[];
            },

             ocultarDetalle() {
                this.listado = 1;   
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
            this.listarNomina(1, this.buscar, this.criterio);        
        }
    }
</script>