@extends('layouts.pdf')
@section('content')

   @php
      $fecha = Carbon\Carbon::now()->format('d/m/Y');
   @endphp


   <table width="70%" style="{align: center}">
      <tr><td><h2>Vicentinos</h2></td></tr>
      <tr><td><h3>Constancia de Pago</h3></td></tr>
      <tr><td><h4>Codigo {{$pago->CODIGO}}</h4></td></tr>
      <tr><td><h4>{{$pago->cuota->legajo->NOMBRE}}</h4></td></tr>
      <tr><td>Apodo {{$pago->cuota->legajo->LEGAJO_ESCOLAR}}</td></tr>
      <tr><td>Categoria {{$pago->cuota->legajo->Categoria->NOMBRE}}</td></tr>
   </table>

   <br>

   <table width="70%">
      <tr>
         <td>fecha</td>
         <td>{{ $pago->FECHA->format('d/m/Y') }}</td>
      </tr>

      <tr>
         <td>Importe abonado</td>
         <td>{{ number_format( $pago->IMPORTE,2 ) }}</td>
      </tr>

      <tr>
         <td>Firma Electronica</td>
         <td>{{ $pago->CODIGO }}{{ $pago->cuota->CODIGO }}{{ $pago->FECHA->format('Ymd') }}{{ $pago->IMPORTE }}</td>
      </tr>

      <tr>
         <td>Saldo de terceros y micros al {{ $fecha }}</td>
         <td>${{ number_format( $pago->cuota->legajo->saldo,2 )}}</td>
      </tr>


   </table>


@endsection
