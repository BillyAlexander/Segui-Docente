<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="../../../public/directorio/images/jquery.png" />
    <!--<link rel="icon" href="../../favicon.ico">-->
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" >
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.theme.min.css" >
    <script type="text/javascript" src="bootstrap/js/jquery.js"></script>
    <script type="text/javascript" src="bootstrap/js/jquery.min.js"></script>
    

    @yield('head')

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>

        <a class="navbar-brand" href="{{URL::route('index')}}">Tesis App</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
          <?php 
              $vista=Route::currentRouteName();
              $current= array
              (
                'index' => '',
                'contacto' => '',
                'login' => '',
                'register' => ''
              );
              if($vista=='home' || $vista=='index')
              {
                $current['index']='active';
              }
              else if ($vista=='contacto')
              {
                $current['contacto']='active';
              }
              else if ($vista=='login')
              {
                $current['login']='active';
              }
              else if ($vista=='register')
              {
                $current['register']='active';
              }

          ?>
            <li class="{{$current['index']}}"><a href="{{URL::route('index')}}">Inicio</a></li>
            <li class="{{$current['contacto']}}"><a href="{{URL::route('correo')}}">Contacto</a></li>
            <?php if(Auth::user()->guest()) {?>
            <li class="{{$current['login']}}"><a href="{{URL::route('login')}}">Iniciar Sesion</a></li>
            <li class="{{$current['register']}}"><a href="{{URL::route('register')}}">Registrarme</a></li>
            <?php } else { ?>
            <li>
                <div class="navbar-collapse collapse">
                {{ Form::open(array
			(
				'action' => 'HomeController@salir',
				'method' => 'POST',
				'role' => 'form',
                                'class' => 'navbar-form',
				
			))

                 }}
                 <a href="{{URL::route('privado')}}">
                     {{ Form::label(Auth::user()->get()->user,null,array('class'=>'label label-info')) }}
                 </a>
                 {{ Form::input('submit','','Salir',array('class'=>'btn btn-default')) }}
                 {{ Form::close() }}
                </div>
            </li>
            <?php } ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container" style="margin-top:80px">
      @yield('content')
      
     

    </div><!-- /.container -->



  </body>
</html>
