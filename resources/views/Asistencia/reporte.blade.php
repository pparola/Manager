@extends('layouts.app')
@section('content')

   @include('layouts.menu')

   <div class="container">

      <div class="card">

         <table class="responsive-table highlight bordered">
            <thead>
               <tr>
                  <th>Apodo</th>
                  <th>Nombre</th>
                  @foreach($fechas as $fecha)
                     <th>{{$fecha->FECHA->format('d/m/Y')}}</th>
                  @endforeach
                  <th>Total</th>
                  <th class="right">%</th>
               </tr>
            </thead>

            <tbody>

               @foreach($reportes as $reporte)
                  <tr>
                     <td>{{ $reporte['APODO'] }}</td>
                     <td>{{ $reporte['NOMBRE'] }}</td>

                     @php
                        $cantidad = 0;
                        $presente = 0;
                     @endphp

                     @foreach($fechas as $fecha)
                        <td class="center">{{ $reporte[  $fecha->FECHA->format('d-m-Y') ] }}</td>
                        @php
                           $cantidad = $cantidad + 1;
                           if( $reporte[  $fecha->FECHA->format('d-m-Y') ] ==1 ){
                              $presente = $presente + 1;
                           }
                        @endphp
                     @endforeach

                     <td class="center">{{ $presente }}</td>
                     <td class="right">{{ number_format( $presente/$cantidad * 100,2) }}</td>

                  </tr>

               @endforeach


            </tbody>

         </table>

      </div>
   </div>

@endsection
