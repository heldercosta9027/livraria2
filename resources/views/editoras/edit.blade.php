<form action="{{route('editoras.update',['ide'=>$editora->id_editora])}}"method="post">
@csrf
    @method('patch')
    
Nome: <input type="text" name="nome" value="{{$editora->nome}}" ><br>
@if($errors->has('nome'))
NOME inválido<br><br>
@endif 
    
Morada: <input type="text" name="morada" value="{{$editora->morada}}"><br>
@if($errors->has('morada'))
MORADA inválido<br><br>
@endif
    
Observações: <input type="text" name="observacoes" value="{{$editora->observacoes}}"><br>
@if($errors->has('observacoes'))
Observações inválidas<br><br>
@endif
    
<input type="submit" value="enviar">
</form>