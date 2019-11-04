<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //if(!$request->ajax()) return redirect('/');
            
            /*$buscar = $request->buscar;
            $criterio = $request->criterio;

            if($buscar == '') {
                $users = User::join('roles', 'users.idrol', '=', 'roles.id')->select('users.id', 'users.nombre', 'users.tipo_documento', 'users.num_documento', 'users.direccion', 'users.telefono', 'users.email', 'users.usuario', 'users.password', 'users.condicion', 'users.idrol', 'users.imagen' , 'roles.nombre as rol')->orderBy('id', 'desc')->paginate(3);
            } else {
                $users = User::join('roles', 'users.idrol', '=', 'roles.id')->select('users.id', 'users.nombre', 'users.tipo_documento', 'users.num_documento', 'users.direccion', 'users.telefono', 'users.email', 'users.usuario', 'users.password', 'users.condicion', 'users.idrol', 'users.imagen', 'roles.nombre as rol')->where('users.'.$criterio, 'like', '%' . $buscar . '%')->orderBy('id', 'desc')->paginate(3);
            }     
        
        return [
            'pagination' => [
                'total' => $users->total(),
                'current_page' => $users->currentPage(),
                'per_page' => $users->perPage(),
                'last_page' => $users->lastPage(),
                'from' => $users->firstItem(),
                'to' => $users->lastItem(),
            ],

            'users' => $users
        ]; */
        $users = User::all();
        return $users;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $user = new User();
        $user->nombre = $request->nombre;        
        $user->num_documento = $request->num_documento;
        $user->telefono = $request->telefono;
        $user->email = $request->email;
        $user->condicion = '1';
        $user->direccion = $request->direccion;   
        $user->institucion_id = '5';   
        $user->password = bcrypt( $request->password );        
        $user->rol = $request->rol;
        if($request->imagen) {
            $exploded = explode(',', $request->imagen);
            $decoded = base64_decode($exploded[1]);

            if(str_contains($exploded[0], 'jpeg')) {
                $extension = 'jpg';
            } else {
                $extension = 'png';
            }

            $filename = str_random().'.'.$extension;

            $path = public_path().'/img/usuario/'.$filename;

            file_put_contents($path, $decoded);

            $user->imagen = $filename;
        }
        $user->save();
    }   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->id);        
        $user->nombre = $request->nombre;        
        $user->num_documento = $request->num_documento;
        $user->telefono = $request->telefono;
        $user->email = $request->email;
        $user->direccion = $request->direccion;        
        $user->password = bcrypt( $request->password );
        $user->condicion = '1';
        $user->rol = $request->rol;

        $currentPhoto = $user->imagen;
        if($request->imagen) {
            if($request->imagen != $currentPhoto) {

                    $exploded = explode(',', $request->imagen);
                    $decoded = base64_decode($exploded[1]);

                    if(str_contains($exploded[0], 'jpeg')) {
                    $extension = 'jpg';
                    } else {
                    $extension = 'png';
                    }
                     $filename = str_random().'.'.$extension;

                    $path = public_path().'/img/usuario/'.$filename;

                    file_put_contents($path, $decoded);

                    //Eliminar imagen anterior del servidor
                    $usuarioImagen = public_path("/img/usuario/").$currentPhoto;
                        if (file_exists($usuarioImagen)) {
                            @unlink($usuarioImagen);
                        }

                    $user->imagen = $filename;

                }
            }
        $user->save();
    } 

    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->id);               
        $user->condicion = '0';
        $user->save();
    }

    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->id);
        $user->condicion = '1';
        $user->save();
    }
}
