@extends('main')

@section('assets')
    <script src="{{ asset('javascripts/admin/main.js') }}" ></script>
    @yield('assets2')
@endsection('assets')

@section('content')
    <div id="delete-modal" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
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
                        <form method="post" class="d-block text-center" id="confirmar-eliminar-si">
                            <button type="submit" class="btn cbtn-default" >Si</button>
                            <button type="button" id="confirmar-eliminar-no" class="btn cbtn-default" >No</button>
                            {{ Form::token() }}
                            <div class="hidden" id="adittional-inputs" ></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-3 visible-lg visible-md">
            <div class="panel panel-custom">
                <div class="panel-heading">
                    <h3 class="panel-title">Modulos</h3>
                </div>
                <div class="list-group">
                    <a href="{{ route('admin.persona.index') }}" class="list-group-item">Persona</a>
                    <a href="{{ route('admin.tipopersona.index') }}" class="list-group-item">Tipo persona</a>
                    <a href="{{ route('admin.eleccion.index') }}" class="list-group-item">Eleccion</a>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-xs-12 visible-sm visible-xs">
            <div class="panel panel-custom">
                <div class="panel-heading">
                    <h3 class="panel-title">Modulo</h3>
                </div>
                <div class="panel-body">
                    <div class="d-block spacer">
                        <select class="form-control" id="modulo-select" >
                            <option value="{{ route('admin.persona.index') }}" >Persona</option>
                            <option value="{{ route('admin.tipopersona.index') }}" >Tipo persona</option>
                            <option value="{{ route('admin.eleccion.index') }}" >Eleccion</option>
                        </select>
                    </div>
                    <div class="d-block">
                        <a href="" class="btn cbtn-default btn-block" id="ir-modulo" >Ir</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
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
@endsection('content')