<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
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
                'imagem_capa'=>['image','nullable', 'max:2000'],
                'id_genero'=>['numeric', 'nullable'],
                'id_autor'=>['numeric','nullable'],
                'sinopse'=>['nullable', 'min:3', 'max:255'],
                'ficheiro_sinopse'=>['file','mimes:pdf','max:2000']
        ]);
            
        if($r->hasFile('imagem_capa')){
             $nomeImagem = $r->file('imagem_capa')->getClientOriginalName();
             $nomeImagem = time(). '_' .$nomeImagem; 
             $guardarImagem=$r->file('imagem_capa')->storeAs('imagem/livros',$nomeImagem);
             
             
             $novoLivro['imagem_capa'] = $nomeImagem;
         }
        
        if($r->hasFile('ficheiro_sinopse')){
         $nomeFicherio = $r->file('ficheiro_sinopse')->getClientOriginalName();
         $nomeFicheiro = time(). '_' .$nomeFicheiro; 
         $guardarFicheiro=$r->file('ficehiro_sinopse')->storeAs('ficheirosPdf/livros',$nomeFicheiros);
             
             
             $novoLivro['ficehiro_sinopse'] = $nomeFicheiro;
         }
           
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
                     'editorasLivro'=>$editorasLivro,
                     'livro'=>$livro
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
          $imagemAntiga = $livro->imagem_capa;
          if(Gate::allows('admin')){
            $atualizarLivro = $request->validate([
                'titulo'=>['required', 'min:3','max:100'],
                'idioma'=>['nullable', 'min:3', 'max:20'],
                'total_paginas'=>['nullable', 'numeric', 'min:1'],
                'data_edicao'=>['nullable','date'],
                'isbn'=>['required', 'min:1', 'max:13'],
                'observacoes'=>['nullable', 'min:1', 'max:255'],
                'imagem_capa'=>['image','nullable', 'max:2000'],
                'id_genero'=>['numeric', 'nullable'],
                'id_autor'=>['numeric','nullable'],
                'sinopse'=>['nullable', 'min:3', 'max:255'],
                'ficheiro_sinopse'=>['file','mimes:pdf','max:2000']
                
        ]);
        
        if($request->hasFile('imagem_capa')){
             $nomeImagem = $request->file('imagem_capa')->getClientOriginalName();
             $nomeImagem = time(). '_' .$nomeImagem; 
             $guardarImagem=$request->file('imagem_capa')->storeAs('imagem/livros',$nomeImagem);
             
             if(!is_null($imagemAntiga)){
                 Storage::Delete('imagem/livros/'.$imagemAntiga);
             }
             
             $atualizarLivro['imagem_capa'] = $nomeImagem;
         }   
              
        if($request->hasFile('ficheiro_sinopse')){
             $nomeFicheiro = $request->file('ficheiro_sinopse')->getClientOriginalName();
             $nomeFicheiro = time(). '_' .$nomeFicheiro; 
             $guardarFicheiro=$request->file('ficheiro_sinopse')->storeAs('ficheiroPdf/livros',$nomeFicheiro);
             
             if(!is_null($FicheiroAntigo)){
                 Storage::Delete('ficheiroPdf/livros/'.$FicheiroAntigo);
             }
             
             $atualizarLivro['ficheiro_sinopse'] = $nomeFicheiro;
         }
              
        $editoras=$request->id_editora;
        $autores=$request->id_autor;
        
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
