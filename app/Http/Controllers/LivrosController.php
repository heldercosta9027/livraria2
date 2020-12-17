<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Auth;
use App\Models\Livro;
use App\Models\Genero;
use App\Models\Autor;  
use App\Models\Editora; 
use App\Models\User; 

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
        $livro=Livro::where('id_livro',$idLivro)->with(['genero','autores','editoras','users'])->first();
        return view('livros.show',[
            'livro'=>$livro
        ]);
        
    }
     public function create(){
        if(Gate::allows('admin')){
            $generos = Genero::all();
            $autores = Autor::all();
            $editoras = Editora::all();
        return view('livros.create',['generos'=>$generos,'autores'=>$autores, 'editoras'=>$editoras]);
        } 
    }
        
    public function store(Request $r){
        //$novoLivro=$r->all();
        //dd($novoLivro);
        if(Gate::allows('admin')){
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
            $autores = $r->id_autor;
            $editoras = $r->id_editora;
        
        if(Auth::check()){
            $userAtual = Auth::user()->id;
            $novoLivro['id_user']=$userAtual;
        }
        
        $livro = Livro::create($novoLivro);
        $livro->autores()->attach($autores);
        $livro->editoras()->attach($editoras);
        
        return redirect()->route('livros.show', [
            'id'=>$livro->id_livro
        ]);
      }
    }
    public function edit(Request $request){
        $idLivro=$request->id;
        $livro = Livro::where('id_livro',$idLivro)->with(['autores','editoras'])->first();
        if (Gate::allows('atualizar.livro',$livro)|| Gate::allows('admin')){
            $autoresLivro =[];
            $editorasLivro =[];
            $generos = Genero::all();
            $autores = Autor::all();
            $editoras = Editora::all();
        foreach($livro->autores as $autor){
            $autoresLivro[] = $autor->id_autor;
        }
        return view('livros.edit',
                    ['generos'=>$generos,              
                     'autores'=>$autores,
                     'editoras'=>$editoras,
                     'autoresLivro'=>$autoresLivro,
                     'editorasLivro'=>$editorasLivro
                    ]);
        }
        else{
            return redirect()->route('livros.index')
                ->with('msg','Não tem permissão para aceder à área pretendida.');
        }
    }
    
    public function update(Request $request){
          $idLivro=$request->id;
          $livro=Livro::where('id_livro',$idLivro)->first();
          if(Gate::allows('admin')){
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
        $editoras=$req->id_editora;
        $autores=$req->id_autor;
        
        $livro->update($atualizarLivro);
        $livro->autores()->sync($autores);
        $livro->editoras()->sync($editoras);
        
        return redirect()->route('livros.show', [
            'id'=>$livro->id_livro
            ]);
        }
    }
    public function delete(Request $r){
        $livro = Livro::where ('id_livro', $r->id)->first();
        if(Gate::allows('admin')){
            if(is_null($livro)){
                return redirect()->route('livros.index')
                    ->with('msg', 'O livro não existe');
        }
        else
        {
          return view('livros.delete',['livro'=>$livro]);  
        }
      }
    }
    public function destroy(Request $r){
        $livro = Livro::where ('id_livro', $r->id)->first();
        if(Gate::allows('admin')){
            $idLivro = $r->id;
            $livro = Livro::findOrFail($idLivro->autores);
            $livro = Livro::findOrFail($idLivro->editoras);
            $livro->autores()->detach($autoresLivro);
            $livro->editoras()->detach($editorasLivro);
        
        $livro->delete();
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
    
    public function likes(request $r){
        $idLivro = $r->id;
        
        $novoLike['id_livro'] = $idLivro;
        $novoLike['id_user'] = auth::user()->id;
            
       
        
    }
    
    
    
}
