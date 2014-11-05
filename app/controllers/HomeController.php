<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	// para pasar por parametros////////////////////////////////////////////////////////////////////
	// public function index()
	// {
	// 	$vari=0;
	// 	                    // carpeta.vista
	// 	return View::make('HomeController.index',array('valor'=>$vari));
	// }

	// public function home()
	// {
	// 	$vari=1;
	// 	                    // carpeta.vista
	// 	return View::make('HomeController.index',array('valor'=>$vari));
	// }

	// public function contacto()
	// {
	// 	$vari=2;
	// 	                    // carpeta.vista
	// 	return View::make('HomeController.contacto',array('valor'=>$vari));
	// }





	public function index()
	{
                $conn=DB::connection("mysql");
//                insertar
//                $sql="INSERT INTO articulos(articulo,descripcion,src) VALUES (?,?,?)";
//                $conn->insert($sql,  array('Google','Google es un buscador web','http://www.google.com.ec/imgres?imgurl=http%3A%2F%2Fwww.opinno.com%2Fsites%2Fdefault%2Ffiles%2Fgoogle_lupa_0.jpg&imgrefurl=http%3A%2F%2Fwww.opinno.com%2Fes%2Flabs-organiza-evento-google-cloud&h=362&w=644&tbnid=vchH8lZ00Td8eM%3A&zoom=1&docid=tD5Hp0dJna8ofM&ei=izRVVOLAEYmbgwSe_oPwCA&tbm=isch&client=firefox-beta&ved=0CH8QMyhFMEU&iact=rc&uact=3&dur=201&page=5&start=58&ndsp=16'));
//                
//                $sql="select * from articulos where id=?";
//                $resultado=$conn->select($sql,array(1));
//                
//                
                  if(isset($_GET['buscar'])) 
                  {
                      $buscar=  htmlspecialchars(Input::get("buscar"));
                      $paginacion=$conn
                                    ->table('directorio')
                                    ->where('titulo','like','%'.$buscar.'%')
                                    ->orwhere('descripcion','like','%'.$buscar.'%')
                                    ->paginate(1);
                  }
                  else 
                  {
                      $paginacion=$conn->table('directorio')->paginate(1);
                  }
                  
		                    // carpeta.vista
		return View::make('HomeController.index',array('paginacion' =>$paginacion));
	}

	public function correo()
	{
            $mensaje=null;
            if(isset($_GET['contactos']))
			{
					$rules=array(
									'name' => 'required|min:3|max:80',
                                    'email' => 'required|email|between:3,80',
                                    'subject' => 'required|min:3|max:80',
                                    'msg' => 'required|between:3,500',

						);


					$infomesaje=array(
									'name.required' => 'Este campo es requerido',
                                    'name.min' => 'Minimo 3 caracteres',
                                    'name.max' => 'Maximo 80 caracteres',

                                    'email.required' => 'Este campo es requerido',
                                    'email.email' => 'El formato de email es incorrecto',
                                    'email.between' => 'Debe contener entre 3 y 80 caracteres',

                                    'subject.required' => 'Este campo es requerido',
                                    'subject.min' => 'Minimo 3 caracteres',
                                    'subject.max' => 'Maximo 80 caracteres',

                                    'msg.required' => 'Este campo es requerido',
                                    'msg.between' => 'Debe contener entre 3 y 500 caracteres',

						);

					$validar=Validator::make(Input::All(),$rules,$infomesaje);


                if($validar->passes())

                {
                $data=array(
                                    'name' => Input::get('name'),
                                    'email' => Input::get('email'),
                                    'subject' => Input::get('subject'),
                                    'msg' => Input::get('msg'),
                               );
                    
		                    // carpeta.vista
				$fromEmail='alex22wb@gmail.com';
                                $fromName='Administrador';
                
                                $toEmail=Input::get('email');
                                $toName=Input::get('name');

                                $subj=Input::get('subject');

                
				Mail::send('emails.auth.plantilla', $data, function ($message) use ($fromName,$fromEmail,$toEmail,$toName,$subj){
                                $message->to($toEmail,$toName);
//                                $message->to($fromEmail,$fromName);
				$message->from($fromEmail,$fromName);
				$message->subject($subj);
					});
                    $mensaje='Mensaje enviado correctamete';
                }
                else
            		{
            			
            			return  Redirect::back()->withInput()->withErrors($validar);
            		}
            }



		return View::make('emails.auth.test',array('mensaje' => $mensaje));
	}

	public function contacto()
	{
		// Mail::pretend();
		// $comparar=null;
		$mensaje=null;
		if(isset($_GET['contactos']))
		{
                    $data=array(
                                    'name' => Input::get('name'),
                                    'email' => Input::get('email'),
                                    'subject' => Input::get('subject'),
                                    'msg' => Input::get('msg'),
                               );
                    $fromEmail="alex22wb@gmail.com";
                    $fromName="Administrador";
                    $toEmail="alex22_w@hotmail.com";
                    $toName="Alex Villar";
                    
                    Mail::send('emails.contacto',$data, function($message) use ($fromName,$fromEmail,$toName,$toEmail)
                    {
                        $message->to($fromEmail,$fromName);
                        $message->from($toEmail,$toName);
                        $message->subject('Prueba email de contacto');
                    });
                    $mensaje='<div class="text-info">Mensaje enviado correctamete</div>';
                   
		}
		                    // carpeta.vista
		return View::make('HomeController.contacto',array('mensaje' => $mensaje));
	}
        
        public function login()
        {
            return View::make('HomeController.login');
        }
        
        public function privado()
        {
            return View::make('HomeController.privado');
        }
        
        public function salir()
        {
            Auth::user()->logout();
            return Redirect::to('login');
        }
        
        public function register()
        {
           return View::make('HomeController.register');
        }
        
        public function confirmregister()
        {
           return View::make('HomeController.register');
        }


}













       // <!--  @if ($valor==0)
       //    <a class="navbar-brand" style="color:#fff;" href="{{URL::route('index')}}">Tesis App</a>
       //  </div>
       //  <div class="collapse navbar-collapse">
       //    <ul class="nav navbar-nav">
       //      <li><a href="{{URL::route('home')}}">Inicio</a></li>
       //      <li><a href="{{URL::route('contacto')}}">Contacto</a></li>
       //    </ul>
       //  </div> -->
       //  <!--/.nav-collapse -->
        
       //  <!-- @elseif($valor==1)
       //    <a class="navbar-brand" href="{{URL::route('index')}}">Tesis App</a>
       //  </div>
       //  <div class="collapse navbar-collapse">
       //    <ul class="nav navbar-nav">
       //      <li class="active"><a href="{{URL::route('home')}}">Inicio</a></li>
       //      <li><a href="{{URL::route('contacto')}}">Contacto</a></li>
       //    </ul>
       //  </div> -->

       // <!--  @elseif($valor==2)
       //    <a class="navbar-brand" href="{{URL::route('index')}}">Tesis App</a>
       //  </div>
       //  <div class="collapse navbar-collapse">
       //    <ul class="nav navbar-nav">
       //      <li ><a href="{{URL::route('home')}}">Inicio</a></li>
       //      <li class="active"><a href="{{URL::route('contacto')}}">Contacto</a></li>
       //    </ul>
       //  </div>
       //  @endif -->