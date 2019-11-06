<template>
<main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="/">BACKEND - SISTEMA DE COMPRAS - VENTAS</a></li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">

                       <h2>Listado de Usuarios</h2><br/>
                      
                        <button class="btn btn-primary btn-lg" type="button" @click="abrirModal('usuario', 'registrar')">
                            <i class="fa fa-plus fa-2x"></i>&nbsp;&nbsp;Agregar Usuario
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
                                        <option value="nombre">Nombre</option>                                       
                                        <option value="email">Email</option>                                        
                                    </select>
                                    <input type="text" @keyup.enter="listarUsuario(1,buscar,criterio);" class="form-control" placeholder="Buscar texto" v-model="buscar">
                                    <button type="submit" @click="listarUsuario(1,buscar,criterio);" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr class="bg-primary">                                   
                                    <th>Nombre</th>   
                                    <th>Dirección</th>                                    
                                    <th>Teléfono</th>
                                    <th>Email</th>                                    
                                    <th>Rol</th>
                                    <th>Imagen</th>
                                    <th>Editar</th>                                    
                                </tr>
                            </thead>
                            <tbody>                               
                                <tr v-for="usuario in arrayUsuario" :key="usuario.id">                                   
                                    <td v-text="usuario.nombre"></td>                                    
                                    <td v-text="usuario.direccion"></td>
                                    <td v-text="usuario.telefono"></td>
                                    <td v-text="usuario.email"></td>                                    
                                    <td v-text="usuario.rol"></td>
                                    <td>
                                        <img :src="'img/usuario/' + usuario.imagen" class="img-responsive" width="100px" height="100px">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-md" @click="abrirModal('usuario', 'actualizar', usuario )">
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
            <div class="modal fade" :class="{ 'mostrar':modal } " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" @click="cerrarModal()" class="close" aria-label="Close">
                              <span aria-hidden="true" >×</span>
                            </button>
                        </div>
                       
                        <div class="modal-body">
                            
                            <div v-show="errorUsuario" class="form-group row div-error">
                                
                                <div class="text-center text-error">
                                    
                                    <div v-for="error in errorMostrarMsjUsuario" :key="error" v-text="error"></div>

                                </div>
                            
                            </div>
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de usuario">
                                    </div>
                                </div>                                
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Numero de documento</label>
                                    <div class="col-md-9">
                                    <input type="text" v-model="num_documento" class="form-control" placeholder="Ingrese Número de documento">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Dirección</label>
                                    <div class="col-md-9">
                                    <input type="text" v-model="direccion" class="form-control" placeholder="Ingrese dirección de habitación">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Telefono</label>
                                    <div class="col-md-9">
                                    <input type="text" v-model="telefono" class="form-control" placeholder="Ingrese telefono">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Email</label>
                                    <div class="col-md-9">
                                    <input type="text" v-model="email" class="form-control" placeholder="Ingrese email">
                                    </div>                                    
                                </div>
                                <div class="form-group row" v-if="user_rol == 1">
                                    <label class="col-md-3 form-control-label" for="text-input">Empresa</label>
                                    <div class="col-md-9">
                                
                                        <!--la variable idcategoria asociado a v-model la asignamos
                                        en la propiedad data en javascript (ver al final) -->

                                    <select class="form-control" v-model="empresa_id" @change="selectEmpresa()">
                                  
                                      <!-- el id y nombre asociado en el objeto categoria vienen de los campos
                                      de la tabla categorias de la bd-->
                                      <option value="0" disabled>Seleccione</option>
                                      <!--el arrayCategoria es una variable de la data javascript de vue 
                                      y se cargan los registros de la categoria una vez se abra la ventana
                                      modal-->
                                      <option v-for="empresa in arrayEmpresa" :key="empresa.id" :value="empresa.id" v-text="empresa.nombre"></option>

                                    </select>                               
                                </div>
                            </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Rol</label>
                                    <div class="col-md-9">
                                        <select v-model="rol" class="form-control">                                            
                                            <option value="1" v-if="user_rol == 1">Administrador</option>
                                            <option value="2">Gerente</option>
                                            <option value="3">Empleado</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Imagen</label>
                                    <div class="col-md-9">
                                      
                                        <!--poniendo :src se llama a la variable imagen que esta declarada en la propiedad data-->
                                        <!--poner this.imagen=""; en cerrarModal para limpiar el campo ya que aparecia la imagen al registrar un registro-->
                                       

                                        <div v-if="tipoAccion==1">
                                            <input type="file" @change="subirImagen" class="form-control" placeholder="">
                                            <img :src="imagen" class="img-responsive" width="100px" height="100px">
                                        </div>
                                             

                                        <div v-if="tipoAccion==2">

                                                <input type="file" @change="subirImagen" class="form-control" placeholder="">      
                                                <img :src="imagen"  width="100px" height="100px">                         
                                        </div>
                                               
                      
                                    </div>
                                </div>                                
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="password-input">Password</label>
                                    <div class="col-md-9">
                                    <input type="password" v-model="password" class="form-control" placeholder="Ingrese password">
                                    </div>                                    
                                </div>                           
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" @click="cerrarModal()" class="btn btn-danger"><i class="fa fa-times fa-2x"></i> Cerrar</button>
                            <button type="button" @click="registrarUsuario()" v-if="tipoAccion==1" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Guardar</button>
                            <button type="button" @click="actualizarUsuario()" v-if="tipoAccion==2" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Actualizar</button>                           
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->           
        </main>
</template>
<style type="text/css">
        .modal-content {
            width: 100% !important;
            position: absolute !important;
        }

        .mostrar {
            height: 1000px;
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
                users: [],
                usuario_id:0,
                nombre: '',                
                num_documento : '',
                direccion : '',
                telefono : '',
                email : '',                
                password:'',
                rol:0,
                imagen: '',
                arrayEmpresa: [],
                empresa_id: 0,
                arrayUsuario:[],
                arrayRol:[],
                user_rol: 0,
                modal:0, //0=Modal abierto / 1=Modal cerrado
                tituloModal:'',
                tipoAccion:'',
                errorUsuario:0,
                errorMostrarMsjUsuario:[],
                pagination: {
                    'total' : 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset:3,
                criterio: 'nombre',
                buscar: ''
            }
        },

        computed: {
            isActived: function(){
                return this.pagination.currente_page;
            },

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
            listarUsuario(page, buscar, criterio){

                let me = this;

                var url = '/user?page='+ page + '&buscar=' + buscar + '&criterio=' + criterio;

                axios.get(url).then(function (response) {

                    var respuesta = response.data;
                    me.arrayUsuario = respuesta.users.data;
                    me.institucion_id = respuesta.institucion_id;
                    me.user_rol = respuesta.user_rol;

                    console.log("Rol : ", me.user_rol);

                  })
                  .catch(function (error) {
                    // handle error
                    console.log(error);
                  })
                  .finally(function () {
                    // always executed
                  });
            },

            cargarPdf(page, buscar, criterio)
            {
                window.open('http://127.0.0.1:8000/user/listarPdf?page='+ page + '&buscar=' + buscar + '&criterio=' + criterio, '_blank');
            },     

            cambiarPagina(page, buscar, criterio){
                let me = this;
                //Actualiza la pagina actual
                me.pagination.current_page = page;                
                me.listarUsuario(page, buscar, criterio);
            },

            registrarUsuario(){
                let empresaId;
                if(this.validarUsuario()) {
                    return;
                }
                let me=this;
                if(me.user_rol == 1) {
                    empresaId = me.empresa_id;
                } else {
                    empresaId = me.institucion_id;
                }

                console.log("Empresa : ", empresaId);
                axios.post('/user/registrar', {
                        'nombre':me.nombre,                        
                        'num_documento':me.num_documento,
                        'direccion':me.direccion,
                        'telefono':me.telefono,
                        'email':me.email,
                        'institucion_id':me.institucion_id,
                        'password':me.password,
                        'rol':me.rol, 
                        'imagen': me.imagen                     
                    }).then(function (response) {
                        me.cerrarModal();
                        me.listarUsuario(1, '', 'nombre');
                    }).catch(function (error) {
                    // handle error
                    console.log(error);
                    }); 
            },

            actualizarUsuario(){
                if(this.validarUsuario()) {
                    return;
                }
                let me=this;
                axios.put('/user/actualizar', {
                        'id':me.usuario_id,
                        'nombre':me.nombre,                        
                        'num_documento':me.num_documento,
                        'direccion':me.direccion,
                        'telefono':me.telefono,
                        'email':me.email,                        
                        'password':me.password,
                        'rol':me.rol,
                        'imagen': me.imagen
                    }).then(function (response) {
                        me.cerrarModal();
                        me.listarUsuario(1, '', 'nombre');
                    }).catch(function (error) {
                    // handle error
                    console.log(error);
                    });
            },           

            validarUsuario(){
                this.errorUsuario=0;
                this.errorMostrarMsjUsuario=[];

                if(!this.nombre){
                    this.errorMostrarMsjUsuario.push("(*) El nombre del usuario no puede estar vacio");
                }
                if(!this.email){
                    this.errorMostrarMsjUsuario.push("(*) El email no puede estar vacio");
                }

                if(!this.password){
                    this.errorMostrarMsjUsuario.push("(*) El password no puede estar vacio");
                }

                if(!this.empresa_id && this.user_rol == 1){
                    this.errorMostrarMsjUsuario.push("(*) Debe seleccionar una empresa");
                }

                if(this.rol == 0){
                    this.errorMostrarMsjUsuario.push("(*) Debe selecionar un rol");
                }                

                if(this.errorMostrarMsjUsuario.length) this.errorUsuario=1;
                return this.errorUsuario;
            },

            subirImagen(e){
                
                let me=this;

                let file = e.target.files[0];
             
                //console.log(file);

                let reader = new FileReader();

                reader.onloadend = (file) => {
                    
                    //console.log('RESULT', reader.result)

                    me.imagen = reader.result;
                }
                reader.readAsDataURL(file);
            },

            cerrarModal() { 
                this.modal = 0;
                this.tituloModal = "";
                this.nombre = "";                
                this.num_documento = "";
                this.direccion = "";
                this.telefono = "";
                this.email = "";                
                this.password = "";
                this.rol = 0;
                this.imagen = "";
                this.errorUsuario = 0;
            },

            abrirModal(modelo, accion, data=[]) {                
                switch(modelo) {
                    case "usuario": {
                        switch(accion){
                            case "registrar":{
                                this.modal = 1;
                                this.tipoAccion = 1;
                                this.tituloModal="Registrar Usuario"
                                this.nombre = "";                                
                                this.num_documento = "";
                                this.direccion = "";
                                this.telefono = "";
                                this.email = "";                                
                                this.password = "";
                                this.rol = 0;
                                break;
                            }
                            case "actualizar": {
                                this.modal = 1;
                                this.tipoAccion=2;
                                this.tituloModal = "Editar Proveedor";                                
                                this.usuario_id = data["id"];
                                this.nombre = data["nombre"];                                
                                this.num_documento = data["num_documento"];
                                this.direccion = data["direccion"];
                                this.telefono = data["telefono"];
                                this.email = data["email"];                                
                                this.password = data["password"];
                                this.rol = data["rol"];
                                break;
                            }
                        }
                    }
                }                
            },

            selectEmpresa() {                
                let me = this;

                var url = '/institucion';
                    
                axios.get(url).then(function (response) {
                    // handle success                     
                    var respuesta = response.data;
                    me.arrayEmpresa = respuesta.instituciones.data;
                    
                  })
                  .catch(function (error) {
                    // handle error
                    console.log(error);
                  })
                  .finally(function () {
                    // always executed
                  });

            },

            desactivarUsuario(id){
                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                  },
                 buttonsStyling: false,
                })

                swalWithBootstrapButtons.fire({
                  title: '¿Estas seguro de desactivar el usuario?',
                  //type: 'warning',
                  showCancelButton: true,
                  confirmButtonText: '<i class="fa fa-check fa-2x"></i> Aceptar',
                  cancelButtonText: '<i class="fa fa-times fa-2x"></i> Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {

                    let me=this;
                        axios.put('/user/desactivar', {
                                'id':id,                                                       
                            }).then(function (response) {                                
                                me.listarUsuario(1, '', 'nombre');
                                swalWithBootstrapButtons.fire(
                                    'Desactivado!',
                                    'Usuario desactivado.',
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

            activarUsuario(id){

                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                  },
                 buttonsStyling: false,
                })

                swalWithBootstrapButtons.fire({
                  title: '¿Estas seguro de activar el usuario?',
                  //type: 'warning',
                  showCancelButton: true,
                  confirmButtonText: '<i class="fa fa-check fa-2x"></i> Aceptar',
                  cancelButtonText: '<i class="fa fa-times fa-2x"></i> Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {

                    let me=this;
                        axios.put('/user/activar', {
                                'id':id,                                                       
                            }).then(function (response) {                                
                                me.listarUsuario(1, '', 'nombre');
                                swalWithBootstrapButtons.fire(
                                    'Activado!',
                                    'Usuario activado.',
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
            }
        },
        mounted() { 
            this.selectEmpresa();
            this.listarUsuario(1, this.buscar, this.criterio);            
        }
    }
</script>  

