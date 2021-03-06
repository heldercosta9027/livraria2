<form action="{{route('livros.update',['id'=>$livro->id_livro])}}" enctype="multipart/form-data" method="post">
@csrf
    @method('patch')    
    
Título: <input type="text" name="titulo" value="{{$livro->título}}" ><br>
@if($errors->has('titulo'))
TÍTULO inválido<br><br>
@endif 
    
Idioma: <input type="text" name="idioma" value="{{$livro->idioma}}"><br>
@if($errors->has('idioma'))
IDIOMA inválido<br><br>
@endif
    
Total páginas: <input type="text" name="total_paginas" value="{{$livro->total_paginas}}"><br>
@if($errors->has('total_paginas'))
TOTAL PÁGINAS inválido<br><br>
@endif
    
Data Edição: <input type="date" name="data_edicao" value="{{$livro->data_edicao}}"><br>
@if($errors->has('data_edicao'))
DATA EDICAO inválido<br><br>
@endif
    
ISBN: <input type="text" name="isbn" value="{{$livro->isbn}}"><br>
@if($errors->has('isbn'))
Deverá indicar um ISBN correto(13 carateres)<br><br>
@endif
    
Observações: <textarea type="text" name="observacoes">{{$livro->observacoes}}</textarea><br>
    
Imagem_capa: <input type="file" name="imagem_capa" value="{{$livro->imagem_capa}}"><br>
@if($errors->has('imagem_capa'))
IMAGEM CAPA inválida<br><br>
@endif
    
Género: <select name="id_genero">
@foreach ($generos as $genero)
    <option value ="{{$genero->id_genero}}"
        @if($genero->id_genero==$livro->id_genero)selected @endif
        >{{$genero->designacao}}</option>
    @endforeach
    </select>
@if($errors->has('genero'))
GENERO inválido<br><br>
@endif<br>
    
    
    
Autor(es): <select name="id_autor[]" multiple="multiple">
@foreach ($autores as $autor)
<option value="{{$autor->id_autor}}" 
@if(in_array($autor->id_autor,$autoresLivro))selected @endif> 
{{$autor->nome}}
</option> 
@endforeach
</select>   
@if($errors->has('autor'))
AUTOR inválido
@endif
<br>
    
Editoras(as): <select name="id_editora[]" multiple="multiple">
@foreach ($editoras as $editora)
<option value="{{$editora->id_editora}}">{{$editora->nome}}</option> 
@endforeach
</select>   
@if($errors->has('editora'))
Editora inválida
@endif
<br>  
    
Sinopse: <textarea type="text" name="sinopse">{{$livro->sinopse}}</textarea><br>

Sinopse(ficheiro PDF): <input type="file" name="ficheiro_sinopse" value="{{$livro->ficheiro_sinopse}}"><br>
@if($errors->has('ficheiro_sinopse'))
FICHEIRO PDF inválido<br><br>
@endif
    
<input type="submit" value="enviar">
</form>