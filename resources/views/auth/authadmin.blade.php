@extends('main')

@section('content')
<div class="row">
    <div class="col-lg-3 col-md-3 col-md-12 col-xs-12"></div>
    <div class="col-lg-6 col-md-6 col-md-12 col-xs-12">
    	<div class="panel panel-custom-admin">
    		<div class="panel-heading">
	            <h3 class="panel-title">Seleccione el tipo de menu</h3>
	        </div>
    		<div class="panel-body">
	            <div class="list-group">
		            <a href="{{ route('authvalidation', ['opcion' => 'normal']) }}" class="list-group-item" >Normal</a>
		            <a href="{{ route('authvalidation', ['opcion' => 'auxiliar']) }}" class="list-group-item" >Auxiliar</a>
	            </div>
            </div>
    	</div>
    </div>
    <div class="col-lg-3 col-md-3 col-md-12 col-xs-12"></div>
</div>



@endsection('content')