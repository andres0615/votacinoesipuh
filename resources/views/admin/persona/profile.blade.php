@extends('main')

@section('assets')
    @yield('assets2')
@endsection('assets')

@section('content')
<div id="confirm-modal" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="panel panel-custom-modal">
                <div class="panel-heading">
                    <h3 class="panel-title">Confirmar</h3>
                </div>
                <div class="panel-body">
                    <div class="d-block">
                        <p id="mensaje-confirmar-eliminar" class="text-center" ></p>
                    </div>
                    <div class="d-block text-center" id="confirm-buttons" >
                        <button type="button" id="confirmar-si" class="btn cbtn-default" >Si</button>
                        <button type="button" id="confirmar-no" class="btn cbtn-default" >No</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        {{-- @include('flash::message') --}}
        @if(session()->has('flash_notification.message'))
            <div class="alert alert-{{ session('flash_notification.level') }} alert-dismissable">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                {!! session('flash_notification.message') !!}
            </div>
        @endif

        @yield('content2')
    </div>
</div>

<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-4 col-xs-3"></div>
                    <div class="col-lg-12 col-md-12 col-sm-4 col-xs-6">
                        <img src="{{ asset(Auth::guard('persona')->user()->persona_foto) }}" alt="Imagen de perfil" class="img-thumbnail custom-profile-img" />
                    </div>
                    <div class="col-sm-4 col-xs-3"></div>
                </div>
            </div>

            <div class="list-group">
                <a href="{{ route('inicio') }}" class="list-group-item {{ (Request::route()->getName() == 'inicio')?'active':'' }}">Elecciones</a>
                <a href="{{ route('profile') }}" class="list-group-item {{ (Request::route()->getName() == 'profile')?'active':'' }}">Ajustes</a>
                @if(Auth::guard('persona')->user()->tipo_persona_id == 6)
                <a href="{{ route('admin.persona.index') }}" class="list-group-item">Panel de administracion</a>
                @endif
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
        @yield('personamenu')
        @yield('votacionui')
    </div>
</div>

@endsection('content')