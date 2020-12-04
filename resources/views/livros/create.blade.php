<form action="{{route('livros.store')}}"method="post">
@csrf
    
Título: <input type="text" name="titulo" value="{{old('titulo')}}" ><br>
@if($errors->has('titulo'))
TÍTULO inválido<br><br>
@endif 
    
Idioma: <input type="text" name="idioma" value="{{old('idioma')}}"><br>
@if($errors->has('idioma'))
IDIOMA inválido<br><br>
@endif
    
Total páginas: <input type="text" name="total_paginas" value="{{old('total_paginas')}}"><br>
@if($errors->has('total_paginas'))
TOTAL PÁGINAS inválido<br><br>
@endif
    
Data Edição: <input type="date" name="data_edicao" value="{{old('data_edicao')}}"><br>
@if($errors->has('data_edicao'))
DATA EDICAO inválido<br><br>
@endif
    
ISBN: <input type="text" name="isbn" value="{{old('isbn')}}"><br>
@if($errors->has('isbn'))
Deverá indicar um ISBN correto(13 carateres)<br><br>
@endif
    
Observações: <textarea type="text" name="observacoes"></textarea><br>
Imagem_capa: <input type="text" name="imagem_capa" value="{{old('imagem_capa')}}"><br>
@if($errors->has('imagem_capa'))
IMAGEM CAPA inválida<br><br>
@endif
    
Género: <select name="id_genero">
@foreach ($generos as $genero)
    <option value ="{{$genero->id_genero}}">{{$genero->designacao}}</option>
@endforeach
</select>
@if($errors->has('genero'))
GENERO inválido<br><br>
@endif<br>
    
Autor(es): <select name="id_autor[]" multiple="multiple">
@foreach ($autores as $autor)
<option value="{{$autor->id_autor}}">{{$autor->nome}}</option> 
@endforeach
</select>   
@if($errors->has('autor'))
AUTOR inválido
@endif
<br>   
Sinopse: <textarea type="text" name="sinopse"></textarea><br>
    
Editoras(as): <select name="id_editora[]" multiple="multiple">
@foreach ($editoras as $editora)
<option value="{{$editora->id_editora}}">{{$editora->nome}}</option> 
@endforeach
</select>   
@if($errors->has('editora'))
Editora inválida
@endif
<br>  
    
Sinopse: <textarea type="text" name="sinopse"></textarea><br>
    
<input type="submit" value="enviar">
</form>