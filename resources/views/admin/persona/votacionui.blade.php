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
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-md-12 col-xs-12">
                            <input type="radio" name="candidato_id" value="{{ $candidato->persona_id }}" />
                            {{ $candidato->persona_nombre }}
                        </div>
                        <div class="col-lg-6 col-md-6 col-md-12 col-xs-12">
                            @if($candidato->persona_foto != null)
                                <div class="thumbnail">
                                    <img src="{{ asset($candidato->persona_foto) }}" class="img-thumbnail">
                                </div>
                            @endif
                        </div>
                    </div>
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