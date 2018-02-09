@extends('layouts.app')
@section('content')

   @include('layouts.menu')

   <div class="container">

      <div class="card">

         <ul class="collection with-header">
            <li class="collection-header"><h4>{{$legajo->NOMBRE}}</h4></li>
            <li class="collection-item">{{$legajo->LEGAJO_ESCOLAR}}</li>
            <li class="collection-item">email: {{$legajo->EMAIL}}
               <a class="btn-floating blue" href="/cuota/{{$legajo->CODIGO}}/cambiaremail">
                  <i class="small material-icons">email</i>
               </a>
            </li>
            <li class="collection-item">Saldo: ${{ number_format( $legajo->saldo,2 )}}


               <a class="btn-floating" href="/cuota/{{$legajo->CODIGO}}/pdfcuenta">
                  <i class="material-icons">attachment</i>
               </a>

               @if( strlen($legajo->EMAIL)>0 )
                  @if($legajo->saldo>0)
                     <a class="btn-floating" href="/cuota/{{$legajo->CODIGO}}/mailcuenta">
                        <i class="material-icons">email</i>
                     </a>
                  @endif
               @endif
            </li>
         </ul>

         <div class="fixed-action-btn">
            <a class="btn-floating btn-large blue" href="/cuota/{{$legajo->CODIGO}}/create">
               <i class="large material-icons">add</i>
            </a>
         </div>

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


                           @if( strlen($legajo->EMAIL)>0 )
                              <a class="btn-floating green" href="/pago/{{ $cuota->CODIGO }}/create">
                                 <i class="small material-icons">payment</i>
                              </a>
                           @endif

                           <a class="btn-floating orange" href="/ajuste/{{ $cuota->CODIGO }}/create">
                              <i class="small material-icons">adjust</i>
                           </a>

                        @endif

                        @if( $cuota->importepagado==0 )
                           @if( strlen($legajo->EMAIL)>0 )
                              <a class="btn-floating red" href="/cuota/{{ $cuota->CODIGO }}/delete">
                                 <i class="small material-icons">delete</i>
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
