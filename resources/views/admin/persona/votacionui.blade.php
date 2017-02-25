@extends('admin.persona.profile')

@section('votacionui')

<div class="panel panel-custom-admin">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-cogs"></i> Eleccion: {{ $eleccion->eleccion_nombre }}</h3>
    </div>
    <div class="panel-body">
    <form role="form" method="post" action="{{ route('admin.votacion.store') }}" id="form" name="form" novalidate >
        <div class="list-group">
            @foreach($candidatos as $candidato)
                <div class="list-group-item">
                    <input type="radio" name="candidato_id" value="{{ $candidato->persona_id }}" />
                    {{ $candidato->persona_nombre }}
                </div>
            @endforeach
            <input type="hidden" name="eleccion_id" value="{{ $eleccion->eleccion_id }}" >
            {{ Form::token() }}
        </div>
        <input type="submit" value="Votar" class="btn cbtn-default hidden-xs" />
                    <input type="submit" value="Votar" class="btn cbtn-default btn-block visible-xs" />
        </form>
    </div>
</div>

@endsection('votacionui')