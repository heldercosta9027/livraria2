<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Autor;

class AutoresController extends Controller
{
    //
    public function index(){
        //$autores = Autor::all()->sortbydesc('idl');
        $autores= Autor::paginate(4);
        return view('autores.index',[
            'autores'=>$autores
        ]);
    }
    public function show(Request $request){
        $idAutores = $request->ida;
        //$autores=Autor::findOrFail($idAutores);
        //$autores=Autor::find($idAutores);
        $autores=Autor::where('id_autor',$idAutores)->with('livros')->first();
        return view('autores.show',[
            'autores'=>$autores
        ]);
    }
    
    public function create(){
        if(Gate::allows('admin')){
            return view('autores.create');
        }
    }
    public function store(Request $r){
        //$novoLivro=$r->all();
        //dd($novoLivro);
        if(Gate::allows('admin')){
        $novoAutor = $r->validate([
            'nome'=>['required', 'min:3','max:100'],
            'nacionalidade'=>['nullable', 'min:3', 'max:20'],
            'data_nascimento'=>['nullable','date'],
            'fotografia'=>['nullable', 'min:1', 'max:255']
        ]);
        $autor = Autor::create($novoAutor);
        
        
        return redirect()->route('autores.show', [
            'ida'=>$autor->id_autor
        ]);
        }
    }
    public function edit(Request $request){
        if(Gate::allows('admin')){
        $idAutor=$request->ida;
        $autor=Autor::where('id_autor', $idAutor)->first();
        return view('autores.edit', [
            'autor'=>$autor
        ]);
      }
    }
    
    public function update(Request $request){
        if(Gate::allows('admin')){
          $idAutor=$request->ida;
          $autor=Autor::where('id_autor',$idAutor)->first();
          $atualizarAutor = $request->validate([
            'nome'=>['required', 'min:3','max:100'],
            'nacionalidade'=>['nullable', 'min:3', 'max:20'],
            'data_nascimento'=>['nullable','date'],
            'fotografia'=>['nullable', 'min:1', 'max:255']
        ]);
        $autor->update($atualizarAutor);
        return redirect()->route('autores.show', [
            'ida'=>$autor->id_autor
            ]);
        }
    }
    public function delete(Request $r){
        $autor = Autor::where ('id_autor', $r->ida)->first();
        if(Gate::allows('admin')){
        if(is_null($autor)){
            return redirect()->route('autores.index')
                ->with('msg', 'O autor não existe');
        }
        else
        {
          return view('autores.delete',['autor'=>$autor]);  
        }
      }
    }
    public function destroy(Request $r){
        $autor = Autor::where ('id_autor', $r->ida)->first();
        if(Gate::allows('admin')){
        if(is_null($autor)){
            return redirect()->route('autores.index')
                ->with('msg', 'O autor não existe');
        }
        else
        {
            $autor->delete();
            return redirect()->route('autores.index')->with('msg','Autor eliminado!');
            
        }
      }
    }
    
        
}
