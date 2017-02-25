@extends('admin.main')

@section('assets2')
    <script src="{{ asset('javascripts/admin/eleccion/validate-form.js') }}" ></script>
    <script src="{{ asset('js/bootstrap-multiselect.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/bootstrap-multiselect.css') }}">
@endsection('assets2')

@section('content2')
<div class="panel panel-custom-admin">
    <div class="panel-heading">
        <h3 class="panel-title" >{{ $title }}</h3>
    </div>
    <div class="panel-body">
        {{-- <form role="form" method="post" action="{{ $action }}" id="form" name="form" novalidate > --}}
            @if(isset($eleccion))
            {!! Form::model($eleccion, ['route' => ['admin.eleccion.update',$id], 'class' => 'form', 'files' => true, 'novalidate' => 'novalidate']) !!}
            @else
            {!! Form::open(['route' => 'admin.eleccion.store', 'class' => 'form', 'files' => true, 'novalidate' => 'novalidate', 'id' => "form"]) !!}
            @endif
            <div class="row">
                <div class="col-lg-6 col-md-6 col-md-12 col-xs-12">
                    <div class="form-group">
                        <label for="persona_nombre">Nombre:</label>
                        {!! Form::input('text', 'eleccion_nombre', null, ['class'=> 'form-control', 'id' => "persona_nombre"]) !!}
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-md-12 col-xs-12">
                    <div class="form-group">
                        <label>Activa:</label>
                        {!! Form::input('checkbox', 'eleccion_activa', null, ['id' => 'eleccion_activa', 'class'=> 'form-control', $activo]) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-md-12 col-xs-12">
                    <div class="form-group">
                        <label for="persona_nombre">Candidatos:</label>
                        <select id="candidatos-select" multiple="multiple" >
                            @foreach($candidatos as $candidato)
                                <option value="{{ $candidato->persona_id }}">{{ $candidato->persona_nombre }}</option>
                            @endforeach
                        </select>
                        <div id="candidatos">
                            @if($edit == true)
                                @foreach($candidatos_elegidos as $candidato_id)
                                    <input type="hidden" value="{{ $candidato_id }}" name="candidatos[]" />
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input type="submit" value="Grabar" class="btn cbtn-default hidden-xs" />
                    <input type="submit" value="Grabar" class="btn cbtn-default btn-block visible-xs" />
                    {{ Form::token() }}
                    @if($edit)
                        <input type="hidden" name="_method" value="put" />
                        <a href="{{ route('admin.eleccion.reporte', ['eleccion_id' => $id]) }}" class="btn cbtn-default">Generar reporte</a>
                    @endif
                </div>
            </div>
        {!! Form::close() !!}
        {{-- <div class="d-block">
            <a href="" id="submit" class="btn cbtn-default">Crear</a>
        </div> --}}
    </div>
</div>

<br>

@if($edit == true)

<div class="panel panel-custom-admin">
    <div class="panel-heading">
        <h3 class="panel-title" >Resultados</h3>
    </div>
    <div class="panel-body">
        <table class="table">
        <thead>
          <tr>
            <th>Puesto</th>
            <th>Nombre</th>
            <th>Candtidad de votos</th>
          </tr>
        </thead>
        <tbody>
        @foreach($resultados as $key => $resultado)
          <tr>
            <td>{{ ($key>0)?(($resultados[$key-1]->votos == $resultado->votos)?$count:++$count):++$count  }}</td>
            <td>{{ $resultado->persona_nombre }}</td>
            <td>{{ $resultado->votos }}</td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
</div>

@endif

<script type="text/javascript">
    $(document).ready(function() {
        $('#candidatos-select').multiselect({
            onChange: function(element, checked) {
                if(checked == true){
                    var old_el = $('input[name="candidatos[]"][value="'+element.attr('value')+'"]');

                    if(old_el.length > 0){
                        old_el.remove();
                    }

                    var input = '<input type="hidden" value="'+element.attr('value')+'" name="candidatos[]" />';
                    $('#candidatos').append(input);
                } else {
                    var old_el = $('input[name="candidatos[]"][value="'+element.attr('value')+'"]');

                    if(old_el.length > 0){
                        old_el.remove();
                    }
                }
            }
        });

        @if($edit == true)
        $('#candidatos-select').multiselect('select', [
            @foreach($candidatos_elegidos as $candidato_id)
                {{ $candidato_id }},
            @endforeach
                    ]);
        @endif

    });
</script>

@endsection('content2')