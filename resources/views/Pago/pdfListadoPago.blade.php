@extends('layouts.pdf')
@section('content')


   <table width="100%" >
      <tr><td><h2>Vicentinos</h2></td></tr>
      <tr><td><h3>Reporte de Cobranzas del dia {{$fecha}}</h3></td></tr>
      <tr><td>Categoria {{Auth::user()->categoria->NOMBRE}} Manager {{Auth::user()->name}}</td></tr>
   </table>

   <br>

   <table width="100%">
      <tr>
         <th>Apodo</th>
         <th>Nombre</th>
         <th>Concepto</th>
         <th class="fechas">fecha</th>
         <th class="importes">Importe</th>
      </tr>

      @foreach ($pagos as $pago)


         <tr>
            <td>{{ $pago->cuota->legajo->LEGAJO_ESCOLAR }}</td>
            <td>{{ $pago->cuota->legajo->NOMBRE }}</td>
            <td>{{ $pago->cuota->liquidacion->concepto->NOMBRE }}</td>
            <td class="fechas">{{ $pago->FECHA->format('d/m/Y') }}</td>
            <td class="importes">{{ number_format( $pago->IMPORTE,2) }}</td>

         </tr>
      @endforeach

      <tr>
         <td colspan="4">Cantidad {{$pagos->count()}}</td>
         <td class="importes">{{number_format( $pagos->sum('IMPORTE'),2) }}</td>
      </tr>


   </table>



@endsection
