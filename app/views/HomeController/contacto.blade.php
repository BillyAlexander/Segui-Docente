@extends('layouts.bootstrap')

@section('head')
<title>Contactos</title>
<meta name="description" content="Pagina de Inicio">
<meta name="keywords" content="palabras, clave">
<meta name="robots" content="all">
@stop

@section('content')
	<h1>Contacto </h1>
	{{$mensaje}}
	{{ Form::open(array
			(
				'action' => 'HomeController@contacto',
				'method' => 'POST',
				'role' => 'form',
				
			))

	}}
	<div class="form-group">
	{{ Form::label('Nombre:') }}
	{{ Form::input('text','name',null,array('class' => 'form-control')) }}	
	</div>

	<div class="form-group">
	{{ Form::label('Email:') }}
	{{ Form::input('email','email',null,array('class' => 'form-control')) }}	
	</div>

	<div class="form-group">
	{{ Form::label('Asuntos:') }}
	{{ Form::input('text','subject',null,array('class' => 'form-control')) }}	
	</div>

	<div class="form-group">
	{{ Form::label('Mensaje:') }}
	{{ Form::textarea('msg',null,array('class' => 'form-control')) }}	
	</div>

	{{ Form::input('hidden','contactos') }}
	{{ Form::input('submit',null,'Enviar',array('class' => 'btn btn-primary')) }}
        
        


	{{Form::close() }}
@stop