@extends('layouts.pdf')
@section('content')

   @php
      $fecha = Carbon\Carbon::now()->format('d/m/Y');
   @endphp


   <table width="100%" style="{align: center}">
      <tr><td><h2>Vicentinos</h2></td></tr>
      <tr><td><h3>Estado de Cuenta Terceros tiempos, Micros y otros Gastos - No incluye Cuota Social</h3></td></tr>
      <tr><td><h4>{{$legajo->NOMBRE}}</h4></td></tr>
      <tr><td>Apodo {{$legajo->LEGAJO_ESCOLAR}}</td></tr>
      <tr><td>Saldo al {{ $fecha }} ${{ number_format( $legajo->saldo,2 )}}</td></tr>
      <tr><td>Categoria {{$legajo->Categoria->NOMBRE}}</td></tr>
   </table>

   <br>

   <table width="100%">
      <tr>
         <th>Fecha</th>
         <th>Concepto</th>
         <th class="importes">Debe</th>
         <th class="importes">Haber</th>
         <th class="fechas">U.Pago</th>

         <th class="importes">Saldo</th>
      </tr>

      @php
         $cuotas = $legajo->cuotas->sortBy('FECHA_1');
         $saldo = 0;
      @endphp

      @foreach($cuotas as $cuota)

         @php
            $saldo = $saldo + $cuota->IMPORTE_1;
            $saldo = $saldo - $cuota->importepagado   ;
         @endphp

         <tr>
            <td>{{ $cuota->FECHA_1->format('d/m/Y') }}</td>
            <td>{{ $cuota->liquidacion->concepto->NOMBRE }}</td>
            <td class="importes">{{ number_format( $cuota->IMPORTE_1,2) }}</td>
            <td class="importes">{{ number_format( $cuota->importepagado,2) }}</td>
            @if( is_null($cuota->ultimopago))
               <td></td>
            @else
               <td class="fechas">{{ $cuota->ultimopago->format('d/m/Y') }}</td>
            @endif
            <td class="importes">{{ number_format( $saldo,2) }}</td>
         </tr>

      @endforeach

   </table>


@endsection
