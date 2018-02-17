@extends('layouts.app')
@section('content')

   @include('layouts.menu')

   <div class="container">

      <div class="card">

         <form method="POST" action="/asistencia/{{ $fecha->CODIGO }}/add">
            {{ csrf_field() }}


            <ul class="collection with-header">
               <li class="collection-header"><h4>Dia {{$fecha->FECHA->format('d/m/Y')}} - {{$fecha->OBSERVA}}</h4></li>

               @foreach($asistencias as $asistencia)

                  <li class="collection-item">

                     <div class="switch">
                        <label>
                           Agregar
                           <input type="checkbox" name="codigo[{{ $asistencia['LEGAJO'] }}]"  >
                           <span class="lever"></span>
                           No Agregar
                        </label>
                     </div>

                     {{$asistencia['LEGAJO_ESCOLAR']}} -
                     {{$asistencia['NOMBRE']}}
                  </li>

               @endforeach
            </ul>

            <div class="card-action">
               <button type="submit" class="btn btn-primary">Agregar</button>
               <a class="btn btn-link" href="/asistencia/{{$fecha->CODIGO}}/edit">Cancelar</a>
            </div>


         </form>
      </div>


@endsection
