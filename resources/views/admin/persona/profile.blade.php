@extends('main')

@section('content')

<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-4 col-xs-3"></div>
                    <div class="col-lg-12 col-md-12 col-sm-4 col-xs-6">
                        <img src="{{ asset('img/default_user.png') }}" alt="Imagen de perfil" class="img-thumbnail custom-profile-img" />
                    </div>
                    <div class="col-sm-4 col-xs-3"></div>
                </div>
            </div>

            <div class="list-group">
                <a href="{{ route('admin.persona.index') }}" class="list-group-item">Panel de administracion</a>
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
        @yield('personamenu')
        @yield('votacionui')
    </div>
</div>

@endsection('content')