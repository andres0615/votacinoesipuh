@extends('main')

@section('content')
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