@extends('layouts.bootstrap')

@section('head')
<title>Contactos</title>
<meta name="description" content="Pagina de Inicio">
<meta name="keywords" content="palabras, clave">
@stop

@section('content')
<h1>correo</h1>
{{ $mensaje }}
{{ Form::open(array
			(
				'action' => 'HomeController@correo',
				'method' => 'GET',
				'role' => 'form',
				
				
			))

	}}
	<div class="form-group">
	{{ Form::label('Nombre:') }}
	{{ Form::input('text','name',Input::old('name'),array('class' => 'form-control')) }}
	<div class="bg-danger">{{ $errors->first('name') }} </div>	
	</div>

	<div class="form-group">
	{{ Form::label('Email:') }}
	{{ Form::input('email','email',Input::old('email'),array('class' => 'form-control')) }}	
	<div class="bg-danger">{{ $errors->first('email') }} </div>	
	</div>

	<div class="form-group">
	{{ Form::label('Asuntos:') }}
	{{ Form::input('text','subject',Input::old('subject'),array('class' => 'form-control')) }}	
	<div class="bg-danger">{{ $errors->first('subject') }} </div>	
	</div>

	<div class="form-group">
	{{ Form::label('Mensaje:') }}
	{{ Form::textarea('msg',Input::old('msg'),array('class' => 'form-control')) }}	
	<div class="bg-danger">{{ $errors->first('msg') }} </div>	
	</div>

	{{ Form::input('hidden','contactos') }}
	{{ Form::input('submit',null,'Enviar',array('class' => 'btn btn-primary')) }}
        
        


	{{Form::close() }}


@stop