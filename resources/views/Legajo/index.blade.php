@extends('layouts.app')
@section('content')

   @include('layouts.menu')

   <div class="container">
      <div class="fixed-action-btn">
         <a class="btn-floating btn-large blue" href="/legajo/create">
            <i class="large material-icons">add</i>
         </a>
      </div>

      @php

         $cantidad = 0;
         $saldo = 0;

      @endphp


      <div class="card">

         <table class="responsive-table highlight">
            <thead>
               <tr>
                  <th>Apodo</th>
                  <th>Nombre</th>
                  <th>Email</th>
                  <th>Saldo</th>
                  <th>U.Pago</th>
                  <th></th>

               </tr>
            </thead>

            <tbody>

               @foreach($legajos as $legajo)

                  @php
                     $cantidad = $cantidad + 1;
                     $saldo = $saldo + $legajo->saldo;
                  @endphp

                  <tr>
                     <td>{{ $legajo->LEGAJO_ESCOLAR }}</td>
                     <td>{{ $legajo->NOMBRE }}</td>
                     <td>{{ $legajo->EMAIL }}</td>
                     <td>
                        {{ number_format( $legajo->saldo,2) }}
                        @if($legajo->DEREXA > 0)
                           <span class="badge lime">{{$legajo->DEREXA}}%</span>
                        @endif
                     </td>
                     @if(is_null( $legajo->ultimopago))
                        <td></td>
                     @else
                        <td>{{ $legajo->ultimopago->format('d/m/Y') }}</td>
                     @endif
                     <td>
                        <a class="btn-floating yellow darken-1" href="/legajo/{{ $legajo->CODIGO }}/edit">
                           <i class="small material-icons">edit</i>
                        </a>
                        <a class="btn-floating red" href="/legajo/{{ $legajo->CODIGO }}/delete">
                           <i class="small material-icons">delete</i>
                        </a>
                        <a class="btn-floating green" href="/cuota/{{ $legajo->CODIGO }}/cuenta">
                           <i class="small material-icons">attach_money</i>
                        </a>
                     </td>

                  </tr>

               @endforeach


            </tbody>

         </table>


         <table>
            <tr>
               <td>
                  Cantidad: {{ $cantidad }}
               </td>
               <td>
                  {{number_format( $saldo,2) }}
               </td>
            </tr>
         </table>


      </div>
   </div>

@endsection
