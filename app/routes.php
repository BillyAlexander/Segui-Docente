<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


// Route::get('/', 'HomeController@index', function()
// {
// 	return View::make('HomeController.index');
// });

// Route::get('/contacto', 'HomeController@contacto', function()
// {
// 	// blade
// 	return View::make('HomeController.contacto');
// });

// Route::get('/contacto', 'HomeController@contacto');

Route::get('/',array('as' => 'index', 'uses' => 'HomeController@index'));

Route::get('/correo',array('uses' => 'HomeController@correo', 'as' => 'correo'));

Route::get('/contacto',array('uses' => 'HomeController@contacto' ,'as' => 'contacto'));

Route::get('/login', 'HomeController@login' ,function(){
     return View::make('HomnreCotroller@login');
});

//Route::get('/privado',array('uses' => 'HomeController@privado' ,'as' => 'privado'))->before("auth_user");
Route::get('/privado', 'HomeController@privado' ,function(){
     return View::make('HomnreCotroller@privado');
});

Route::get('/salir','HomeController@salir' ,function(){});

Route::get('/register','HomeController@register' ,function()
{
            return View::make('HomnreCotroller@register');
});

Route::any('/salir',array('uses' => 'HomeController@salir' ,'as' => 'salir'))->before("auth_user");
//Route::get('/salir',array('as'=>'salir', 'uses'=>'HomerController@lsair'));
Route::any('/register',array('uses' => 'HomeController@register' ,'as' => 'register'))->before("guest_user");
Route::any('/login',array('uses' => 'HomeController@login' ,'as' => 'login'))->before("guest_user");
Route::any('/privado',array('uses' => 'HomeController@privado' ,'as' => 'privado'))->before("auth_user");



Route::post('/login',array('before' => 'csrf' ,function(){
    $user=array(
        'email'=>Input::get('email'),
        'password'=>(Input::get('password')),
        'active'=>1,
        
    );
    
    $remember=Input::get('remember');
    $remember=='On' ? $remember = true : $remember=false;
    
    if(Auth::user()->attempt($user,$remember))
    {
        return Redirect::route("privado");
    }
    else
    {
        return Redirect::route("login");
    }

}));



Route::post('/register',array('before' => 'csrf' ,function(){
                                $rules=array(
				    'user' => 'required|min:3|max:50',
                                    'email' => 'required|email|unique:users|between:3,80',
                                    'password' => 'required|min:8|max:16',
                                    'repetir_password' => 'required|same:password',
                                    'terminos' => 'required',
     				);
                                
                                $infomesaje=array(
				    'user.required' => 'Este campo es requerido',
                                    'user.min' => 'Minimo 3 caracteres',
                                    'user.max' => 'Maximo 50 caracteres',

                                    'email.required' => 'Este campo es requerido',
                                    'email.email' => 'El formato de email es incorrecto',
                                    'email.unique' => 'El email ya se encuentra registrado',
                                    'email.between' => 'Debe contener entre 3 y 80 caracteres',

                                    'password.required' => 'Este campo es requerido',
                                    'password.min' => 'Minimo 8 caracteres',
                                    'password.max' => 'Maximo 16 caracteres',

                                    'repetir_password.required' => 'Este campo es requerido',
                                    'repetir_password.same' => 'Las claves no coinciden',
                                    
                                    'terminos.required' => 'Este campo es requerido',

				);
                                
                                $validar=Validator::make(Input::All(),$rules,$infomesaje);
                                if($validar->passes())
                                {
//                                   GUardar en tabla users
                                    $user=Input::get('user');
                                    $email=Input::get('email');
                                    $password=Hash::make(Input::get('password'));

                                    if (Hash::needsRehash($password))
                                    {
                                        $password = Hash::make(Input::get('password'));
                                    }
                                    
                                    $con=DB::connection('mysql');
                                    $sql='insert into users(user,email,password) values (?,?,?)';
                                    $con->insert($sql,array($user,$email,$password));
                                    
//                                    crear cookies para ver si se ha registrado
//                                    string alfanumerico de 32 caracteres de longitud
                                    $key=Str::random(32);
                                    Cookie::queue('key',$key,60*24);
//                                    almacenar email
                                    Cookie::queue('email',$email,60*24);
                                    
//                                    crear la url de confirmacion para el mensaje de email
                                    $msg="<a href='".URL::to("/confirmregister/$email/$key")."'>Confirmar cuenta</a>";
                                    
                                    $data=array(
                                        'user' => $user,
                                        'msg' => $msg,
                                    );
                                    $fromEmail='alex22wb@gmail.com';
                                    $fromName='Administrador';
                                    
                                    Mail::send('emails.register', $data, function ($message) use ($fromName,$fromEmail,$email,$user){
                                            $message->to($email,$user);
            //                                $message->to($fromEmail,$fromName);
                                            $message->from($fromEmail,$fromName);
                                            $message->subject('Confirmar registro en laravel');
					});
                                    
                                         $mensaje='<hr><label class="label label-info">'.$user.' le hemos enviado un email a su cuenta de correo electronico para que confirme su registro</label><hr>';
                                         return Redirect::route('register')->with('message',$mensaje);
                                }
                                else 
                                {
                                    return Redirect::back()->withInput()->withErrors($validar);
                                }

}));


Route::get('/confirmregister/{email}/{key}',function($email,$key){
    if(urldecode($email)==Cookie::get('email') && urldecode($key)==Cookie::get('key') )    
    {
        $con=DB::connection('mysql');
        $sql='update users set active=1 where email=?';
        $con->update($sql,array($email));
        $message='<hr><label class="label label-success">Enhorabuena tu regisro se ha realizado con exito</label><hr>';
        return Redirect::route('login')->with('message',$message);
    }
 else {
        return Redirect::route('register');
    }
        
});

Route::any('/confirmregister',array('uses' => 'HomeController@confirmregister' ,'as' => 'confirmregister'))->before("guest_user");



//articulo

Route::get('/creararticulo', 'UserController@creararticulo', function()
{
	return View::make('HomeController.creararticulo');
});

Route::any('/creararticulo', array('as' => 'creararticulo', 'uses' => 'UserController@creararticulo'))->before("auth_user");

Route::post('/creararticulo', array('before' => 'csrf', function(){
    
    $rules = array(
        "titulo" => "required|regex:/^[a-z0-9áéóóúàèìòùäëïöüñ\s]+$/i|min:3|max:100",
        "descripcion" => "required|min:10|max:1000",
        "src" => "required|max:10000|mimes:jpg,jpeg,png,gif", //10000 kb
        "href" => "required|min:5|max:250|url",
    );
    
    $messages = array(
        "titulo.required" => "El campo Título es requerido",
        "titulo.regex" => "Tan sólo se aceptan letras y números",
        "titulo.min" => "El mínimo permitido son 3 caracteres",
        "titulo.max" => "El máximo permitido son 100 caracteres",
        "descripcion.required" => "El campo Descripción es requerido",
        "descripcion.min" => "El mínimo permitido son 10 caracteres",
        "descripcion.max" => "El máximo permitido son 1000 caracteres",
        "src.required" => "Es requerido subir una imagen",
        "src.max" => "El tamaño máximo de la imagen son 10000kb",
        "src.mimes" => "El archivo que pretendes subir no es una imagen",
        "href.required" => "Tienes que incluir el sitio web",
        "href.min" => "El mínimo permitido son 5 caracteres",
        "href.max" => "El máximo permitido son 250 caracteres",
        "href.url" => "Introduce una url correcta",
    );
    
    $validator = Validator::make(Input::All(), $rules, $messages);

    if ($validator->passes())
    {
        $id_user = Auth::user()->get()->id;
        
        if(!empty($id_user))
        {
            $titulo = Input::get('titulo');
            $descripcion = htmlspecialchars(Input::get('descripcion'));
            $src = $_FILES['src'];
            $href = Input::get('href');
            
            $ruta_imagen = "directorio/images/";
            $imagen = rand(1000, 9999)."-".$src["name"];
            
            move_uploaded_file($src["tmp_name"], $ruta_imagen.$imagen);
            
            $conn = DB::connection("mysql");
            $sql = "INSERT INTO directorio (id_user, titulo, descripcion, src, href) VALUES (?, ?, ?, ?, ?)";
            $conn->insert($sql, array($id_user, $titulo, $descripcion, $ruta_imagen.$imagen, $href));
            
            $message = "<hr><label class='label label-info'>Enhorabuena artículo creado con éxito</label><hr>";
            return Redirect::back()->with("message", $message);
        }
    }
    else
    {
        return Redirect::back()->withInput()->withErrors($validator);    
    }
    
}));





// redireccion a pagina de error 404
App::missing(function($exception)
{
	return Response::view('error.error404', array(), 404);
});




