@extends('layouts.app')
@section('content')

   @include('layouts.menu')

   @php
      $total = 0;
   @endphp

   <div class="container">

      <div class="card">

         <ul class="collection with-header">
            <li class="collection-header"><h3>Cobrado por {{ Auth::user()->name}}</h3></li>
            <li class="collection-header">

               <form method="GET" action="/pago" >
                  <div class="input-field inline ">
                     <input type="text" class="datepicker" name="FECHA" value="{{ $FECHA }}" >
                     <label for="FECHA">Fecha</label>
                  </div>

                  <button type="submit" class="btn-floating">
                     <i class="material-icons">search</i>
                  </button>
                  <a class="btn-floating" href="/pago/{{$FECHA}}/pdfListadoPago">
                     <i class="material-icons">attachment</i>
                  </a>
               </form>
            </li>
         </ul>

         <table class="responsive-table highlight">
            <thead>
               <tr>
                  <th>Apodo</th>
                  <th>Nombre</th>
                  <th>Concepto</th>
                  <th>Fecha</th>
                  <th>Importe</th>
                  <th></th>

               </tr>
            </thead>

            <tbody>

               @foreach($pagos as $pago)

                  @php

                     $total = $total + $pago->IMPORTE;

                  @endphp

                  <tr>
                     <td>{{ $pago->cuota->legajo->LEGAJO_ESCOLAR }}</td>
                     <td>{{ $pago->cuota->legajo->NOMBRE }}</td>
                     <td>{{ $pago->cuota->liquidacion->concepto->NOMBRE }}</td>
                     <td>{{ $pago->FECHA->format('d/m/Y') }}</td>
                     <td>{{ number_format( $pago->IMPORTE,2) }}</td>
                     <td>
                        <a class="btn-floating red" href="/pago/{{$pago->CODIGO}}/delete">
                           <i class="small material-icons">delete</i>
                        </a>
                     </td>

                  </tr>

               @endforeach


            </tbody>
         </table>

         <ul class="collection with-header">
            <li class="collection-header center"><strong> Importe Cobrado {{number_format( $total,2)}} </strong></li>
         </ul>

      </div>
   </div>

@endsection
