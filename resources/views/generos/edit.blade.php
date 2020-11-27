<form action="{{route('generos.update',['idg'=>$genero->id_genero])}}"method="post">
@csrf
      @method('patch')
Designacao: <input type="text" name="designacao" value="{{$genero->designacao}}" ><br>
@if($errors->has('designacao'))
DESIGNAÇÃO inválido<br><br>
@endif 
    
Observações: <input type="text" name="observacoes" value="{{$genero->observacoes}}"><br>
@if($errors->has('observacoes'))
Observações inválidas<br><br>
@endif
    
<input type="submit" value="enviar">
</form>