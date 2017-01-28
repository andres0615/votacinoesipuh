@extends('admin.main')

@section('assets2')
    <script src="{{ asset('javascripts/admin/persona/validate-form.js') }}" ></script>
@endsection('assets2')

@section('content2')
<div class="panel panel-custom-admin">
    <div class="panel-heading">
        <h3 class="panel-title" >{{ $title }}</h3>
    </div>
    <div class="panel-body">
        {{-- <form role="form" method="post" action="{{ $action }}" id="form" name="form" novalidate > --}}
            @if(isset($persona))
            {!! Form::model($persona, ['route' => ['admin.persona.update',$id], 'class' => 'form', 'files' => true, 'novalidate' => 'novalidate']) !!}
            @else
            {!! Form::open(['route' => 'admin.persona.store', 'class' => 'form', 'files' => true, 'novalidate' => 'novalidate', 'id' => "form"]) !!}
            @endif
            <div class="row">
                <div class="col-lg-6 col-md-6 col-md-12 col-xs-12">
                    <div class="form-group">
                        <label for="persona_nombre">Nombre:</label>
                        {!! Form::input('text', 'persona_nombre', null, ['class'=> 'form-control', 'id' => "persona_nombre"]) !!}
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-md-12 col-xs-12">
                    <div class="form-group">
                        <label for="persona_apellido">Apellido:</label>
                        {!! Form::input('text', 'persona_apellido', null, ['class'=> 'form-control', 'id' => "persona_apellido"]) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-md-12 col-xs-12">
                    <div class="form-group">
                        <label for="persona_nombre">Foto:</label>
                        {!! Form::file('persona_foto',  ['class'=> 'form-control', 'id' => "persona_foto"]) !!}
                        @if(isset($persona))
                            @if($persona->persona_foto != null)
                                <div class="thumbnail">
                                    <img src="{{ asset($persona->persona_foto) }}" class="img-thumbnail">
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-md-12 col-xs-12">
                    <div class="form-group">
                        <label for="persona_codigo_alterno">Codigo alterno:</label>
                        {!! Form::input('text', 'persona_codigo_alterno', null, ['class'=> 'form-control', 'id' => "persona_codigo_alterno"]) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-md-12 col-xs-12">
                    <div class="form-group">
                        <label for="tipo_persona_id">Tipo persona:</label>
                        {!! Form::select('tipo_persona_id', $tipos_persona, null, ['id' =>'tipo_persona_id', 'class' => 'form-control fc-input']) !!}
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-md-12 col-xs-12">
                    <div class="form-group">
                        <label>Activa:</label>
                        {!! Form::input('checkbox', 'persona_activa', null, ['id' => 'persona_activa', 'class'=> 'form-control', $activo]) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-md-12 col-xs-12">
                    <div class="form-group">
                        <label>Ingreso:</label>
                        {!! Form::input('checkbox', 'persona_ingreso', null, ['id' => 'persona_ingreso', 'class'=> 'form-control', $ingreso]) !!}
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
                    @endif
                </div>
            </div>
        {!! Form::close() !!}
        {{-- <div class="d-block">
            <a href="" id="submit" class="btn cbtn-default">Crear</a>
        </div> --}}
    </div>
</div>

@endsection('content2')