<form action="{{route('editoras.store')}}"method="post">
@csrf
    
Nome: <input type="text" name="nome" value="{{old('nome')}}" ><br>
@if($errors->has('nome'))
NOME inválido<br><br>
@endif 
    
Morada: <input type="text" name="morada" value="{{old('morada')}}"><br>
@if($errors->has('morada'))
MORADA inválido<br><br>
@endif
    
Observações: <input type="text" name="observacoes" value="{{old('observacoes')}}"><br>
@if($errors->has('observacoes'))
Observações inválidas<br><br>
@endif
    
<input type="submit" value="enviar">
</form>