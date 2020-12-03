<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livro;

class LivrosController extends Controller
{
    //
    public function index(){
        //$livros = Livro::all()->sortbydesc('idl');
        $livros= Livro::paginate(4);
        return view('livros.index',[
            'livros'=>$livros
        ]);
    }
    public function show(Request $request){
        $idLivro = $request->id;
        //$livro=Livro::findOrFail($idLivro);
        //$livro=Livro::find($idLivro);
        $livro=Livro::where('id_livro',$idLivro)->with(['genero','autores','editoras'])->first();
        return view('livros.show',[
            'livro'=>$livro
        ]);
        
    }
     public function create(){
            return view('livros.create');
        }
    public function store(Request $r){
        //$novoLivro=$r->all();
        //dd($novoLivro);
        
        $novoLivro = $r->validate([
            'titulo'=>['required', 'min:3','max:100'],
            'idioma'=>['nullable', 'min:3', 'max:20'],
            'total_paginas'=>['nullable', 'numeric', 'min:1'],
            'data_edicao'=>['nullable','date'],
            'isbn'=>['required', 'min:1', 'max:13'],
            'observacoes'=>['nullable', 'min:1', 'max:255'],
            'imagem_capa'=>['nullable'],
            'id_genero'=>['numeric', 'nullable'],
            'id_autor'=>['numeric','nullable'],
            'sinopse'=>['nullable', 'min:3', 'max:255'] 
        ]);
        $livro = Livro::create($novoLivro);
        
        
        return redirect()->route('livros.show', [
            'id'=>$livro->id_livro
        ]);
    }
    public function edit(Request $request){
         $idLivro=$request->id;
        
        $livro=Livro::where('id_livro', $idLivro)-first();
        
        return view('livros.edit', [
            'livro'=>$livro
        ]);
    }
    
    public function update(Request $request){
          $idLivro=$request->id;
          $livro=Livro::where('id_livro',$idLivro)->first();
          $atualizarLivro = $request->validate([
            'titulo'=>['required', 'min:3','max:100'],
            'idioma'=>['nullable', 'min:3', 'max:20'],
            'total_paginas'=>['nullable', 'numeric', 'min:1'],
            'data_edicao'=>['nullable','date'],
            'isbn'=>['required', 'min:1', 'max:13'],
            'observacoes'=>['nullable', 'min:1', 'max:255'],
            'imagem_capa'=>['nullable'],
            'id_genero'=>['numeric', 'nullable'],
            'id_autor'=>['numeric','nullable'],
            'sinopse'=>['nullable', 'min:3', 'max:255'] 
        ]);
        $livro->update($atualizarLivro);
        return redirect()->route('livros.show', [
            'id'=>$livro->id_livro
            ]);
    }
    public function delete(Request $r){
        $livro = Livro::where ('id_livro', $r->id)->first();
        if(is_null($livro)){
            return redirect()->route('livros.index')
                ->with('msg', 'O livro não existe');
        }
        else
        {
          return view('livros.delete',['livros=>$livro']);  
        }
    }
    public function destroy(Request $r){
        $livro = Livro::where ('id_livro', $r->id)->first();
        if(is_null($livro)){
            return redirect()->route('livros.index')
                ->with('msg', 'O livro não existe');
        }
        else
        {
            $livro->delete();
            return redirect()->route('livros.index')->with('msg','Livro eliminado!');
            
        }
    }
    
}
