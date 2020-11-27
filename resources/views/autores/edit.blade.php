<form action="{{route('autores.update',['ida'=>$autor->id_autor])}}"method="post">
@csrf
    @method('patch')
    
Nome: <input type="text" name="nome" value="{{$autor->nome}}" ><br>
@if($errors->has('nome'))
NOME inválido<br><br>
@endif 
    
Nacionalidade: <input type="text" name="nacionalidade" value="{{$autor->nacionalidade}}"><br>
@if($errors->has('nacionalidade'))
NACIONALIDADE inválido<br><br>
@endif
    
Data de Nascimento: <input type="date" name="data_nacionalidade" value="{{$autor->data_nascimento}}"><br>
@if($errors->has('data_nacionalidade'))
DATA DE NASCIMENTO inválido<br><br>
@endif
    
Fotografia: <input type="text" name="data_edicao" value="{{$autor->fotografia}}"><br>
@if($errors->has('fotografia'))
FOTOGRAFIA inválido<br><br>
@endif
  
<input type="submit" value="enviar">
</form>