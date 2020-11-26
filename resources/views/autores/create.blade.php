<form action="{{route('autores.store')}}"method="post">
@csrf
    
Nome: <input type="text" name="nome" value="{{old('nome')}}" ><br>
@if($errors->has('nome'))
NOME inválido<br><br>
@endif 
    
Nacionalidade: <input type="text" name="nacionalidade" value="{{old('nacionalidade')}}"><br>
@if($errors->has('nacionalidade'))
NACIONALIDADE inválido<br><br>
@endif
    
Data de Nascimento: <input type="date" name="data_nacionalidade" value="{{old('data_nacionalidade')}}"><br>
@if($errors->has('data_nacionalidade'))
DATA DE NASCIMENTO inválido<br><br>
@endif
    
Fotografia: <input type="text" name="data_edicao" value="{{old('fotografia')}}"><br>
@if($errors->has('fotografia'))
FOTOGRAFIA inválido<br><br>
@endif
  
<input type="submit" value="enviar">
</form>