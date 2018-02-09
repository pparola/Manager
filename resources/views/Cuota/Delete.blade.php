@extends('layouts.app')
@section('content')

   @include('layouts.menu')

   <div class="row">
      <div class="col">
         <form method="POST" action="/cuota/{{$cuota->CODIGO}}/delete">


            {{ csrf_field() }}
            <div class="card">

               <ul class="collection with-header">
                  <li class="collection-header">{{ $cuota->legajo->NOMBRE}}</li>
                  <li class="collection-item">{{ $cuota->legajo->LEGAJO_ESCOLAR }}</li>
                  <li class="collection-item">email: {{ $cuota->legajo->EMAIL}}</li>
                  <li class="collection-item">Cuota: {{ $cuota->CODIGO }}</li>
                  <li class="collection-item">Concepto: {{ $cuota->liquidacion->concepto->NOMBRE }}</li>
                  <li class="collection-item">Fecha: {{ $cuota->FECHA_1->format('d/m/Y') }}</li>
                  <li class="collection-item">Importe: {{ number_format( $cuota->IMPORTE_1,2) }}</li>
               </ul>

               <div class="card-action">
                  <button type="submit" class="btn btn-primary">Aceptar</button>
                  <a class="btn btn-link" href="/cuota/{{$cuota->legajo->CODIGO}}/cuenta">Cancelar</a>
               </div>

            </div>
         </form>
      </div>
   </div>



@endsection
