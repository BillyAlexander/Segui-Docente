@extends('layouts.bootstrap')

@section('head')
<title>Pagina de Inicio</title>
<meta name="description" content="Pagina de Inicio">
<meta name="keywords" content="palabras, clave">
@stop

@section('content')
<h1>Inicio </h1>  

<hr>
    {{ Form::open(array
                    (
                        'action' => 'HomeController@index',
                        'method' => 'GET',
                        'role' => 'form',
			'class' => 'form-inline',				
	             ))
    }}
    {{ Form::input('text','buscar',Input::get('buscar'),array('class' => 'form-control')) }}
    {{ Form::input('submit',null,'Buscar',array('class' => 'btn btn-primary')) }}
    {{Form::close() }}
    
<hr>
<label style="float: right;" class="label label-info">Elemento {{ $paginacion->getCurrentPage() }} de un total de {{ $paginacion->getTotal() }} elementos</label><br>
<hr>

        <center>
                <div class="container">
                    {{ $paginacion->appends(array ('buscar' => Input::get('buscar')))->links() }}
                </div>
        </center>
        
        <?php foreach ($paginacion as $row):?>
            <div class="container">
                <ul class="list-inline">
                    <li><a href="{{ $row->href }}"> <img src="{{ $row->src }}" title="{{ $row->titulo }}" ></a></li>
                    <li>{{ $row->descripcion }}</li>
                </ul>
            </div>        
        <?php  endforeach;?>
            <center>
                <div class="container">
                    {{ $paginacion->appends(array ('buscar' => Input::get('buscar')))->links() }}
                </div>
            </center>
       
@stop