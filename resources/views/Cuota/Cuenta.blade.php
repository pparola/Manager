@extends('layouts.app')
@section('content')

   @include('layouts.menu')

   <div class="container">

      <div class="card">

         <ul class="collection with-header">
            <li class="collection-header"><h4>{{$legajo->NOMBRE}}</h4></li>
            <li class="collection-item">{{$legajo->LEGAJO_ESCOLAR}}</li>
            <li class="collection-item">email: {{$legajo->EMAIL}}</li>
            <li class="collection-item">Saldo: ${{ number_format( $legajo->saldo,2 )}}</li>
            <li class="collection-item">
               <a class="btn" href="/cuota/{{$legajo->CODIGO}}/pdfcuenta">Emitir Informe</a>
               <a class="btn" href="/cuota/{{$legajo->CODIGO}}/mailcuenta">Enviar Mail</a>
               <a class="btn" href="/legajo">Volver</a>
            </li>
         </ul>

         <table class="responsive-table highlight">
            <thead>
               <tr>
                  <th>Fecha</th>
                  <th>Concepto</th>
                  <th>Debe</th>
                  <th>Haber</th>
                  <th>U.Pago</th>
                  <th>Saldo</th>
                  <th></th>
               </tr>
            </thead>

            <tbody>

               @php
                  $cuotas = $legajo->cuotas->sortBy('FECHA_1');
                  $saldo = 0;
               @endphp

               @foreach($cuotas as $cuota)

                  @php
                     $saldo = $saldo + $cuota->IMPORTE_1;
                     $saldo = $saldo - $cuota->importepagado;
                  @endphp

                  <tr>
                     <td>{{ $cuota->FECHA_1->format('d/m/Y') }}</td>
                     <td>{{ $cuota->liquidacion->concepto->NOMBRE }}</td>
                     <td>{{ number_format( $cuota->IMPORTE_1,2) }}</td>
                     <td>{{ number_format( $cuota->importepagado,2) }}</td>
                     @if( is_null($cuota->ultimopago))
                        <td></td>
                     @else
                        <td>{{ $cuota->ultimopago->format('d/m/Y') }}</td>
                     @endif
                     <td>{{ number_format( $saldo,2) }}</td>

                     <td>
                        @if( $cuota->saldocuota > 0 )
                           <a class="btn-floating green" href="/pago/{{ $cuota->CODIGO }}/create">
                              <i class="small material-icons">payment</i>
                           </a>
                        @endif
                     </td>

                  </tr>

               @endforeach

            </tbody>
         </table>
      </div>


   </div>

@endsection
