@extends('layouts.app')
@section('content')

   @include('layouts.menu')

   <div class="container">

      <div class="card">

         <form method="POST" action="/asistencia/{{ $asistencia->CODIGO }}/del">
            {{ csrf_field() }}


            <ul class="collection with-header">
               <li class="collection-header"><h4>Dia {{$asistencia->fecha->FECHA->format('d/m/Y')}} - {{$asistencia->fecha->OBSERVA}}</h4></li>
               <li class="collection-item"> {{$asistencia->legajo->NOMBRE}} </li>
               <li class="collection-item"> {{$asistencia->legajo->LEGAJO_ESCOLAR}} </li>
            </ul>

            <div class="card-action">
               <button type="submit" class="btn btn-primary">Eliminar</button>
               <a class="btn btn-link" href="/asistencia/{{$asistencia->fecha->CODIGO}}/edit">Cancelar</a>
            </div>


         </form>
      </div>


@endsection
