@extends('layouts.bootstrap')

@section('head')
<title>Privado</title>
<meta name='title' content='Login'>
<meta name='description' content='Login'>
<meta name='keywords' content='palabras, clave'>
<meta name='robots' content='noindex,nofollow'>
@stop

@section('content')

<h1>Bienvenido {{Auth::user()->get()->user}}</h1>

<a href="{{URL::route('creararticulo')}}"  class="btn btn-primary">Crear articulo</a>

@stop

