@extends('layouts.app')
@section('content')

   @include('layouts.menu')

   <div class="container">
      <div class="fixed-action-btn">
         <a class="btn-floating btn-large blue" href="/asistencia/create">
            <i class="large material-icons">add</i>
         </a>
      </div>

      <div class="card">

         <table class="responsive-table highlight">
            <thead>
               <tr>
                  <th>Fecha</th>
                  <th>Observacion</th>
                  <th>Presentes</th>
                  <th>Auserntes</th>
                  <th>Totales</th>
                  <th>%</th>
                  <th></th>

               </tr>
            </thead>

            <tbody>

               @foreach($fechas as $fecha)

                  <tr>
                     <td>{{ $fecha->FECHA->format('d/m/Y') }}</td>
                     <td>{{ $fecha->OBSERVA }}</td>
                     <td>{{ $fecha->presentes }}</td>
                     <td>{{ $fecha->ausentes }}</td>
                     <td>{{ $fecha->totales }}</td>
                     <td>{{ number_format( $fecha->presentes / $fecha->totales * 100,2) }}</td>

                     <td>
                        <a class="btn-floating yellow" href="/asistencia/{{ $fecha->CODIGO }}/edit">
                           <i class="small material-icons">mode_edit</i>
                        </a>
                        <a class="btn-floating red" href="/asistencia/{{ $fecha->CODIGO }}/delete">
                           <i class="small material-icons">delete</i>
                        </a>
                     </td>
                  </tr>

               @endforeach


            </tbody>

         </table>

      </div>
   </div>

@endsection
