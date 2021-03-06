@extends('admin.main')

@section('assets2')
    <script src="{{ asset('javascripts/admin/persona/index.js') }}" ></script>
@endsection('assets2')

@section('content2')
    <div class="panel panel-custom-admin">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-cogs"></i> Acciones</h3>
        </div>
        <div class="panel-body">
            <div class="d-block hidden-xs">
                <a href="{{ route('admin.persona.create') }}" class="btn cbtn-success" ><i class="fa fa-plus"></i> Crear</a>
                <button type="button" class="btn cbtn-danger btn-eliminar-masivo" data-href="{{ route('admin.persona.destroyMass') }}" data-toggle="modal" data-target="#delete-modal" ><i class="fa fa-trash-o"></i> Eliminar</button>
                <a href="{{ route('admin.persona.reporte.general') }}" class="btn cbtn-default" ><i class="fa fa-list-alt"></i> Reporte general</a>
                <a href="{{ route('admin.persona.reporte.ingreso') }}" class="btn cbtn-default" ><i class="fa fa-list-alt"></i> Ingreso personas</a>
                <a href="{{ route('admin.persona.general.salida') }}" class="btn cbtn-default" ><i class="fa fa-sign-out"></i> Dar salida general</a>
            </div>
            <div class="d-block visible-xs">
                <a href="{{ route('admin.persona.create') }}" class="btn cbtn-success btn-block" ><i class="fa fa-plus"></i> Crear</a>
                <button type="button" class="btn cbtn-danger btn-block btn-eliminar-masivo" data-href="{{ route('admin.persona.destroyMass') }}" data-toggle="modal" data-target="#delete-modal" ><i class="fa fa-trash-o"></i> Eliminar</button>
                <a href="{{ route('admin.persona.reporte.general') }}" class="btn cbtn-default btn-block" ><i class="fa fa-list-alt"></i> Reporte general</a>
                <a href="{{ route('admin.persona.reporte.ingreso') }}" class="btn cbtn-default btn-block" ><i class="fa fa-list-alt"></i> Ingreso personas</a>
                <a href="{{ route('admin.persona.general.salida') }}" class="btn cbtn-default btn-block" ><i class="fa fa-sign-out"></i> Dar salida general</a>
            </div>
        </div>
    </div>
    <br />
    <div class="panel panel-custom-admin">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-user"></i> Personas</h3>
        </div>
        <table class="table table-bordered ctable">
            <thead>
            <tr>
                <th class="text-center" >
                    <input id="chk-all-records" type="checkbox" />
                </th>
                <th>Nombre</th>
                <th class="hidden-xs" >Apellido</th>
                <th class="text-center" >Candidato</th>
                <th class="text-center" >Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($personas as $persona)
                <tr>
                    <td class="text-center" >
                        <input class="record-check" type="checkbox" data-codigo="{{ $persona->persona_id }}" />
                    </td>
                    <td>{{ $persona->persona_nombre }}</td>
                    <td class="hidden-xs" >{{ $persona->persona_apellido }}</td>
                    <td class="text-center" >
                        <input type="checkbox" {{ ($persona->candidato)?'checked':'' }} class="persona_candidato" data-persona-id="{{ $persona->persona_id }}" data-url="{{ route('admin.persona.candidato') }}" data-token="{{ csrf_token() }}" />
                    </td>
                    <td class="text-center" >
                        <div class="d-block hidden-xs">
                            <a class="btn cbtn-success btn-xs" href="{{ route('admin.persona.edit',['id' => $persona->persona_id]) }}" >
                                <i class="fa fa-edit"></i> Editar
                            </a>
                            <button type="button" class="btn cbtn-danger btn-xs"
                                    data-toggle="modal" data-target="#delete-modal" data-href="{{ route('admin.persona.destroy',['id' => $persona->persona_id]) }}" >
                                <i class="fa fa-remove"></i> Eliminar
                            </button>
                        </div>
                        <div class="d-block visible-xs">
                            <a class="btn cbtn-success btn-xs" href="{{ route('admin.persona.edit',['id' => $persona->persona_id]) }}" >
                                <i class="fa fa-edit"></i>
                            </a>
                            <button type="button" class="btn cbtn-danger btn-xs"
                                    data-toggle="modal" data-target="#delete-modal" data-href="{{ route('admin.persona.destroy',['id' => $persona->persona_id]) }}" >
                                <i class="fa fa-remove"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {!! $personas->render() !!}
@endsection('content2')