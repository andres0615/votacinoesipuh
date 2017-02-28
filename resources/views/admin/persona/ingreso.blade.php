@extends('main')

@section('assets')
    <script src="{{ asset('js/admin/aux.js') }}" ></script>
@endsection('assets')

@section('content')

<div class="row">
	<div class="col-lg-2 col-md-2 col-md-12 col-xs-12"></div>
	<div class="col-lg-8 col-md-8 col-md-12 col-xs-12">
	@if(session()->has('flash_notification.message'))
        <div class="alert alert-{{ session('flash_notification.level') }} alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {!! session('flash_notification.message') !!}
        </div>
    @endif
    </div>
    <div class="col-lg-2 col-md-2 col-md-12 col-xs-12"></div>
</div>

<div class="row">
    <div class="col-lg-2 col-md-2 col-md-12 col-xs-12"></div>
    <div class="col-lg-8 col-md-8 col-md-12 col-xs-12">
    	<div class="panel panel-custom-admin">
    		<div class="panel-heading">
	            <h3 class="panel-title">Ingreso de persona</h3>
	        </div>
    		<div class="panel-body">
    			<form method="post" action="{{ route('admin.persona.ingreso.proccess') }}" >
	            <div class="row">
	            	<div class="col-lg-6 col-md-6 col-md-12 col-xs-12">
	            		<div class="form-group">
                        <label for="persona_nombre">Identificacion:</label>
                        <input type="text" name="persona_identificacion" class="form-control" id="persona_identificacion" />
                    </div>
	            	</div>
	            	<div class="col-lg-6 col-md-6 col-md-12 col-xs-12">
	            		<div class="form-group">
                        <label for="persona_nombre">Ingreso:</label>
                        <input type="checkbox" id="persona_ingreso" name="persona_ingreso" class="form-control" >
                    </div>
	            	</div>
	            </div>
	            <div class="row">
	                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                    <input type="submit" value="Grabar" class="btn cbtn-default hidden-xs" />
	                    <input type="submit" value="Grabar" class="btn cbtn-default btn-block visible-xs" />
	                    <input type="hidden" value="{{ route('admin.persona.identificaciones') }}"id="data-route" />
	                </div>
                </div>
                {{ Form::token() }}
                </form>
            </div>
    	</div>
    </div>
    <div class="col-lg-2 col-md-2 col-md-12 col-xs-12"></div>
</div>

@endsection('content')