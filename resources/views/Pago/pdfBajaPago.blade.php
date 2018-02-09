@extends('layouts.pdf')
@section('content')



   <table width="70%" style="{align: center}">
      <tr><td><h2>Vicentinos</h2></td></tr>
      <tr><td><h3>Constancia de baja de Pago</h3></td></tr>
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
         <td>Importe Anulado</td>
         <td>{{ number_format( $pago->IMPORTE,2 ) }}</td>
      </tr>

      <tr>
         <td>Firma Electronica</td>
         <td>{{ $pago->CODIGO }}{{ $pago->cuota->CODIGO }}{{ $pago->FECHA->format('Ymd') }}{{ $pago->IMPORTE }}</td>
      </tr>

      <tr>
         <td colspan="2">Este pago fue anulado... si no es correcto contactese con su manager</td>
      </tr>


   </table>


@endsection
