@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if(session()->has('flash_notification.message'))
                <div class="alert alert-{{ session('flash_notification.level') }} alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {!! session('flash_notification.message') !!}
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Recodrdar contraseña</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('forgetpassword.proccess') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <div class="col-lg-2 col-md-2 col-md-4 col-xs-12" ></div>
                            <div class="col-lg-8 col-md-8 col-md-5 col-xs-12 " >
                                Ingresa tu numero de identificacion y te enviaremos la contraseña a tu correo, si no te llega el correo revisa la bandeja spam.
                            </div>
                            
                        </div>

                        <div class="form-group">
                            <label for="persona_identificacion" class="col-md-4 control-label">Identificacion</label>

                            <div class="col-md-6">
                                <input id="persona_identificacion" type="text" class="form-control" name="persona_identificacion" value="{{ old('persona_identificacion') }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <input type="submit" class="btn btn-primary" value="Enviar contraseña" />
                                <a href="{{ route('login') }}" class="btn btn-primary" >Volver</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
