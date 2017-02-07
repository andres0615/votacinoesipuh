@extends('admin.main')

@section('content2')
    <div class="panel panel-custom-admin">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-cogs"></i> Acciones</h3>
        </div>
        <div class="panel-body">
            <div class="d-block hidden-xs">
                <a href="{{ route('admin.eleccion.create') }}" class="btn cbtn-success" ><i class="fa fa-plus"></i> Crear</a>
                <button type="button" class="btn cbtn-danger btn-eliminar-masivo" data-href="{{ route('admin.eleccion.destroyMass') }}" data-toggle="modal" data-target="#delete-modal" ><i class="fa fa-trash-o"></i> Eliminar</button>
            </div>
            <div class="d-block visible-xs">
                <a href="{{ route('admin.eleccion.create') }}" class="btn cbtn-success btn-block" ><i class="fa fa-plus"></i> Crear</a>
                <button type="button" class="btn cbtn-danger btn-block btn-eliminar-masivo" data-href="{{ route('admin.eleccion.destroyMass') }}" data-toggle="modal" data-target="#delete-modal" ><i class="fa fa-trash-o"></i> Eliminar</button>
            </div>
        </div>
    </div>
    <br />
    <div class="panel panel-custom-admin">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-user"></i> Eleccion</h3>
        </div>
        <table class="table table-bordered ctable">
            <thead>
            <tr>
                <th class="text-center" >
                    <input id="chk-all-records" type="checkbox" />
                </th>
                <th>Nombre</th>
                <th class="text-center" >Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($elecciones as $eleccion)
                <tr>
                    <td class="text-center" >
                        <input class="record-check" type="checkbox" data-codigo="{{ $eleccion->eleccion_id }}" />
                    </td>
                    <td>{{ $eleccion->eleccion_nombre }}</td>
                    <td class="text-center" >
                        <div class="d-block hidden-xs">
                            <a class="btn cbtn-success btn-xs" href="{{ route('admin.eleccion.edit',['id' => $eleccion->eleccion_id]) }}" >
                                <i class="fa fa-edit"></i> Editar
                            </a>
                            <button type="button" class="btn cbtn-danger btn-xs"
                                    data-toggle="modal" data-target="#delete-modal" data-href="{{ route('admin.eleccion.destroy',['id' => $eleccion->eleccion_id]) }}" >
                                <i class="fa fa-remove"></i> Eliminar
                            </button>
                        </div>
                        <div class="d-block visible-xs">
                            <a class="btn cbtn-success btn-xs" href="{{ route('admin.eleccion.edit',['id' => $eleccion->eleccion_id]) }}" >
                                <i class="fa fa-edit"></i>
                            </a>
                            <button type="button" class="btn cbtn-danger btn-xs"
                                    data-toggle="modal" data-target="#delete-modal" data-href="{{ route('admin.eleccion.destroy',['id' => $eleccion->eleccion_id]) }}" >
                                <i class="fa fa-remove"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {!! $elecciones->render() !!}
@endsection('content2')
