@extends('layout')
@section('header')
<h1>Eliminar Editora</h1>
    @endsection

@section('conteudo')

<h2>Deseja eliminar o Autor?</h2>
<h2>{{$editora->nome}}</h2>
<form method="post" action="{{route('editoras.destroy', ['ide'=>$editora->id_editora])}}">
@csrf
@method('delete')
<input type="submit" value="enviar">
</form>
@endsection