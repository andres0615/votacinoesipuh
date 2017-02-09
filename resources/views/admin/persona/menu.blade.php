@extends('admin.persona.profile')

@section('personamenu')

    <div class="panel panel-custom-admin">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-cogs"></i> Elecciones disponibles</h3>
        </div>
        <div class="panel-body">
            <div class="list-group">
                @if(isset($elecciones))
                    @foreach($elecciones as $eleccion)
                        <a href="{{ route('uieleccion',["eleccion_codigo" => $eleccion->eleccion_id]) }}" class="list-group-item">{{ $eleccion->eleccion_nombre }}</a>
                    @endforeach
                @else
                    <h5 style="width: 100%; text-align: center;" >No hay votaciones disponibles</h5>
                @endif
            </div>
        </div>
    </div>

@endsection('personamenu')