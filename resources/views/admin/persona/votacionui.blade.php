@extends('admin.persona.profile')

@section('assets2')
    <script src="{{ asset('javascripts/admin/persona/votacionui.js') }}" ></script>
@endsection('assets2')

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
                            <input type="radio" name="candidato_id" value="{{ $candidato->persona_id }}" class="candidato_input" />
                            <label>
                            {{ $candidato->persona_nombre }} {{ $candidato->persona_apellido }}
                            </label>
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
        <button type="button" class="btn cbtn-default hidden-xs" data-toggle="modal" data-target="#confirm-modal" {{-- data-href="{{ route('admin.persona.destroy',['id' => $persona->persona_id]) }}" --}} >Votar</button>
        <button type="button" class="btn cbtn-default visible-xs btn-block" data-toggle="modal" data-target="#confirm-modal" {{-- data-href="{{ route('admin.persona.destroy',['id' => $persona->persona_id]) }}" --}} >Votar</button>                                    
        </form>
    </div>
</div>

@endsection('votacionui')