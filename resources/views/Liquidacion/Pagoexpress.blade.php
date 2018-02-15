@extends('layouts.app')
@section('content')

   @include('layouts.menu')

   @php

      $fecha = Carbon\Carbon::now()->format('d/m/Y');

   @endphp

   <div class="row">
      <div class="col">
         <form method="POST" action="/liquidacion/{{$cuota->CODIGO}}/pagoexpress">

            {{ csrf_field() }}
            <div class="card">

               <ul class="collection with-header">
                  <li class="collection-header"><h4>{{$cuota->legajo->NOMBRE}}</h4></li>
                  <li class="collection-item">{{$cuota->legajo->LEGAJO_ESCOLAR}}</li>
                  <li class="collection-item">email: {{$cuota->legajo->EMAIL}}</li>
                  <li class="collection-item">Saldo total: ${{ number_format( $cuota->legajo->saldo,2 )}}</li>

                  <li class="collection-item">Fecha: {{ $fecha }}</li>
                  <li class="collection-item">Importe: ${{ number_format( $cuota->saldocuota,2 )}}</li>

               </ul>

               <div class="card-action">
                  <button type="submit" class="btn btn-primary">Aceptar</button>
                  <a class="btn btn-link" href="/liquidacion/{{$cuota->LIQUIDACION}}/cuenta">Cancelar</a>
               </div>

            </div>
         </form>
      </div>
   </div>

@endsection
