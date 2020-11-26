<form action="{{route('generos.store')}}"method="post">
@csrf
    
Designacao: <input type="text" name="designacao" value="{{old('designacao')}}" ><br>
@if($errors->has('designacao'))
DESIGNAÇÃO inválido<br><br>
@endif 
    
Observações: <input type="text" name="observacoes" value="{{old('observacoes')}}"><br>
@if($errors->has('observacoes'))
Observações inválidas<br><br>
@endif
    
<input type="submit" value="enviar">
</form>