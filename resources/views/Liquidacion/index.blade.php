@extends('layouts.app')
@section('content')

   @include('layouts.menu')

   <div class="container">
      <div class="fixed-action-btn">
         <a class="btn-floating btn-large blue" href="/liquidacion/create">
            <i class="large material-icons">add</i>
         </a>
      </div>

      @php

         $cantidad = 0;
         $importe = 0;
         $pagado = 0;

      @endphp


      <div class="card">

         <table class="responsive-table highlight">
            <thead>
               <tr>
                  <th>Fecha</th>
                  <th>Concepto</th>
                  <th>Importe</th>
                  <th>Cobrado</th>
                  <th>%Mora</th>
                  <th></th>

               </tr>
            </thead>

            <tbody>

               @foreach($liquidaciones as $liquidacion)

                  @php
                     $cantidad = $cantidad + 1;
                     $importe = $importe + $liquidacion->importe;
                     $pagadoliquidacion = 0;
                     foreach ($liquidacion->cuotas as $cuota){
                        $x = $cuota->importe_pagado_puro;
                        $pagado = $pagado + $x;
                        $pagadoliquidacion = $pagadoliquidacion + $x;
                     }
                  @endphp

                  @if($liquidacion->importe > 0)

                     <tr>
                        <td>{{ $liquidacion->VENCIMIENTO_1->format('d/m/Y') }}</td>
                        <td>{{ $liquidacion->concepto->NOMBRE }}</td>
                        <td>{{ number_format( $liquidacion->importe,2) }}</td>
                        <td>{{ number_format( $pagadoliquidacion,2) }}</td>

                        <td>{{ number_format(( $pagadoliquidacion / $liquidacion->importe)*100 ,2) }}</td>
                        <td>
                           <a class="btn-floating yellow" href="/liquidacion/{{ $liquidacion->CODIGO }}/cuenta">
                              <i class="small material-icons">pageview</i>
                           </a>
                           @if($pagadoliquidacion==0)
                              <a class="btn-floating red" href="/liquidacion/{{ $liquidacion->CODIGO }}/delete">
                                 <i class="small material-icons">delete</i>
                              </a>
                           @endif
                        </td>
                     </tr>
                  @endif

               @endforeach


            </tbody>

         </table>


         <table>
            <tr>
               <td>
                  Cantidad: {{ $cantidad }}
               </td>
               <td>
                  {{number_format( $importe,2) }}
               </td>
               <td>
                  {{number_format( $pagado ,2) }}
               </td>

               <td>
                  @if($importe!=0)
                     {{number_format( ($pagado/$importe)*100 ,2) }}
                  @endif
               </td>

            </tr>
         </table>


      </div>
   </div>

@endsection
