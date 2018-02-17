@extends('layouts.app')
@section('content')

   @include('layouts.menu')

   <div class="container">

      <div class="card">

         <ul class="collection with-header">
            <li class="collection-header"><h4>Dia {{$fecha->FECHA->format('d/m/Y')}} - {{$fecha->OBSERVA}}</h4></li>
            <li class="collection-item">
               Presentes: {{ $fecha->presentes }} -
               Ausentes: {{ $fecha->ausentes }} -
               Totales: {{ $fecha->totales }}
            </li>
         </ul>

         <form method="POST" action="/asistencia/{{$fecha->CODIGO}}/edit">

            {{ csrf_field() }}

            <div class="fixed-action-btn">
               <button type="submit" class="btn-floating btn-large green" >
                  <i class="large material-icons">check</i>
               </button>
               <a href="/asistencia/{{$fecha->CODIGO}}/add" class="btn-floating btn-large blue" >
                  <i class="large material-icons">add</i>
               </a>
            </div>


            <table class="responsive-table highlight">
               <thead>
                  <tr>
                     <th>Apodo</th>
                     <th>Nombre</th>
                     <th></th>
                     <th></th>

                  </tr>
               </thead>

               <tbody>

                  @foreach($fecha->asistencias as $asistencia)

                     <tr>
                        <td>{{ $asistencia->legajo->LEGAJO_ESCOLAR }}</td>
                        <td>{{ $asistencia->legajo->NOMBRE }}</td>

                        <td>
                           <div class="switch">
                              <label>
                                 Ausente
                                 @if($asistencia->PRESENTE=='0')
                                    <input type="checkbox" name="codigo[{{$asistencia->CODIGO}}]"  >
                                 @else
                                    <input type="checkbox" name="codigo[{{$asistencia->CODIGO}}]" checked="checked"  >
                                 @endif
                                 <span class="lever"></span>
                                 Presente
                              </label>
                           </div>

                        </td>

                        <td>
                           <a href="/asistencia/{{$asistencia->CODIGO}}/del" class="btn-floating btn-small red" >
                              <i class="large material-icons">delete</i>
                           </a>
                        </td>

                     </tr>

                  @endforeach


               </tbody>

            </table>

         </form>

      </div>
   </div>

@endsection
