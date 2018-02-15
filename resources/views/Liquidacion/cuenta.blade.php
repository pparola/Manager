   @extends('layouts.app')
@section('content')

   @include('layouts.menu')

   <div class="container">

      <div class="card">

         @php
            $saldo = 0;
            foreach ($liquidacion->cuotas as $cuota){
               $saldo = $saldo + $cuota->importepagado;
            }
         @endphp

         <ul class="collection with-header">
            <li class="collection-header"><h4>Liquidacion {{$liquidacion->CODIGO}}</h4></li>
            <li class="collection-item">Concepto: {{$liquidacion->concepto->NOMBRE}}</li>
            <li class="collection-item">Fecha: {{$liquidacion->VENCIMIENTO_1->format('d/m/Y')}}</li>
            <li class="collection-item">
               Importe: ${{ number_format( $liquidacion->IMPORTE,2 )}}
               Cobrado: ${{ number_format( $saldo,2 )}}
               Saldo: ${{ number_format( $liquidacion->IMPORTE - $saldo,2 )}}

            </li>

         </ul>

         <table class="responsive-table highlight">
            <thead>
               <tr>
                  <th>Apodo</th>
                  <th>Nombre</th>
                  <th>Debe</th>
                  <th>Haber</th>
                  <th>U.Pago</th>
                  <th>Saldo</th>
                  <th></th>
               </tr>
            </thead>

            <tbody>

               @foreach($liquidacion->cuotas as $cuota)

                  @php
                     $saldo = 0;
                     $saldo = $saldo + $cuota->IMPORTE_1;
                     $saldo = $saldo - $cuota->importepagado;
                  @endphp

                  <tr>
                     <td>{{ $cuota->legajo->LEGAJO_ESCOLAR }}</td>
                     <td>{{ $cuota->legajo->NOMBRE }}</td>
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

                           @if( strlen($cuota->legajo->EMAIL)>0 )
                              <a class="btn-floating green" href="/liquidacion/{{ $cuota->CODIGO }}/pagoexpress">
                                 <i class="small material-icons">monetization_on</i>
                              </a>


                           @endif

                        @endif

                     </td>


                  </tr>

               @endforeach

            </tbody>
         </table>
      </div>

   </div>

@endsection
