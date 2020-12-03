@extends('layout')
@section('header')
<h1>Eliminar Livro</h1>
    @endsection

@section('conteudo')

<h2>Deseja eliminar o Livro?</h2>
<h2>{{$livro->titulo}}</h2>
<form method="method=post" action="{{route('livros.destroy', ['id'=>$livro->id_livro])}}">
@csrf
@method('delete')
<input type="submit" value="enviar">
</form>
@endsection