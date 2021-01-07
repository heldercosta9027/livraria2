@extends('layout')
<ul>
ID:{{$livro->id_livro}}<br>
Titulo:{{$livro->titulo}}<br>
Idioma:{{$livro->idioma}}<br>
ISBN:{{$livro->isbn}}<br>
Data Edição:{{$livro->data_edicao}}<br>
Total paginas:{{$livro->total_paginas}}<br>
Observações:{{$livro->observacoes}}<br>
@if(isset($livro->imagem_capa))
Imagem Capa: <img height="150px"; width="200px"; src="{{asset('imagem/livros/'.$livro->imagem_capa)}}"><br>
@endif   
@if(count($livro->editoras)>0)
        @foreach($livro->editoras as $editora)
        Data Edição:{{$editora->nome}}<br>
        @endforeach
    @else
        <div class="alert alert-danger" role="alert">
        Sem o nome do editora definido
        </div>
    @endif
    @if(isset ($livro->genero->designacao))
        Genero:{{$livro->genero->designacao}}<br>
    @else
        <div class="alert alert-danger" role="alert">
        Sem género definido
        </div>
    @endif
    @if(count($livro->autores)>0)
        @foreach($livro->autores as $autor)
            Autor:{{$autor->nome}}<br>
        @endforeach
    @else
        <div class="alert alert-danger" role="alert">
        Sem o nome do autor definido
        </div>
    @endif

Sinopse:{{$livro->sinopse}}<br>
Sinopse(Ficheiro PDF):<a href="{{asset('ficheiroPdf/livros/'.$livro->ficheiro_sinopse)}}" Target="_blank">{{$livro->ficheiro_sinopse}} </a>
Created_at:{{$livro->created_at}}<br>
Updated_at:{{$livro->updated_at}}<br>
Deleted_at:{{$livro->deleted_at}}
</ul>
@if(isset($livro->id_user))
    Utilizador: {{$livro->users->name}}<br>
@else
<div class="alert alert-danger" role="alert">
        Sem o Utilizador definido
        </div>
@endif

    


@if(auth()->check())
@if(auth()->user()->id==$livro->id_user || Gate::allows('admin'))
<a href="{{route('livros.edit',['id'=>$livro->id_livro])}}" class="btn btn-info" role="button"> Editar Livro </a>
<a href="{{route('livros.delete',['id'=>$livro->id_livro])}}" class="btn btn-info" role="button"> Eliminar Livro </a>
@endif
@if(is_null($livro->id_user) || Gate::allows ('admin'))
<a href="{{route('livros.edit',['id'=>$livro->id_livro])}}" class="btn btn-info" role="button"> Editar Livro </a>
<a href="{{route('livros.delete',['id'=>$livro->id_livro])}}" class="btn btn-info" role="button"> Eliminar Livro </a>
@endif
@endif
@if(auth()->check())
@if(auth()->user()->id==$livro->id_user || Gate::allows ('admin')) 
<a href="{{route('livros.like',['id'=>$livro->id_livro])}}" class="btn btn-info" role="button">Editar Livro</a>
@endif
@endif