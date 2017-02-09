@extends('admin.persona.profile')

@section('votacionui')

<div class="panel panel-custom-admin">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-cogs"></i> Eleccion: {{ $eleccion->eleccion_nombre }}</h3>
    </div>
    <div class="panel-body">
        <div class="list-group">
            <form role="form" method="post" action="{{-- route('') --}}" id="form" name="form" novalidate >
            @foreach($candidatos as $candidato)
                <div class="list-group-item">
                    <input type="radio" name="candidato_id" value="{{ $candidato->persona_id }}" />
                    {{ $candidato->persona_nombre }}
                </div>
            @endforeach
            <input type="hidden" name="votacion_id" >
            {{ Form::token() }}
            </form>
        </div>
    </div>
</div>

@endsection('votacionui')