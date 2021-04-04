@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{ url('/serie/'.$serie->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        {{ method_field('PATCH') }}
        

<h1>Editar serie</h1>
@if(count($errors)>0)


<div class="alert alert-danger" role="alert">
    <ul>
        @foreach( $errors->all() as $error)
        <li> {{ $error }} </li>
        @endforeach

    </ul>
</div>


@endif
<div class="form-group">

    <label for="Nombre">Nombre:</label>
    <input class="form-control" type="text" name="Nombre" 
    value="{{ isset($serie->nombre)?$serie->nombre:old('nombre') }}" id="Nombre">

</div>
<div class="form-group">
    <label for="Categoria">Categoria:</label>
    <select class="form-control" name="Categoria" id="Categoria" >
        @foreach($categorias as $categoria)
            <option value="{{ $categoria->id }}" @if($categoria->id == $serie->categorias_id ) selected="selected" @endif  >{{ $categoria->Nombre }}</option>
        @endforeach
        
    </select>
    

</div>



<input class="btn btn-success" type="submit" value="Guardar">
<a class="btn btn-primary" href="{{ url('serie/') }}"> Atrás</a>
    </form>

</div>
@endsection