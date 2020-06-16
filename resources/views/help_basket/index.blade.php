@extends('layouts.app')

@section('title', 'Listado de Entregas de Canastas')
@section('content')
@include('help_basket.nav')

<h3 class="mb-3">Listado de Canasta Entregadas {{$institution->name}}</h3>
<div class="row">
    <div class="col-4 col-md-2">
    <a class="btn btn-primary mb-3" href="{{ route('help_basket.create') }}?institution={{$institution->id}}">
        Entregar Canasta {{$institution->name}}
    </a>
    </div>

    <div class="col-7 col-md-6" role="alert">
        <form method="GET" class="form-horizontal" action="{{ route('help_basket.index',$institution) }}">

            <div class="input-group">
                <input type="text" class="form-control" name="search" id="for_search"
                    placeholder="Nombre o Apellido o Rut" >
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit" id="button-addon">Buscar</button>
                </div>
            </div>

        </form>
    </div>
</div>

<div class="table-responsive">
<table class="table table-sm table-bordered">
    <thead>
        <tr>
            <th>Run o (ID)</th>
            <th>Nombre Completo</th>
            <th>Dirección</th>
            <th>Comuna</th>
            <th>Fono</th>
            <th>Entregado Por</th>
            <th>Entregado el</th>
            <th>Cédula</th>
            <th>Foto</th>
            <th>Editar</th>            
            <th>Eliminar</th>
        </tr>
    </thead>

    <tbody id="tablePatients">
        @foreach($helpbaskets as $helpBasket)
        <tr>
            <td>{{$helpBasket->identifier}}</td>
            <td>{{$helpBasket->fullName}}</td>
            <td>{{$helpBasket->address}} {{$helpBasket->number}} {{$helpBasket->department}} </td>
            <td>{{$helpBasket->commune->name}}</td>
            <td>{{$helpBasket->telephone}}</td>
            <td>{{$helpBasket->user->name}}</td>
            <td>{{$helpBasket->updated_at->format('d-m-Y H:i')}}</td>
            <td>@if($helpBasket->photoid)                
                <img src="{{ route('help_basket.download', $helpBasket->photoid)  }}" width="150" height="100" />
                @endif
            </td>
            <td>@if($helpBasket->photo)
                <img src="{{ route('help_basket.download', $helpBasket->photo)  }}" width="150" height="100" />
                @endif
            </td>
            <td>
                @if($helpBasket->user_id == Auth::id() or Auth::id() == 5)
                <a href="{{ route('help_basket.edit', $helpBasket) }}" class="btn btn-secondary float-left"><i class="fas fa-edit"></i></a>
                @endif
            </td>
            <td>
                @if($helpBasket->user_id == Auth::id())
                    <form method="POST" class="form-horizontal" action="{{ route('help_basket.destroy',$helpBasket) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger float-left" onclick="return confirm('¿Está seguro que desea eliminar la entrega de canasta a : {{$helpBasket->fullName}}? ' )"><i class="fas fa-trash-alt"></i></button>
                    </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>

{{ $helpbaskets->links() }}

@endsection

@section('custom_js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>



<script type="text/javascript">
$(document).ready(function(){
    $("main").removeClass("container");

    $("#inputSearch").on("keyup", function() {
        alert('entre');
        var value = $(this).val().toLowerCase();
        $("#tablePatients tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
</script>

@endsection