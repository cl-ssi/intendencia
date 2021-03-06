@extends('layouts.app')

@section('title', 'Editar sospecha')

@section('content')
<h3 class="mb-3">Editar sospecha {{ $suspectCase->id }}</h3>

@include('patients.show',$suspectCase)

<hr>

@if(!$suspectCase->reception_at)
    <h2 class="text-danger">Examen no recepcionado</h2>

    @if(Auth::user()->laboratory)
    <form method="POST" class="form-inline" action="{{ route('lab.suspect_cases.reception', $suspectCase) }}">
        @csrf
        @method('POST')
        <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-inbox"></i></button>
    </form>
    @endif
@endif

<form method="POST" class="form-horizontal" action="{{ route('lab.suspect_cases.update', $suspectCase) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="form-row">

        <fieldset class="form-group col-5 col-md-3">
            <label for="for_sample_at">Fecha Muestra</label>
            <input type="datetime-local" class="form-control" id="for_sample_at"
                name="sample_at" value="{{ $suspectCase->sample_at->format('Y-m-d\TH:i:s') }}">
        </fieldset>

        <fieldset class="form-group col-7 col-md-3">
            <label for="for_sample_type">Tipo de Muestra</label>
            <select name="sample_type" id="for_sample_type" class="form-control">
                <option value=""></option>
                <option value="TÓRULAS NASOFARÍNGEAS" {{ ($suspectCase->sample_type == 'TÓRULAS NASOFARÍNGEAS')?'selected':'' }}>TORULAS NASOFARINGEAS</option>
                <option value="ESPUTO" {{ ($suspectCase->sample_type == 'ESPUTO')?'selected':'' }}>ESPUTO</option>
                <option value="TÓRULAS NASOFARÍNGEAS/ESPUTO" {{ ($suspectCase->sample_type == 'TÓRULAS NASOFARÍNGEAS/ESPUTO')?'selected':'' }}>TÓRULAS NASOFARÍNGEAS/ESPUTO</option>
                <option value="ASPIRADO NASOFARÍNGEO" {{ ($suspectCase->sample_type == 'ASPIRADO NASOFARÍNGEO')?'selected':'' }}>ASPIRADO NASOFARÍNGEO</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_establishment_id">Establecimiento</label>
            <select name="establishment_id" id="for_establishment_id" class="form-control">
                <option value=""></option>
                @foreach($establishments as $establishment)
                    <option value="{{ $establishment->id }}" {{ ($establishment->id == $suspectCase->establishment_id)?'selected':'' }}>{{ $establishment->alias }}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_origin">Estab. Detalle (Opcional)</label>
            <select name="origin" id="for_origin" class="form-control">
                <option value=""></option>
                @foreach($sampleOrigins as $sampleOrigin)
                    <option value="{{ $sampleOrigin->name }}" {{ ($suspectCase->origin == $sampleOrigin->name)?'selected':'' }}>
                        {{ $sampleOrigin->alias }}
                    </option>
                @endforeach
            </select>
        </fieldset>

    </div>


    <div class="form-row">

        @can('SuspectCase: tecnologo')

        <fieldset class="form-group col-6 col-md-3 alert-warning">
            <label for="for_result_ifd_at">Fecha Resultado IFD</label>
            <input type="datetime-local" class="form-control" id="for_result_ifd_at"
                name="result_ifd_at" value="{{( isset($suspectCase->result_ifd_at))?  $suspectCase->result_ifd_at->format('Y-m-d\TH:i:s'):'' }}"
                >
        </fieldset>

        <fieldset class="form-group col-6 col-md-2 alert-warning">
            <label for="for_result_ifd">Resultado IFD</label>
            <select name="result_ifd" id="for_result_ifd" class="form-control">
                <option></option>
                <option value="Negativo"
                    {{ ($suspectCase->result_ifd == 'Negativo')?'selected':'' }}>
                    Negativo
                </option>
                <option value="Adenovirus"
                    {{ ($suspectCase->result_ifd == 'Adenovirus')?'selected':'' }}>
                    Adenovirus
                </option>
                <option value="Influenza A"
                    {{ ($suspectCase->result_ifd == 'Influenza A')?'selected':'' }}>
                    Influenza A
                </option>
                <option value="Influenza B"
                    {{ ($suspectCase->result_ifd == 'Influenza B')?'selected':'' }}>
                    Influenza B
                </option>
                <option value="Metapneumovirus"
                    {{ ($suspectCase->result_ifd == 'Metapneumovirus')?'selected':'' }}>
                    Metapneumovirus
                </option>
                <option value="Parainfluenza 1"
                    {{ ($suspectCase->result_ifd == 'Parainfluenza 1')?'selected':'' }}>
                    Parainfluenza 1
                </option>
                <option value="Parainfluenza 2"
                    {{ ($suspectCase->result_ifd == 'Parainfluenza 2')?'selected':'' }}>
                    Parainfluenza 2
                </option>
                <option value="Parainfluenza 3"
                    {{ ($suspectCase->result_ifd == 'Parainfluenza 3')?'selected':'' }}>
                    Parainfluenza 3
                </option>
                <option value="VRS"
                    {{ ($suspectCase->result_ifd == 'VRS')?'selected':'' }}>
                    VRS
                </option>
                <option value="No solicitado"
                    {{ ($suspectCase->result_ifd == 'No solicitado')?'selected':'' }}>
                    No solicitado
                </option>
                </select>
        </fieldset>


        <fieldset class="form-group col-6 col-md-2 alert-warning">
            <label for="for_subtype">Subtipo</label>
            <select name="subtype" id="for_subtype" class="form-control">
                <option value=""></option>
                <option value="H1N1" {{ ($suspectCase->subtype == "H1N1")?'selected':'' }}>H1N1</option>
                <option value="H3N2" {{ ($suspectCase->subtype == "H3N2")?'selected':'' }}>H3N2</option>
                <option value="INF B" {{ ($suspectCase->subtype == "INF B")?'selected':'' }}>INF B</option>
            </select>
        </fieldset>

        @endcan

        <fieldset class="form-group col-1 col-md-2">
            <label for="for_dumy"></label>
            <p></p>
        </fieldset>

        <fieldset class="form-group col-5 col-md-3">
            <label for="for_laboratory_id">Laboratorio local</label>
            <select name="laboratory_id" id="for_laboratory_id" class="form-control">
                <option value=""></option>
                @foreach($local_labs as $local_lab)
                <option value="{{ $local_lab->id }}"  {{ ($suspectCase->laboratory_id == $local_lab->id)?'selected':'' }}>{{ $local_lab->name }}</option>
                @endforeach
            </select>
        </fieldset>



    </div>

    @can('SuspectCase: tecnologo')

    <div class="form-row">

        <fieldset class="form-group col-6 col-md-3 alert-danger">
            <label for="for_pscr_sars_cov_2_at">Fecha Resultado PCR</label>
            <input type="datetime-local" class="form-control" id="for_pscr_sars_cov_2_at"
                name="pscr_sars_cov_2_at" value="{{ isset($suspectCase->pscr_sars_cov_2_at)? $suspectCase->pscr_sars_cov_2_at->format('Y-m-d\TH:i:s'):'' }}"
                @if(($suspectCase->pscr_sars_cov_2_at AND auth()->user()->cannot('SuspectCase: tecnologo edit'))) disabled @endif>
        </fieldset>

        <fieldset class="form-group col-6 col-md-2 alert-danger">
            <label for="for_pscr_sars_cov_2">PCR SARS-Cov2</label>
            <select name="pscr_sars_cov_2" id="for_pscr_sars_cov_2"
                class="form-control" @if(($suspectCase->pscr_sars_cov_2 != 'pending' AND auth()->user()->cannot('SuspectCase: tecnologo edit'))) disabled @endif>
                <option value="pending" {{ ($suspectCase->pscr_sars_cov_2 == 'pending')?'selected':'' }}>Pendiente</option>
                <option value="negative" {{ ($suspectCase->pscr_sars_cov_2 == 'negative')?'selected':'' }}>Negativo</option>
                <option value="positive" {{ ($suspectCase->pscr_sars_cov_2 == 'positive')?'selected':'' }}>Positivo</option>
                <option value="rejected" {{ ($suspectCase->pscr_sars_cov_2 == 'rejected')?'selected':'' }}>Rechazado</option>
                <option value="undetermined" {{ ($suspectCase->pscr_sars_cov_2 == 'undetermined')?'selected':'' }}>Indeterminado</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-6 col-md-2">
            <label for="for_sent_isp_at">Fecha envío lab externo</label>
            <input type="date" class="form-control" id="for_sent_isp_at"
                name="sent_isp_at" value="{{ isset($suspectCase->sent_isp_at)? $suspectCase->sent_isp_at->format('Y-m-d'):'' }}">
        </fieldset>

        <fieldset class="form-group col-6 col-md-2">
            <label for="for_external_laboratory">Laboratorio externo</label>
            <select name="external_laboratory" id="for_external_laboratory" class="form-control">
                <option value=""></option>
                @foreach($external_labs as $external_lab)
                <option value="{{ $external_lab->name }}"  {{ ($suspectCase->external_laboratory == $external_lab->name)?'selected':'' }}>{{ $external_lab->name }}</option>
                @endforeach
            </select>
        </fieldset>


        <fieldset class="form-group col-12 col-md-3">
            <label for="for_file">Archivo</label>
            <div class="custom-file">
                <input type="file" name="forfile[]" class="custom-file-input" id="forfile" lang="es" multiple>
                <label class="custom-file-label" for="customFileLang">Seleccionar Archivo</label>
            </div>
            @if($suspectCase->files != null)
                @foreach($suspectCase->files as $file)
                    <a href="{{ route('lab.suspect_cases.download', $file->id) }}"
                        target="_blank" data-toggle="tooltip" data-placement="top"
                        data-original-title="{{ $file->name }}">Resultado <i class="fas fa-paperclip"></i>&nbsp
                    </a>
                    @can('SuspectCase: file delete')
                     - <a href="{{ route('lab.suspect_cases.fileDelete', $file->id) }}" onclick="return confirm('Estás seguro Cesar?')">
                        [ Borrar ]
                    </a>
                    @endcan
                @endforeach
            @endif
        </fieldset>
    </div>

    <hr>

    <div class="form-row">

        <fieldset class="form-group col-6 col-md-2">
            <label for="for_functionary">Funcionario de Salud</label>
            <select name="functionary" id="for_functionary" class="form-control">
                <option value=""></option>
                <option value="0" {{ ($suspectCase->functionary === '0') ? 'selected' : '' }}>No</option>
                <option value="1" {{ ($suspectCase->functionary == '1') ? 'selected' : '' }}>Si</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-6 col-md-1">
            <label for="for_symptoms">Sintomas</label>
            <select name="symptoms" id="for_symptoms" class="form-control">
                <option value=""></option>
                <option value="Si" {{ ($suspectCase->symptoms == 'Si') ? 'selected' : '' }}>Si</option>
                <option value="No" {{ ($suspectCase->symptoms == 'No') ? 'selected' : '' }}>No</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-6 col-md-1">
            <label for="for_gestation">Gestante *</label>
            <select name="gestation" id="for_gestation" class="form-control" required>
                <option value=""></option>
                <option value="0" {{ ($suspectCase->gestation === 0) ? 'selected' : '' }}>No</option>
                <option value="1" {{ ($suspectCase->gestation == 1) ? 'selected' : '' }}>Si</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-6 col-md-2">
            <label for="for_gestation_week">Semanas de gestación</label>
            <input type="text" class="form-control" name="gestation_week"
                id="for_gestation_week" value="{{ $suspectCase->gestation_week }}">
        </fieldset>

        <fieldset class="form-group col-6 col-md-2">
            <label for="for_close_contact">Contacto estrecho</label>
            <select name="close_contact" id="for_close_contact" class="form-control">
                <option value=""></option>
                <option value="0" {{ ($suspectCase->close_contact === 0) ? 'selected' : '' }}>No</option>
                <option value="1" {{ ($suspectCase->close_contact == 1) ? 'selected' : '' }}>Si</option>
            </select>
        </fieldset>

        {{-- <fieldset class="form-group col-6 col-md-2">
            <label for="for_discharge_test">Test de salida</label>
            <select name="discharge_test" id="for_discharge_test" class="form-control">
                <option value=""></option>
                <option value="0" {{ ($suspectCase->discharge_test === 0) ? 'selected' : '' }}>No</option>
                <option value="1" {{ ($suspectCase->discharge_test == 1) ? 'selected' : '' }}>Si</option>
            </select>
        </fieldset> --}}


        <fieldset class="form-group col-6 col-md-4">
            <label for="for_status">Estado</label>
            <p>
                <strong>{{ $suspectCase->patient->status }}</strong>
                @can('Patient: edit')
                <a href="{{ route('patients.edit',$suspectCase->patient)}}"> Cambiar </a>
                @endcan
            </p>
        </fieldset>

    </div>

    <div class="form-row">

        <fieldset class="form-group col-12 col-md-6">
            <label for="for_observation">Observación</label>
            <input type="text" class="form-control" name="observation"
                id="for_observation" value="{{ $suspectCase->observation }}">
        </fieldset>


        <fieldset class="form-group col-6 col-md-2">
            <label for="for_paho_flu">PAHO FLU</label>
            <input type="number" class="form-control" name="paho_flu" id="for_paho_flu"
                value="{{ $suspectCase->paho_flu }}">
        </fieldset>

        <fieldset class="form-group col-6 col-md-2">
            <label for="for_run_medic">Run Médico Solicitante *</label>
            <input type="text" class="form-control" name="run_medic" id="for_run_medic"
                value="{{ $suspectCase->run_medic }}">
        </fieldset>

        <fieldset class="form-group col-6 col-md-2">
            <label for="for_epivigila">Epivigila *</label>
            <input type="number" class="form-control" id="for_epivigila"
                name="epivigila" min="0" value="{{ $suspectCase->epivigila }}">
        </fieldset>

    </div>

    <hr>

@endcan


    <h4>Entrega de resultados a paciente</h4>

    <div class="form-row">

        <fieldset class="form-group col-6 col-md-2">
            <label for="for_notification_at">Fecha de notificación</label>
            <input type="date" class="form-control" name="notification_at"
                id="for_notification_at" value="{{ ($suspectCase->notification_at)?$suspectCase->notification_at->format('Y-m-d'):'' }}">
        </fieldset>

        <fieldset class="form-group col-6 col-md-3">
            <label for="for_notification_mechanism">Mecanismo de Notificación</label>
            <select name="notification_mechanism" id="for_notification_mechanism" class="form-control">
                <option></option>
                <option value="Pendiente"
                    {{ ($suspectCase->notification_mechanism == 'Pendiente')?'selected':'' }}>
                    Pendiente</option>
                <option value="Llamada telefónica"
                    {{ ($suspectCase->notification_mechanism == 'Llamada telefónica')?'selected':'' }}>
                    Llamada telefónica</option>
                <option value="Correo electrónico"
                    {{ ($suspectCase->notification_mechanism == 'Correo electrónico')?'selected':'' }}>
                    Correo electrónico</option>
                <option value="Visita domiciliaria"
                    {{ ($suspectCase->notification_mechanism == 'Visita domiciliaria')?'selected':'' }}>
                    Visita domiciliaria</option>
                <option value="Centro de salud"
                    {{ ($suspectCase->notification_mechanism == 'Centro de salud')?'selected':'' }}>
                    Centro de salud</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-6 col-md-2">
            <label for="for_discharged_at">Fecha de alta</label>
            <input type="date" class="form-control" name="discharged_at"
                id="for_discharged_at" value="{{ ($suspectCase->discharged_at)?$suspectCase->discharged_at->format('Y-m-d'):'' }}">
        </fieldset>

    </div>


    <button type="submit" class="btn btn-primary">Guardar</button>

    <a class="btn btn-outline-secondary" href="{{ route('lab.suspect_cases.index') }}">
        Cancelar
    </a>
</form>

@can('SuspectCase: delete')
<form method="POST" class="form-horizontal" action="{{ route('lab.suspect_cases.destroy',$suspectCase) }}">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger float-right" onclick="return confirm('¿Está seguro de eliminar esta sospecha?');">Eliminar</button>
</form>
@endcan

<h4 class="mt-4">Otros Examenes realizados</h4>

<table class="table table-sm table-bordered small mb-4 mt-4">
    <thead>
        <tr>
            <th>Id</th>
            <th>Establecimiento</th>
            <th>Fecha muestra</th>
            <th>Fecha resultado</th>
            <th>Resultado</th>
            <th>Epivigila</th>
            <th>Observacion</th>
        </tr>
    </thead>
    <tbody>
        @foreach($suspectCase->patient->suspectCases->where('id','<>',$suspectCase->id) as $case)
        <tr>
            <td>
                <a href="{{ route('lab.suspect_cases.edit', $case )}}">
                {{ $case->id }}
                </a>
            </td>
            <td>{{ ($case->establishment) ? $case->establishment->alias : '' }}</td>
            <td>{{ $case->sample_at }}</td>
            <td>{{ $case->pscr_sars_cov_2_at }}</td>
            <td>{{ $case->covid19 }}</td>
            <td>{{ $case->epivigila }}</td>
            <td>{{ $case->observation }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@can('Admin')
<table class="table table-sm small text-muted mt-3">
    <thead>
        <tr>
            <th colspan="4">Historial de cambios</th>
        </tr>
        <tr>
            <th>Modelo</th>
            <th>Fecha</th>
            <th>Usuario</th>
            <th>Modificaciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($suspectCase->logs->sortByDesc('created_at') as $log)
        <tr>
            <td>{{ $log->model_type }}</td>
            <td>{{ $log->created_at }}</td>
            <td>{{ $log->user->name }}</td>
            <td>
                @foreach($log->diferencesArray as $key => $diference)
                    {{ $key }} => {{ $diference}} <br>
                @endforeach
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endcan

@endsection

@section('custom_js')
<script>
    $(document).ready(function(){
        $("#forfile").change(function(){
            @if($suspectCase->files->count() != 0)
                document.getElementById("forfile").value = "";
                alert("Solo se permite adjuntar un archivo.");
            @endif
        });
    });

    $('input[type="file"]').change(function(e){
        var fileName = e.target.files[0].name;
        $('.custom-file-label').html(fileName);
    });
</script>
@endsection
