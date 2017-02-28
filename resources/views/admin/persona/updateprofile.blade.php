@extends('admin.persona.profile')

@section('votacionui')

<div class="panel panel-custom-admin">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-cogs"></i> Actualizar datos</h3>
    </div>
    <div class="panel-body">
    <form role="form" method="post" action="{{ route('profile.update') }}" id="form" name="form" novalidate >
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="persona_codigo_alterno">Nueva contraseña:</label>
                    {!! Form::input('password', 'persona_codigo_alterno', null, ['class'=> 'form-control', 'id' => "persona_codigo_alterno"]) !!}
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="persona_codigo_alterno">Confirmar nueva contraseña:</label>
                    {!! Form::input('password', 'persona_codigo_alterno_confirm', null, ['class'=> 'form-control', 'id' => "persona_codigo_alterno_confirm"]) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-md-6 col-md-12 col-xs-12">
                <div class="form-group">
                    <label for="persona_nombre">Foto:</label>
                    {!! Form::file('persona_foto',  ['class'=> 'form-control', 'id' => "persona_foto"]) !!}
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-md-12 col-xs-12">
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <input type="submit" value="Grabar" class="btn cbtn-default hidden-xs" />
                    <input type="submit" value="Grabar" class="btn cbtn-default btn-block visible-xs" />
            </div>
        </div>
        </form>
    </div>
</div>

@endsection('votacionui')