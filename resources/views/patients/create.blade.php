@extends('layouts.app')

@section('title', 'Crear Paciente')

@section('content')
<h3 class="mb-3">Crear Paciente</h3>


<form method="POST" class="form-horizontal" action="{{ route('patients.store') }}">
    @csrf
    @method('POST')

    <div class="form-row">
        <fieldset class="form-group col-10 col-md-2">
            <label for="for_run">Run</label>
            <input type="number" class="form-control" id="for_run" name="run" autocomplete="off">
        </fieldset>

        <fieldset class="form-group col-2 col-md-1">
            <label for="for_dv">DV</label>
            <input type="text" class="form-control" id="for_dv" name="dv" autocomplete="off">
        </fieldset>

        <fieldset class="form-group col-12 col-md-4">
            <label for="for_other_identification">Otra identificación</label>
            <input type="text" class="form-control" id="for_other_identification"
                placeholder="Extranjeros sin run" name="other_identification" autocomplete="off">
        </fieldset>

        <fieldset class="form-group col-6 col-md-2">
            <label for="for_gender">Genero</label>
            <select name="gender" id="for_gender" class="form-control">
                <option value="male">Masculino</option>
                <option value="female">Femenino</option>
                <option value="other">Otro</option>
                <option value="unknown">Desconocido</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-6 col-md-2">
            <label for="for_birthday">Fecha Nacimiento</label>
            <input type="date" class="form-control" id="for_birthday"
                name="birthday" required>
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-12 col-md-4">
            <label for="for_name">Nombres*</label>
            <input type="text" class="form-control" id="for_name" name="name"
                style="text-transform: uppercase;"
                required autocomplete="off">
        </fieldset>

        <fieldset class="form-group col-12 col-md-4">
            <label for="for_fathers_family">Apellido Paterno*</label>
            <input type="text" class="form-control" id="for_fathers_family"
                name="fathers_family" style="text-transform: uppercase;"
                required autocomplete="off">
        </fieldset>

        <fieldset class="form-group col-12 col-md-4">
            <label for="for_mothers_family">Apellido Materno</label>
            <input type="text" class="form-control" id="for_mothers_family"
                name="mothers_family" style="text-transform: uppercase;" autocomplete="off">
        </fieldset>

    </div>

    <button type="submit" class="btn btn-primary">Guardar</button>

    <a class="btn btn-outline-secondary" href="{{ route('patients.index') }}">
        Cancelar
    </a>


</form>


@endsection

@section('custom_js')
<script src='{{asset("js/jquery.rut.chileno.js")}}'></script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        //obtiene digito verificador
        $('input[name=run]').keyup(function(e) {
            var str = $("#for_run").val();
            $('#for_dv').val($.rut.dv(str));
        });
    });
</script>
@endsection
