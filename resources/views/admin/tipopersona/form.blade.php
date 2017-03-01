@extends('admin.main')

@section('assets2')
    <script src="{{ asset('javascripts/admin/tipopersona/validate-form.js') }}" ></script>
@endsection('assets2')

@section('content2')
<div class="panel panel-custom-admin">
    <div class="panel-heading">
        <h3 class="panel-title" >{{ $title }}</h3>
    </div>
    <div class="panel-body">
        {{-- <form role="form" method="post" action="{{ $action }}" id="form" name="form" novalidate > --}}
            @if(isset($tipo_persona))
            {!! Form::model($tipo_persona, ['route' => ['admin.tipopersona.update',$id], 'class' => 'form', 'files' => true, 'novalidate' => 'novalidate', 'id' => "form"]) !!}
            @else
            {!! Form::open(['route' => 'admin.tipopersona.store', 'class' => 'form', 'files' => true, 'novalidate' => 'novalidate', 'id' => "form"]) !!}
            @endif
            <div class="row">
                <div class="col-lg-6 col-md-6 col-md-12 col-xs-12">
                    <div class="form-group">
                        <label for="tipo_persona_nombre">Nombre:</label>
                        {!! Form::input('text', 'tipo_persona_nombre', null, ['class'=> 'form-control', 'id' => "tipo_persona_nombre"]) !!}
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-md-12 col-xs-12">
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