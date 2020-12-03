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
            return view('autores.create');
        }
    public function store(Request $r){
        //$novoLivro=$r->all();
        //dd($novoLivro);
        
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
    public function edit(Request $request){
         $idAutor=$request->ida;
        
        $autor=Autor::where('id_autor', $idAutor)->first();
        
        return view('autores.edit', [
            'autor'=>$autor
        ]);
    }
    
    public function update(Request $request){
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
