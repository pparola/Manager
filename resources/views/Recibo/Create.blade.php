@extends('layouts.app')
@section('content')

   @include('layouts.menu')

   @php

      $fecha = Carbon\Carbon::now()->format('d/m/Y');

   @endphp

   <div class="row">
      <div class="col">
         <form method="POST" action="/pago/{{$cuota->CODIGO}}/create">

            {{ csrf_field() }}
            <div class="card">

               <ul class="collection with-header">
                  <li class="collection-header">{{$cuota->legajo->NOMBRE}}</li>
                  <li class="collection-item">{{$cuota->legajo->LEGAJO_ESCOLAR}}</li>
                  <li class="collection-item">email: {{$cuota->legajo->EMAIL}}</li>
                  <li class="collection-item">Saldo total: ${{ number_format( $cuota->legajo->saldo,2 )}}</li>
               </ul>

               <div class="card-content">
                  {{ csrf_field() }}

                  <div class="input-field ">
                     <input type="number" class="validate" step="any" name="IMPORTE" value="{{ $cuota->saldocuota }}" maxlength="12" required>
                     <label for="IMPORTE">Importe</label>
                  </div>

                  <div class="input-field ">
                     <input type="text" class="datepicker" name="FECHA" value="{{ $fecha }}" >
                     <label for="FECHA">Fecha</label>
                  </div>


               </div>
               <div class="card-action">
                  <button type="submit" class="btn btn-primary">Aceptar</button>
                  <a class="btn btn-link" href="/cuota/{{$cuota->LEGAJO}}/cuenta">Cancelar</a>
               </div>

            </div>
         </form>
      </div>
   </div>

@endsection
